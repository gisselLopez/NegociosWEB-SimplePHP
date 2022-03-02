<?php
namespace Controllers\Mnt\Categorias;

use Controllers\PublicController;
use Views\Renderer;
 
    /*el controlador Hereda lo que un public controller */
class Categorias extends PublicController
{
  /*
    categorias
    `catid` BIGINT(8) NOT NULL AUTO_INCREMENT,
  `catnom` VARCHAR(45) NULL,
  `catest` CHAR(3) NULL DEFAULT 'ACT',
    */

    /*Sacar todos los listados que esten en la tabla.
    function run permite establecer la varibale que voy a ocupar
    */
    public function run(): void
    {
        $viewData = array();
         /* la varibale la extraer de informacion del Modelo de datos */
        $viewData["categorias"]
            = \Dao\Mnt\Categorias::obtenerTodos();
        Renderer::render('mnt/Categorias', $viewData);
    }
}

?>