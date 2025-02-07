<?php

namespace Config;

use PDO;
use Exception;

class Database
{
    private static $instance = null;
    
    public static function getConnection()
    {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=localhost;dbname=portfolio;port=8889;charset=utf8mb4";
                self::$instance = new PDO($dsn, 'root', 'root', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]);
            } catch (Exception $e) {
                throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
