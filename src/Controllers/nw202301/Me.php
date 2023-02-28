<?php
namespace Controllers\nw202301;
use Controllers\PublicController;
use Views\Renderer;

class Me extends PublicController{
    
    /*index.php?page=nw202301-Me */
    public function run() :void{
        $viewData = array();
        Renderer::render('nw202301/me', $viewData);
    }
}
    
?>