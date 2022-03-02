<?php
namespace Controllers\Mnt\Categorias;

use Controllers\PublicController;
use Views\Renderer;
 
   
class Parameters extends PublicController
{
  
    public function run(): void
    {
        $viewData = array();
         /* la varibale la extraer de informacion del Modelo de datos */
        $viewData["categorias"]
            = \Dao\Mnt\Categorias::obtenerTodos();
        Renderer::render('orm/parameters', $viewData);
    }
}

?>