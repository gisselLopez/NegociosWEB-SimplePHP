<?php
namespace Controllers\Mnt\Vehiculos;

use Controllers\PublicController;
use Views\Renderer;

class Vehiculo extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nuevo vehiculo",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
    private $_estadoOptions = array(
        "ACT" => "Activo",
        "INA" => "Inactivo"
    );
    private $_viewData = array(
        "mode"=>"INS",
        "id"=>0,
        "marca"=>"",
        "modelo"=>"",
        "color"=>"",
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
                'index.php?page=mnt.vehiculos.vehiculos',
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


        if (!(isset($_SESSION["vehiculo_crsxToken"])
            && $_SESSION["vehiculo_crsxToken"] == $this->_viewData["crsxToken"] )
        ) {
            unset($_SESSION["vehiculo_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.vehiculos.vehiculos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }


        $this->_viewData["id"] = intval($this->_viewData["id"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ACT)|(INA)$/"
        )
        ) {
            $this->_viewData["errors"][] = "Vehiculo debe ser ACT o INA";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["vehiculo_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\Vehiculos::nuevovehiculo(
                    $this->_viewData["marca"],
                    $this->_viewData["modelo"],
                    $this->_viewData["color"],
                    $this->_viewData["estado"]
                    
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.vehiculos.vehiculos',
                        "vehiculo guardada satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\Vehiculos::actualizarvehiculo(
                    $this->_viewData["marca"],
                    $this->_viewData["modelo"],
                    $this->_viewData["color"],
                    $this->_viewData["estado"],
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.vehiculos.vehiculos',
                        "vehiculo actualizada satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\Vehiculos::eliminarvehiculo(
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.vehiculos.vehiculos',
                        "vehiculo eliminada satisfactoriamente!"
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
            $tmpvehiculo = \Dao\Mnt\Vehiculos::obtenerPorid(
                intval($this->_viewData["id"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpvehiculo, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["marca"],
                $this->_viewData["id"]
            );
        }
        $this->_viewData["estadoOptions"]
        = \Utilities\ArrUtils::toOptionsArray(
                $this->_estadoOptions,
                'value',
                'text',
                'selected',
                $this->_viewData['estado']
            );

        $this->_viewData["crsxToken"] = md5(time()."vehiculo");
        $_SESSION["vehiculo_crsxToken"] = $this->_viewData["crsxToken"]; 
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('mnt/Vehiculo', $this->_viewData);
    }
}

?>