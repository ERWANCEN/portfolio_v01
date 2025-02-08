<?php
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../../config/auth.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

use Controllers\ContactController;

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /portfolio_v01/admin/contacts/index.php');
    exit();
}

// Supprimer le message
$controller = new ContactController();
$controller->deleteContact($_GET['id']);
