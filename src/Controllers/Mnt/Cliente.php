<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Cliente extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Clientes";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "clientid" => 0,
        "clientname" => "",
        "clientgender"=>"M",
        "clientgender_M" => "selected",
        "clientegender_F" => "",
        "clientphone1" => "",
        "clientphone2" => "",
        "clientemail" => "",
        "clientstatus" => "ACT",
        "clientstatus_ACT" => "selected",
        "clientestatus_INA" => "",
        "clientname_error"=> "",
        "clientphone1_error"=> "",
        "clientphone2_error"=> "",
        "clientemail_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Cliente",
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
            unset($_SESSION["xssToken_Mnt_Cliente"]);
            error_log(sprintf("Controller/Mnt/Cliente ERROR: %s", $error->getMessage()));
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
            if(isset($_GET['clientid'])){
                $this->viewData["clientid"] = intval($_GET["clientid"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }

    //VALIDACIONES
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Cliente"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Cliente"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }


        //VALIDACION PARA EL NOMBRE DEL CLIENTE
        if(isset($_POST["clientname"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientname"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientname_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("ClientName not present in form");
        }


        //VALIDACIÓN PARA GÉNERO DE CLIENTE
        if(isset($_POST["clientgender"])){
            if (!in_array( $_POST["clientgender"], array("M","F"))){
                throw new Exception("ClientGender incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("ClientGender not present in form");
            }
        }

        //VALIDACION PARA EL TELÉFON #1
        if(isset($_POST["clientphone1"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientphone1"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientphone1_error"] = "El número de teléfono no puede ir vacío!";
            }
        } else {
            throw new Exception("ClientPhone1 not present in form");
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


        //VALIDACION PARA EL ID DEL CLIENTE
        if(isset($_POST["clientid"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["clientid"])<=0)){
                throw new Exception("clientID is not Valid");
            }
            if($this->viewData["clientid"]!== intval($_POST["clientid"])){
                throw new Exception("clientId value is different from query");
            }
        }else {
            throw new Exception("clientId not present in form");
        }
        $this->viewData["clientname"] = $_POST["clientname"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["clientgender"] = $_POST["clientgender"];
        }
    }

    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Clientes::insert(
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientphone2"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientstatus"]
                    
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Clientes::update(
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientphone2"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientstatus"],
                    $this->viewData["clientid"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Clientes::delete(
                    $this->viewData["clientid"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    
    //VALIDACION PARA TOKEN
    private function render(){
        $xssToken = md5("CLIENTE" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Cliente"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpClientes = \Dao\Mnt\Clientes::findById($this->viewData["clientid"]);
            if(!$tmpClientes){
                throw new Exception("El Cliente no existe en la Base de Datos");
            }
            \Utilities\ArrUtils::mergeFullArrayTo($tmpClientes, $this->viewData);
            $this->viewData["clientstatus_ACT"] = $this->viewData["clienstatus"] === "ACT" ? "selected": "";
            $this->viewData["clientstatus_INA"] = $this->viewData["clienstatus"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["clientname"],
                $this->viewData["clientid"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/cliente", $this->viewData);
    }
}

?>
