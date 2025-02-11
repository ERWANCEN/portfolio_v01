<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\Database;

requireAdmin();

$pdo = Database::getConnection();

// Vérification de l'ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . BASE_PATH . '/admin/projets/');
    exit();
}

try {
    $stmt = $pdo->prepare('SELECT * FROM projet_template WHERE id_projet = ?');
    $stmt->execute([$_GET['id']]);
    $projet = $stmt->fetch();
    
    if (!$projet) {
        header('Location: ' . BASE_PATH . '/admin/projets/');
        exit();
    }
} catch (Exception $e) {
    header('Location: ' . BASE_PATH . '/admin/projets/');
    exit();
}

use Controllers\ProjetController;

$controller = new ProjetController();
$controller->showProjet($_GET['id']);
