<?php
session_start(); // Démarrer la session
// Base de données :
$pdo = new PDO('mysql:host=localhost;dbname=portfolio_crud', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require 'fonction.php';
// Constante pour le chemin du fichier de configuration
define('CONFIG_PATH', 'config/config.php');

// Définir l'url :
define('URL', 'http://localhost:8888/portfolio_crud');

// Définir le chemin du dossier assets
define('ASSETS_PATH', 'assets/');

// Gestion de la déconnexion

define('BASE_URL', '/portfolio_v01');

// Définit le chemin de base du projet
define('BASE_PATH', dirname(__DIR__));
