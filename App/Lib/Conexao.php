<?php

namespace App\Lib;

use PDO;
use PDOException;
use Exception;

class Conexao
{
    private static $connection;

    private function __construct(){}

    public static function getConnection() {
        $dbDriver = "mysql";
        $dbHost = "localhost";
        $dbPort = "8080"; 
        $dbName = "crudproduto"; 
        $dbUser = "root"; 
        $dbPassword = "1234567"; 

        $pdoConfig  = $dbDriver . ":". "host=" . $dbHost . ";";
        $pdoConfig .= "port=" . $dbPort . ";";
        $pdoConfig .= "dbname=" . $dbName . ";";

        try { 
            if(!isset(self::$connection)){
                self::$connection =  new PDO($pdoConfig, $dbUser, $dbPassword);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        } catch (PDOException $e) {
            throw new Exception("Erro de conexão com o banco de dados",500);
        }
    }
}


