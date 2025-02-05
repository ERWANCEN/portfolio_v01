<?php

use Config\Database;
use Controllers\ProjetController;

require_once '../../autoload.php';

// Connexion via Database
$db = Database::getConnection();

$id = $_GET['id'] ?? null;

if ($id) {
    $controller = new ProjetController();
    $controller->deleteProjet($id);
} else {
    echo 'ID du projet manquant.';
}
