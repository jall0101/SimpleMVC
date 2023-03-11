<?php
namespace Dao\Mnt;
use Dao\Table;


class Clientes extends Table{
    //INSERT DE LA TABLA CLIENTES
    public static function insert(string $clientname, string $clientgender="M", string $clientphone1, string $clientphone2, string $clientemail, string $clientstatus="ACT"): int
    {
        $sqlstr = "INSERT INTO clientes (clientname, clientgender, clientphone1, clientphone2, clientemail, clientstatus) 
            values(:clientname, :clientgender, :clientphone1, :clientphone2, :clientemail, :clientstatus);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("clientname"=>$clientname, 
            "clientgender"=>$clientgender, 
            "clientphone1"=>$clientphone1, 
            "clientphone2"=>$clientphone2,
            "clientemail"=>$clientemail, 
            "clientstatus"=>$clientstatus)
        );
        return $rowsInserted;
    }

    //UPDATE DE LA TABLA CLIENTES
    public static function update(
        string $clientname,
        string $clientgender,
        string $clientphone1,
        string $clientphone2,
        string $clientemail,
        string $clientstatus,
        int $clientid
    ){
        $sqlstr = "UPDATE clientes set clientname = :clientname, 
            clientgender = :clientgender, 
            clientphone1 = :clientphone1,
            clientphone2 = :clientphone2,
            clientemail = :clientemail,
            clientstatus = :clientstatus
         where clientid=:clientid;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "clientname" => $clientname,
                "clientgender" => $clientgender,
                "clientphone1" => $clientphone1,
                "clientphone2" => $clientphone2,
                "clientemail" => $clientemail,
                "clientstatus" => $clientstatus,
                "clientid" => $clientid
            )
        );
        return $rowsUpdated;
    }

    //DELETE DE LA TABLA CLIENTES
    public static function delete(int $clientid){
        $sqlstr = "DELETE from clientes where clientid=:clientid;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "clientid" => $clientid
            )
        );
        return $rowsDeleted;
    }

    //BUSQUEDA COMPLETA DE LA TABLA CLIENTES
    public static function findAll(){
        $sqlstr = "SELECT * from clientes;";
        return self::obtenerRegistros($sqlstr, array());
    }

    //BUSQUEDA POR FILTRO DE LA TABLA CLIENTES...(NO HECHA)
    public static function findByFilter(){

    }

    //BUSQUEDA POR ID DE LA TABLA CLIENTES
    public static function findById(int $clientid){
        $sqlstr = "SELECT * from clientes where clientid = :clientid;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "clientid"=> $clientid
            )
        );
        return $row;
    }
}
