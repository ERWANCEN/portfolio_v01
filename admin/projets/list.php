<?php
// Chargement automatique des classes et authentification
require_once '../../autoload.php';
require_once '../../config/auth.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

use Controllers\ProjetController;

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=portfolio_crud', 'root', 'root');

// Appel du contrôleur
$controller = new ProjetController($db);
$controller->listProjets();
?>
