<?php
namespace Controllers\Mnt\Candidatos;

use Controllers\PublicController;
use Views\Renderer;


class Candidatos extends PublicController
{
    public function run(): void
    {
       $viewData = array();
        $viewData["candidatos"]
            = \Dao\Mnt\Candidatos::obtenerTodos();
        Renderer::render('mnt/Candidatos', $viewData);
    }
}

?>