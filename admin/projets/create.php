<?php

use Config\Database;
use Controllers\ProjetController;

require_once '../../autoload.php';

// Obtenir la connexion à la base de données
$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $data = [
        'titre' => $_POST['titre'] ?? '',
        'texte_contexte' => $_POST['texte_contexte'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    // Gestion du fichier image
    $uploadDir = __DIR__ . '/../../assets/images/';
    $imageName = basename($_FILES['image_principale']['name'] ?? '');
    $uploadFile = $uploadDir . $imageName;

    if (isset($_FILES['image_principale']) && $_FILES['image_principale']['error'] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $uploadFile)) {
            $data['image_principale'] = '/portfolio_v01/assets/images/' . $imageName;
        } else {
            die('Erreur lors du téléchargement de l\'image.');
        }
    }

    // Appeler le contrôleur pour créer le projet
    $controller = new ProjetController();
    $controller->createProjet($data);
} else {
    // Affichage du formulaire
    include __DIR__ . '/../../../views/admin/projets/form.php';
}
