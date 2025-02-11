<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\DataBase;

requireAdmin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1');
    exit();
}

$id = (int)$_GET['id'];

try {
    $pdo = DataBase::getConnection();
    
    // Restauration du message
    $stmt = $pdo->prepare('UPDATE message_contact SET supprime = 0 WHERE id_message = ?');
    $stmt->execute([$id]);
    
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1');
    exit();
} catch (Exception $e) {
    error_log("Erreur lors de la restauration du message : " . $e->getMessage());
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&error=restore');
    exit();
}
