<?php
namespace Controllers\nw202301;
use Controllers\PublicController;
use Views\Renderer;

class MiFicha extends PublicController{
    public function run() :void{
        $viewData = array(
            "nombre" => "Jesús Alberto López",
            "email" => "jlopez9820@gmail.com",
            "title" => "Ingeniero en Sistemas"
        );
        Renderer::render("nw202301/MiFicha", $viewData);
    }
}

?>