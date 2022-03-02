<?php

namespace Controllers\Mnt\Pagos;

use Controllers\PublicController;
use Views\Renderer;
/*el controlador Hereda lo que un public controller */
class Pagos extends PublicController
{
    /*
    CREATE TABLE `nw202201`.`pagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL,
  `cliente` VARCHAR(45) NOT NULL ,
  `monto` FLOAT NOT NULL ,
  `fechaVencimiento` VARCHAR(45) NOT NULL ,
  `estado` VARCHAR(45) NOT NULL DEFAULT 'ac' ,
  PRIMARY KEY (`id`));
    */

    /*Sacar todos los listados que esten en la tabla.
    function run permite establecer la varibale que voy a ocupar
    */
    public function run():void
    {
        $ViewData = array();
        /* la varibale la extraer de informacion del Modelo de datos */
         $ViewData["pagos"]
            =\Dao\Mnt\Pagos::obtenerTodos();

        Renderer::render('mnt/Pagos',$ViewData);
    }
}
?>