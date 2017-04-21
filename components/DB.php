<?php

class DB {
    
    public static function getConnection()
    {
        $host = 'localhost';
        $dbname = 'phpparserlenta';
        $user = 'root';
        $password = '4496456';
        
        $db = new PDO ("mysql:host=$host; dbname=$dbname", $user, $password);
        
        return $db;
    }
    
}
