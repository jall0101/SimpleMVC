<?php
namespace Controllers\nw202301;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Clases\Demo;

class Me extends PublicController{
    
    /*index.php?page=nw202301-Me */
    public function run() :void{
        $viewData = array();
        $responseDao = Demo::getAResponse()["response"];
        $viewData["response"] = $responseDao;
        Renderer::render('nw202301/me', $viewData);
    }
}
    
?>