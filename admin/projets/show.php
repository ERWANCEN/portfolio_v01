<?php

require_once '../../autoload.php';
require_once '../../config/auth.php';

requireLogin();

use Controllers\ProjetController;

$id = $_GET['id'] ?? null;

if ($id) {
    $controller = new ProjetController();
    $projet = $controller->getProjet($id);
    
    if ($projet) {
        // Récupérer les informations supplémentaires
        $controller->showProjet($id);
    } else {
        header('Location: /portfolio_v01/admin/projets/');
        exit();
    }
} else {
    header('Location: /portfolio_v01/admin/projets/');
    exit();
}
