<?php
namespace Controllers\Mnt\lugaresTuristicos;

use Controllers\PublicController;
use Views\Renderer;


class lugaresTuristicos extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["lugaresTuristicos"]
            = \Dao\Mnt\lugaresTuristicos::obtenerTodos();
        Renderer::render('mnt/lugaresTuristicos', $viewData);
    }
}

?>
