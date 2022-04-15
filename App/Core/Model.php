<?php

namespace App\Core;

class Model {

    private static $connection;

    public static function getConnection(){

        if(!isset(self::$connection)){
            self::$connection = new \PDO("mysql:host=localhost:3306;dbname=technicalsharedb;", "technicalsharesys", '$uC0D3l@R4nJa');
        }

        return self::$connection;
    }

}