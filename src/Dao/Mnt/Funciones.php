<?php
namespace Dao\Mnt;
use Dao\Table;


class Funciones extends Table{
    //INSERT DE LA TABLA FUNCIONES
    public static function insert(string $fndsc, string $fnest="ACT", string $fntyp="CLI"): int
    {
        $sqlstr = "INSERT INTO funciones (fndsc, fnest, fntyp) 
            values(:fndsc, :fnest, :fntyp);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("fndsc"=>$fndsc,
            "fnest"=>$fnest,
            "fntyp"=>$fntyp)
            
        );
        return $rowsInserted;
    }

    //UPDATE DE LA TABLA FUNCIONES
    public static function update(
        string $fndsc,
        string $fnest,
        string $fntyp,
        int $fncod
    ){
        $sqlstr = "UPDATE funciones set fndsc = :fndsc,
            fnest = :fnest,
            fntyp = :fntyp,
         where fncod=:fncod;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp,
                "fncod" => $fncod
            )
        );
        return $rowsUpdated;
    }

    //DELETE DE LA TABLA FUNCIONES
    public static function delete(int $fncod){
        $sqlstr = "DELETE from funciones where fncod=:fncod;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "fncod" => $fncod
            )
        );
        return $rowsDeleted;
    }

    //BUSQUEDA COMPLETA DE LA TABLA FUNCIONES
    public static function findAll(){
        $sqlstr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlstr, array());
    }

    //BUSQUEDA POR FILTRO DE LA TABLA FUNCIONES...(NO HECHA)
    public static function findByFilter(){

    }

    //BUSQUEDA POR ID DE LA TABLA ROLES
    public static function findById(int $fncod){
        $sqlstr = "SELECT * from funciones where fncod = :fncod;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "fncod"=> $fncod
            )
        );
        return $row;
    }
}