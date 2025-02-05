<?php
use Config\Database;
use Models\Projet;
use Controllers\ProjetController;

require_once '../../autoload.php';

// Connexion via Database
$db = Database::getConnection();

$id = $_GET['id'] ?? null;

if ($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'titre' => $_POST['titre'],
            'description' => $_POST['description']
        ];

        // Appeler le contrôleur pour mettre à jour le projet
        $controller = new ProjetController();
        $controller->updateProjet($id, $data);

        // Redirection après la mise à jour
        header('Location: /portfolio_v01/admin/projets/list.php?success=updated');
        exit;
    } else {
        // Récupérer les détails du projet
        $projet = Projet::findById($db, $id);
        if (!$projet) {
            header('Location: /portfolio_v01/admin/projets/list.php?error=notfound');
            exit;
        }

        include '../../views/admin/projets/form.php';  // Affichage du formulaire de modification
    }
} else {
    echo 'ID du projet manquant.';
}
