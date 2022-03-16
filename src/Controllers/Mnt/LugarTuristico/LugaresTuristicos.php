<?php

//npmbres de las carpetas
namespace Controllers\Mnt\LugarTuristico;

use Controllers\PublicController;
use Views\Renderer;
/*el controlador Hereda lo que un public controller */
class LugaresTuristicos extends PublicController
{
    /*
    CREATE TABLE `lugaresturisticos` (
  `lugarid` bigint(18) NOT NULL AUTO_INCREMENT,
  `lugar` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
    */

    /*Sacar todos los listados que esten en la tabla.
    function run permite establecer la varibale que voy a ocupar
    */
    public function run():void
    {
        $ViewData = array();
        /* la varibale la extraer de informacion del Modelo de datos */
         $ViewData["lugaresturisticos"]
            =\Dao\Mnt\LugaresTuristicos::obtenerTodos();

        Renderer::render('mnt/LugaresTuristicos',$ViewData);
    }
}
?>