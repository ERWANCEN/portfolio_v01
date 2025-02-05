<?php

// Chargement automatique des classes
require_once '../../autoload.php';

use Controllers\ProjetController;

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=portfolio_crud', 'root', 'root');

// Appel du contrôleur
$controller = new ProjetController($db);
$controller->listProjets();
?>
