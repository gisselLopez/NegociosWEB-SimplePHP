<?php
namespace Controllers\Mnt\Vehiculos;

use Controllers\PublicController;
use Views\Renderer;
 
    /*el controlador Hereda lo que un public controller */
class Vehiculos extends PublicController
{
  
    public function run(): void
    {
        $viewData = array();
         /* la varibale la extraer de informacion del Modelo de datos */
        $viewData["vehiculos"]
            = \Dao\Mnt\Vehiculos::obtenerTodos();
        Renderer::render('mnt/Vehiculos', $viewData);
    }
}

?>