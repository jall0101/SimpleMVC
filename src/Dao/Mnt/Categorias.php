<?php

namespace Dao\Mnt;
//USE SOLO SI TENGO NAMESPACE DEFINIDO
use Dao\Table;

/*
`catid` BIGINT(8) NOT NULL AUTO_INCREMENT,
  `catnom` VARCHAR(45) NULL,
  `catest` CHAR(3) NULL DEFAULT 'ACT',
*/

class Categorias extends Table{
    
    public static function insertar(string $catnom, string $catest="ACT"){
        $sqlstr = "INSERT INTO categorias (catnom, catest) values (:catnom, :catests);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr, 
            array("catnom" => $catnom, "catest"=> $catest));
        
        return $rowsInserted;
    }

    public static function actualizar(){

    }

    public static function borrar(){

    }

    public static function findAll(){
        $sqlstr = "SELECT * FROM categorias;";
        return self::obtenerRegistros($sqlstr, array());

    }

    public static function findByFilter(){
        
    }

    public static function findById(){

    }

   
}

?>