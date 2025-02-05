<?php
// Charger l'autoloader pour les classes
require_once __DIR__ . '/../../autoload.php';


// Utiliser le contrôleur ContactController
use Controllers\ContactController;

// Appeler le contrôleur
$controller = new ContactController();
$controller->listContacts();  // Cette méthode va récupérer les contacts et inclure la vue
