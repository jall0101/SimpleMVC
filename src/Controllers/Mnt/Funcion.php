<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Funcion extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Funciones";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "fncod" => 0,
        "fndsc" => "",
        "fnest" => "ACT",
        "fnest_ACT" => "selected",
        "fnest_INA" => "",
        "fntyp" => "CLI",
        "fntyp_CLI" => "selected",
        "fntyp_ADM" => "",
        "fntyp_TRA" => "",
        "fndsc_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Función",
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
            unset($_SESSION["xssToken_Mnt_Rol"]);
            error_log(sprintf("Controller/Mnt/Funcion ERROR: %s", $error->getMessage()));
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
            if(isset($_GET['fncod'])){
                $this->viewData["fncod"] = intval($_GET["fncod"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }

    //VALIDACIONES
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Funcion"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Funcion"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }


        //VALIDACION PARA LA FUNCIÓN
        if(isset($_POST["fndsc"])){
            if(\Utilities\Validators::IsEmpty($_POST["fndsc"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["fndsc_error"] = "El nombre del rol no puede ir vacío!";
            }
        } else {
            throw new Exception("fndsc not present in form");
        }


        //VALIDACIÓN PARA ESTADO DE LA FUNCIÓN
        if(isset($_POST["fnest"])){
            if (!in_array( $_POST["fnest"], array("ACT","INA"))){
                throw new Exception("fnest incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("fnest not present in form");
            }
        }

        //VALIDACIÓN PARA TIPO DE LA FUNCIÓN
        if(isset($_POST["fntyp"])){
            if (!in_array( $_POST["fntyp"], array("CLI","ADM", "TRA"))){
                throw new Exception("fnest incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("fnest not present in form");
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


        //VALIDACION PARA EL ID DEL ROL
        if(isset($_POST["fncod"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["fncod"])<=0)){
                throw new Exception("FuncionID is not Valid");
            }
            if($this->viewData["fncod"]!== intval($_POST["fncod"])){
                throw new Exception("fncod value is different from query");
            }
        }else {
            throw new Exception("fncod not present in form");
        }
        $this->viewData["fndsc"] = $_POST["fndsc"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["fnest"] = $_POST["fnest"];
        }
    }

    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Funciones::insert(
                    $this->viewData["fndsc"],
                    $this->viewData["fnest"],
                    $this->viewData["fntyp"],
                    
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Función Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Funciones::update(
                    $this->viewData["fndsc"],
                    $this->viewData["fnest"],
                    $this->viewData["fntyp"],
                    $this->viewData["fncod"]
                    
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Función Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Funciones::delete(
                    $this->viewData["fncod"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Función Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    
    //VALIDACION PARA TOKEN
    private function render(){
        $xssToken = md5("FUNCIÓN" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Rol"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["fndsc"] = $this->modes["INS"];
        } else {
            $tmpRoles = \Dao\Mnt\Funciones::findById($this->viewData["fncod"]);
            if(!$tmpRoles){
                throw new Exception("La función no existe en la Base de Datos");
            }
            \Utilities\ArrUtils::mergeFullArrayTo($tmpRoles, $this->viewData);
            $this->viewData["fnest_ACT"] = $this->viewData["fnest"] === "ACT" ? "selected": "";
            $this->viewData["fnest_INA"] = $this->viewData["fnest"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["fndsc"],
                $this->viewData["fncod"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/funcion", $this->viewData);
    }
}

?>