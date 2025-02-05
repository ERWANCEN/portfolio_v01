<?php

namespace Config;

use PDO;
use Exception;

class Database
{
    private static $instance = null;

    private static function getConfig()
    {
        return [
            'dsn' => 'mysql:host=localhost;dbname=portfolio',
            'username' => 'root',
            'password' => 'root',
        ];
    }

    public static function getConnection()
    {
        if (self::$instance === null) {
            $config = self::getConfig();
            try {
                self::$instance = new PDO($config['dsn'], $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (Exception $e) {
                throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
