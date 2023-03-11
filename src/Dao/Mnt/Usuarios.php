<?php
namespace Dao\Mnt;
use Dao\Table;


class Usuarios extends Table{
    //INSERT DE LA TABLA USUARIOS
    public static function insert(string $useremail, string $username, string $userpaswd, string $userest="ACT", string $useractcod, string $usertipo="NRM"): int
    {
        $sqlstr = "INSERT INTO usuario (useremail, username, userpaswd, userest, useractcod, usertipo) 
            values(:useremail, :username, :userpaswd, :userest, :useractcod, :usertipo);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("useremail"=>$useremail, 
            "username"=>$username, 
            "userpaswd"=>$userpaswd, 
            "userest"=>$userest,
            "useractcod"=>$useractcod, 
            "usertipo"=>$usertipo)
        );
        return $rowsInserted;
    }

    //UPDATE DE LA TABLA USUARIO
    public static function update(
        string $useremail,
        string $username,
        string $userpaswd,
        string $userest,
        string $useractcod,
        string $usertipo,
        int $usercod
    ){
        $sqlstr = "UPDATE usuario set useremail = :useremail,
            username = :username,
            userpaswd = :userpaswd,
            userest = :userest,
            useractcod = :useractcod,
            usertipo = :usertipo
         where usercod=:usercod;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "useremail" => $useremail,
                "username" => $username,
                "userpaswd" => $userpaswd,
                "userest" => $userest,
                "useractcod" => $useractcod,
                "usertipo" => $usertipo,
                "usercod" => $usercod
            )
        );
        return $rowsUpdated;
    }

    //DELETE DE LA TABLA USUARIO
    public static function delete(int $usercod){
        $sqlstr = "DELETE from usuario where usercod=:usercod;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "usercod" => $usercod
            )
        );
        return $rowsDeleted;
    }

    //BUSQUEDA COMPLETA DE LA TABLA USUARIO
    public static function findAll(){
        $sqlstr = "SELECT * from usuario;";
        return self::obtenerRegistros($sqlstr, array());
    }

    //BUSQUEDA POR FILTRO DE LA TABLA USUARIO...(NO HECHA)
    public static function findByFilter(){

    }

    //BUSQUEDA POR ID DE LA TABLA USUARIO
    public static function findById(int $usercod){
        $sqlstr = "SELECT * from usuario where usercod = :usercod;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "usercod"=> $usercod
            )
        );
        return $row;
    }
}