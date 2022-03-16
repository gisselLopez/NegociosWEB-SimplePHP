<?php
namespace Controllers\Mnt\Candidatos;

use Controllers\PublicController;
use Views\Renderer;

class Candidato extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nuevo candidato",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
   
    private $_viewData = array(
        "mode"=>"INS",
        "id"=>0,
        "identidad"=>"",
        "nombre"=>"",
        "edad"=>"",
        "modeDsc"=>"",
        "readonly"=>false,
        "isInsert"=>false,
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
                'index.php?page=mnt.candidatos.candidatos',
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


        if (!(isset($_SESSION["candidato_crsxToken"])
            && $_SESSION["candidato_crsxToken"] == $this->_viewData["crsxToken"] )
        ) {
            unset($_SESSION["candidato_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.candidatos.candidatos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }
        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            unset($_SESSION["candidato_crsxToken"]);
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\Mnt\Candidatos::nuevoCandidato(
                    $this->_viewData["identidad"],
                     $this->_viewData["nombre"],
                      $this->_viewData["edad"],
                    
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.candidatos.candidatos',
                        "candidato guardada satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\Mnt\Candidatos::actualizarCandidato(
                     $this->_viewData["identidad"],
                     $this->_viewData["nombre"],
                      $this->_viewData["edad"],
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.candidatos.candidatos',
                        "candidato actualizada satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\Mnt\Candidatos::eliminarCandidato(
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=mnt.candidatos.candidatos',
                        "candidato eliminada satisfactoriamente!"
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
            $tmpcandidato = \Dao\Mnt\Candidatos::obtenerPorid(
                intval($this->_viewData["id"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpcandidato, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                 $this->_viewData["identidad"],
                $this->_viewData["nombre"],
                $this->_viewData["edad"],
                $this->_viewData["id"]
            );
        }

        $this->_viewData["crsxToken"] = md5(time()."candidato");
        $_SESSION["candidato_crsxToken"] = $this->_viewData["crsxToken"]; 
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('mnt/Candidato', $this->_viewData);
    }
}

?>