<?php

use Config\Database;
use Controllers\ProjetController;

require_once '../../autoload.php';

// Obtenir la connexion à la base de données
$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titre' => $_POST['titre'],
        'description' => $_POST['description']
    ];

    $controller = new ProjetController();
    $controller->createProjet($data);
} else {
    // Affichage du formulaire
    include __DIR__ . '../../../views/admin/projets/form.php';
}
require_once '../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    exit;
}
