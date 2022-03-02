<?php
//namespace debe coinsidir con le nombre de la carpeta
namespace Controllers\Clientes;

use Controllers\PublicController;
use Views\Renderer;
//nombre de la clase debe coincidir con el archivo Clientes.php
class  Clientes extends PublicController{

    public function run(): void
    {
        $viewData = array();
        $viewData["clientes"]= "Manejo de clientes";
        $viewData["clientes"]=array(
            "orlando",
            "josue",
            "Adriana"
        );
        //vista
        Renderer::render('Clientes/Clientes',$viewData);

    }
}
?>
