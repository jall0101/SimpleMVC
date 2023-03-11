<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Usuario extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Usuarios";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "usercod" => 0,
        "useremail" => "",
        "username" => "",
        "userpaswd" => "",

        "userest" => "ACT",
        "userest_ACT" => "selected",
        "userest_INA" => "",
        "useractcod" => "",
        "usertipo" => "NRM",
        "usertipo_NRM" => "selected",
        "usertipo_CON" => "",
        "usertipo_CLI" => "",

        "useremail_error"=> "",
        "username_error"=> "",
        "userpswd_error"=> "",

        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );

    //CORRER LA VISTA
    public function run() :void
    {
        try {
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            unset($_SESSION["xssToken_Mnt_Usuario"]);
            error_log(sprintf("Controller/Mnt/Usuario ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo :("
            );
        }

    }

   
    private function page_loaded()
    {
        if(isset($_GET['mode'])){
            if(isset($this->modes[$_GET['mode']])){
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if($this->viewData["mode"] !== "INS") {
            if(isset($_GET['usercod'])){
                $this->viewData["usercod"] = intval($_GET["usercod"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }

    //VALIDACIONES
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Usuario"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Usuario"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }


        //VALIDACION PARA EL NOMBRE USUARIO
        if(isset($_POST["username"])){
            if(\Utilities\Validators::IsEmpty($_POST["username"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["username_error"] = "El nombre de usuario no puede ir vacío!";
            }
        } else {
            throw new Exception("username not present in form");
        }


        //VALIDACIÓN PARA ESTADO DEL USUARIO
        if(isset($_POST["userest"])){
            if (!in_array( $_POST["userest"], array("ACT","INA"))){
                throw new Exception("userest incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("userest not present in form");
            }
        }

         //VALIDACIÓN PARA TIPO DEL USUARIO
         if(isset($_POST["usertipo"])){
            if (!in_array( $_POST["usertipo"], array("NRM","CON","CLI"))){
                throw new Exception("usertipo incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("usertipo not present in form");
            }
        }

        //VALIDACION PARA EL MODO
        if(isset($_POST["mode"])){
            if(!key_exists($_POST["mode"], $this->modes)){
                throw new Exception("mode has a bad value");
            }
            if($this->viewData["mode"]!== $_POST["mode"]){
                throw new Exception("mode value is different from query");
            }
        }else {
            throw new Exception("mode not present in form");
        }


        //VALIDACION PARA EL ID DEL USUARIO
        if(isset($_POST["usercod"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["usercod"])<=0)){
                throw new Exception("UsuarioID is not Valid");
            }
            if($this->viewData["usercod"]!== intval($_POST["usercod"])){
                throw new Exception("usercod value is different from query");
            }
        }else {
            throw new Exception("usercod not present in form");
        }
        $this->viewData["username"] = $_POST["username"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["userest"] = $_POST["userests"];
        }
    }

    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Usuarios::insert(
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpaswd"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["usertipo"]
                    
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Usuarios::update(
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpaswd"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["usertipo"],
                    $this->viewData["usercod"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Usuarios::delete(
                    $this->viewData["usercod"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    
    //VALIDACION PARA TOKEN
    private function render(){
        $xssToken = md5("USUARIO" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Usuario"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpUsuarios = \Dao\Mnt\Usuarios::findById($this->viewData["usercod"]);
            if(!$tmpUsuarios){
                throw new Exception("El Usuario no existe en la Base de Datos");
            }
            \Utilities\ArrUtils::mergeFullArrayTo($tmpUsuarios, $this->viewData);
            $this->viewData["userest_ACT"] = $this->viewData["userest"] === "ACT" ? "selected": "";
            $this->viewData["userest_INA"] = $this->viewData["userest"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["username"],
                $this->viewData["usercod"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/usuario", $this->viewData);
    }
}

?>
