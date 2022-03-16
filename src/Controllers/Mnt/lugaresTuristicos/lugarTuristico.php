<?php
namespace Controllers\Mnt\lugaresTuristicos;

use Controllers\PublicController;
use Views\Renderer; 

class LugarTuristico extends PublicController
{
 
    private $_modeStrings = array(
        "INS" => "Nuevo Lugar",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
    private $_catestOptions = array(
        "ACT" => "Activado",
        "INA" => "Inactivo"
    );
    private $_viewData = array(
        "mode"=>"INS",
        "lugarid"=>0,
        "lugar"=>"",
        "pais"=>"",
        "estado"=>"ACT",
        "ciudad"=>"",
        "latitud"=>0,
        "longitud"=>0,
        "modeDsc"=>"",
        "readonly"=>false,
        "isInsert"=>false,
        "catestOptions"=>[],
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
                $this->toString() . " Mode not valid " . $this->_viewData["mode"],
                0
            );
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.lugaresTuristicos.lugaresTuristicos', /*este es de controller o views?*/
                'Sucedio un error al procesar la página.'
            );
        }
        if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["lugarid"], 10) !== 0) {
            $this->_viewData["mode"] !== "DSP";
        }
    }
    private function tiempo()
    {
        $Object = new DateTime();  
        $DateAndTime = $Object->format("d-m-Y h:i:s a"); 
    }
    private function handlePost()
    {
        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);


        if (!(isset($_SESSION["lugarTuristico_crsxToken"])
            && $_SESSION["lugarTuristico_crsxToken"] == $this->_viewData["crsxToken"] )
        ) {
            unset($_SESSION["lugarTuristico_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.lugaresTuristicos.lugaresTuristicos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }


        $this->_viewData["lugarid"] = intval($this->_viewData["lugarid"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ACT)|(INA)$/"
        )
        ) {
            $this->_viewData["errors"][] = "intentoPago debe ser ACT O INA";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["lugarTuristico_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\lugaresTuristicos::nuevoLugarTuristco(
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["estado"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"],
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresTuristicos.lugaresTuristicos',
                        "¡Lugar guardado satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\lugaresTuristicos::actualizarLugarTuristco(
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["estado"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"],
                    $this->_viewData["lugarid"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresTuristicos.lugaresTuristicos',
                        "Lugar actualizado satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\lugaresTuristicos::eliminarLugarTuristco(
                    $this->_viewData["lugarid"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.lugaresTuristicos.lugaresTuristicos',
                        "¡Lugar eliminado satisfactoriamente!"
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
            $tmpCategoria = \Dao\Mnt\lugaresTuristicos::obtenerPorLugarId(
                intval($this->_viewData["lugarid"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpCategoria, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                 $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["estado"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"],
                    $this->_viewData["lugarid"]
            );
        }
        $this->_viewData["catestOptions"]
            = \Utilities\ArrUtils::toOptionsArray(
                $this->_catestOptions,
                'value',
                'text',
                'selected',
                $this->_viewData['estado']
            );

        $this->_viewData["crsxToken"] = md5(time()."lugarTuristico");
        $_SESSION["lugarTuristico_crsxToken"] = $this->_viewData["crsxToken"]; 
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('mnt/lugarTuristico', $this->_viewData);
    }
}

?>