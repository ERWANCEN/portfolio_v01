<?php
// Charger l'autoloader et l'authentification
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../../config/auth.php';

// Vérifier si l'utilisateur est connecté
requireLogin();


// Utiliser le contrôleur ContactController
use Controllers\ContactController;

// Appeler le contrôleur
$controller = new ContactController();
$controller->listContacts();  // Cette méthode va récupérer les contacts et inclure la vue
