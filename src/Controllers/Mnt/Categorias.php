<?php
namespace Controllers\Mnt;

use Controllers\PublicController;

class Categorias extends PublicController{
    public function run() :void{
        $viewData = array();
        $viewData["categorias"] = \Dao\Mnt\Categorias::findAll();
        Renderer::render('mnt\categorias', $viewData);
    }
}