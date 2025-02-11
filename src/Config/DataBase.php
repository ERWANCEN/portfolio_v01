<?php

namespace Config;

use PDO;
use PDOException;

class DataBase
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            try {
                // Détection de l'environnement
                $isLocal = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false 
                          || strpos($_SERVER['HTTP_HOST'] ?? '', ':8888') !== false;

                // Configuration selon l'environnement
                if ($isLocal) {
                    // Local (MAMP)
                    $host = 'localhost';
                    $dbname = 'portfolio_v01';
                    $username = 'root';
                    $password = 'root';
                    $port = '8889';
                } else {
                    // Production
                    $host = 'localhost';
                    $dbname = 'ceer3520_ezwrxfcghvjbkn';
                    $username = 'ceer3520';
                    $password = 'RM9C-FCsT-mp6(';
                    $port = '3306';
                }

                // Construction du DSN
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                
                error_log("Tentative de connexion avec DSN: $dsn, username: $username");

                // Options PDO
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                self::$instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                error_log("Erreur détaillée de connexion à la base de données : " . $e->getMessage());
                if ($isLocal) {
                    throw new PDOException("Erreur de connexion : " . $e->getMessage());
                } else {
                    throw new PDOException("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
                }
            }
        }

        return self::$instance;
    }
}
