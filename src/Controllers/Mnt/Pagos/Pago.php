<?php
namespace Controllers\Mnt\pagos;

use Controllers\PublicController;
use Views\Renderer;

class Pago extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nuevo Pago",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
    private $estadoOptions = array(
        "ACT" => "Activo",
        "INA" => "Inactivo"
    );
    private $_viewData = array(
        "mode"=>"INS",
        "id"=>0,
        "fecha"=>"",
        "cliente"=>"",
        "monto"=>"",
        "fechaVencimiento"=>"",
        "estado"=>"ACT",
        "modeDsc"=>"",
        "readonly"=>false,
        "isInsert"=>false,
        "estadoOptions"=>[],
        "crsxToken"=>""
    );
    private function init(){
        if (isset($_GET["mode"])) {
            $this->_viewData["mode"] = $_GET["mode"];
        }
        if (isset($_GET["id"])) {
            $this->_viewData["id"] = $_GET["id"];
        }
        if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {
            error_log(
                $this->toString() . " Mode not valid " . $this->_viewData["mode"],
                0
            );
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.pagos.pagos',
                'Sucedio un error al procesar la página.'
            );
        }
        if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["id"], 10) !== 0) {
            $this->_viewData["mode"] !== "DSP";
        }
    }
    private function handlePost()
    {
        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);


        if (!(isset($_SESSION["pago_crsxToken"])
            && $_SESSION["pago_crsxToken"] == $this->_viewData["crsxToken"] )
        ) {
            unset($_SESSION["pago_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.pagos.pagos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }


        $this->_viewData["id"] = intval($this->_viewData["id"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ACT)|(INA)$/"
        )
        ) {
            $this->_viewData["errors"][] = "estado debe ser ACT o INA";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["pago_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\pagos::nuevopago(
                    $this->_viewData["fecha"],
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fechaVencimiento"],
                    $this->_viewData["estado"]

                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.pagos.pagos',
                        "¡Pago guardado satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\Pagos::actualizarpago(
                    $this->_viewData["fecha"],
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fechaVencimiento"],
                    $this->_viewData["estado"],
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.pagos.pagos',
                        "¡Pago actualizado satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\Pagos::eliminarpago(
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.pagos.pagos',
                        "¡Pago eliminado satisfactoriamente!"
                    );
                }
                break;
            default:
                # code...
                break;
            }
        }
    }
    private function prepareViewData()
    {
        if ($this->_viewData["mode"] == "INS") {
             $this->_viewData["modeDsc"]
                 = $this->_modeStrings[$this->_viewData["mode"]];
        } else {
            $tmpPago = \Dao\Mnt\pagos::obtenerPorid(
                intval($this->_viewData["id"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpPago, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["cliente"],
                $this->_viewData["id"]
            );
        }
        $this->_viewData["estadoOptions"]
            = \Utilities\ArrUtils::toOptionsArray(
                $this->estadoOptions,
                'value',
                'text',
                'selected',
                $this->_viewData['estado']
            );

        $this->_viewData["crsxToken"] = md5(time()."pago");
        $_SESSION["pago_crsxToken"] = $this->_viewData["crsxToken"]; 
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('mnt/Pago', $this->_viewData);
    }
}

?>