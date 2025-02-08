<?php
require_once '../../autoload.php';
require_once '../../config/auth.php';

requireLogin();

use Controllers\ProjetController;

$id = $_GET['id'] ?? null;

if ($id) {
    $controller = new ProjetController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'titre' => $_POST['titre'],
            'description' => $_POST['description']
        ];

        // Mise à jour du projet
        if ($controller->updateProjet($id, $data)) {
            header('Location: /portfolio_v01/admin/projets/?success=updated');
            exit;
        } else {
            $error = 'Erreur lors de la mise à jour du projet';
        }
    }

    // Récupérer les détails du projet
    $projet = $controller->getProjet($id);
    if (!$projet) {
        header('Location: /portfolio_v01/admin/projets/?error=notfound');
        exit;
    }

    require_once __DIR__ . '/../../views/admin/projets/form.php';
} else {
    header('Location: /portfolio_v01/admin/projets/');
    exit;
}
