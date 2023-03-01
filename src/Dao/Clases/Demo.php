<?php

namespace Dao\Clases;

class Demo extends Table {
    public static function getAResponse(){
        return self::obtenertUnRegistro('select 1 as Response;', array());
    }
}

?>