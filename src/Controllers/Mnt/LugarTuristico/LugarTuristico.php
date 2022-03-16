<?php
namespace Controllers\Mnt\LugarTuristico;

use Controllers\PublicController;
use Views\Renderer;

class LugarTuristico extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nuevo Lugar Turistico",
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
        "lugarid"=>0,
        "lugar"=>"",
        "pais"=>"",
        "estado"=>"ACT",
        "ciudad"=>"",
        "latitud"=>"",
        "longitud"=>"",
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
        if (isset($_GET["lugarid"])) {
            $this->_viewData["lugarid"] = $_GET["lugarid"];
        }
        if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {
            error_log(
                $this->toString() . " Mode not vallugarid " . $this->_viewData["mode"],
                0
            );
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.lugaresturisticos.lugaresturisticos',
                'Sucedio un error al procesar la página.'
            );
        }
        if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["lugarid"], 10) !== 0) {
            $this->_viewData["mode"] !== "DSP";
        }
    }
    private function handlePost()
    {
        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);


        if (!(isset($_SESSION["lugarturistico_crsxToken"])
            && $_SESSION["lugarturistico_crsxToken"] == $this->_viewData["crsxToken"] )
        ) {
            unset($_SESSION["lugarturistico_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.lugaresturisticos.lugaresturisticos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }


        $this->_viewData["lugarid"] = intval($this->_viewData["lugarid"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ACT)|(INA)$/"
        )
        ) {
            $this->_viewData["errors"][] = "estado debe ser ACT o INA";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["lugarturistico_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\LugarTuristico::nuevolugar(
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"],
                    $this->_viewData["estado"]

                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresturisticos.lugaresturisticos',
                        "¡LugarTuristico guardado satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\LugarTuristico::actualizarlugar(
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"],
                    $this->_viewData["estado"],
                    $this->_viewData["lugarid"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresturisticos.lugaresturisticos',
                        "¡LugarTuristico actualizado satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\LugarTuristico::eliminarlugar(
                    $this->_viewData["lugarid"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresturisticos.lugaresturisticos',
                        "¡LugarTuristico eliminado satisfactoriamente!"
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
            $tmpLugarTuristico = \Dao\Mnt\LugarTuristico::obtenerPorlugarid(
                intval($this->_viewData["lugarid"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpLugarTuristico, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["pais"],
                $this->_viewData["lugarid"]
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

        $this->_viewData["crsxToken"] = md5(time()."lugarturistico");
        $_SESSION["lugarturistico_crsxToken"] = $this->_viewData["crsxToken"]; 
    }
    public function run(): volugarid
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('mnt/LugarTuristico', $this->_viewData);
    }
}

?>