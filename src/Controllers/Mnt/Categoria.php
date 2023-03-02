<?php
namespace Controllers\Mnt;
use Controllers\PublicController;
use Exception;
class Categoria extends PublicController{
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "catid" => 0,
        "catnom" => "",
        "catest" => "ACT",
        "catest_ACT" => "selected",
        "catest_INA" => ""
    );

    public $mode = array
    (
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Categoria",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
    public function run() :void
    {
        try{
            $this->page_loades();
        } catch(\Exception $error){
            error_log(sprintf("Controller/Mnt/Categoria ERROR: %s", $error));
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=Mnt-Categorias",
                 "Algo inesperado sucedió"
            );
        }
        /*
        
        1) Captura de valores iniciales por QueryParams -> Parametros de query ? 
            http://ax.ex.com/index.php?page=abc&mode=UPD&=1029
        2) Dterminamos el métodos POST y GET
        3) Procesar la entrada:
            3.1) Si es un POST
            3.2) Capturar y validará datos del formulario
            3.3) Segíun el modo realizar la acción solicitada
            3.4) Notificar errores su hay
            3.5) Redirigir a la lista
            4.1) Si es un GET
            4.2) Obtener valores de la DB si no es INS
            4.3) Mostrar Valores
        4) Renderizar

        */
    }
    private function page_loaded()
    {
        if(isset($_GET['mode'])){
            if(isset($this->modes[$_GET['mode']])){
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not Available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if($this->viewData["mode"] !== "INS") {
            if(isset($_GET['catid'])){
                $this->viewData["catid"] = $_GET["catid"];
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
}