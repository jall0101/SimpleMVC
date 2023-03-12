<?php
namespace Dao\Mnt;
use Dao\Table;


class Roles extends Table{
    //INSERT DE LA TABLA ROLES
    public static function insert(string $rolesdsc, string $rolesest="ACT"): int
    {
        $sqlstr = "INSERT INTO roles (rolesdsc, rolesest) 
            values(:rolesdsc, :rolesest);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("rolesdsc"=>$rolesdsc,
            "rolesest"=>$rolesest)
        );
        return $rowsInserted;
    }

    //UPDATE DE LA TABLA ROLES
    public static function update(
        string $rolesdsc,
        string $rolesest,
        int $rolescod
    ){
        $sqlstr = "UPDATE roles set rolesdsc = :rolesdsc,
            rolesest = :rolesest,
         where rolescod=:rolescod;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest,
                "rolescod" => $rolescod
            )
        );
        return $rowsUpdated;
    }

    //DELETE DE LA TABLA ROLES
    public static function delete(int $rolescod){
        $sqlstr = "DELETE from roles where rolescod=:rolescod;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "rolescod" => $rolescod
            )
        );
        return $rowsDeleted;
    }

    //BUSQUEDA COMPLETA DE LA TABLA ROLES
    public static function findAll(){
        $sqlstr = "SELECT * from roles;";
        return self::obtenerRegistros($sqlstr, array());
    }

    //BUSQUEDA POR FILTRO DE LA TABLA ROLES...(NO HECHA)
    public static function findByFilter(){

    }

    //BUSQUEDA POR ID DE LA TABLA ROLES
    public static function findById(int $rolescod){
        $sqlstr = "SELECT * from roles where rolescod = :rolescod;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "rolescod"=> $rolescod
            )
        );
        return $row;
    }
}