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
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php');
    exit();
}

$id = (int)$_GET['id'];
$permanent = isset($_GET['permanent']) && $_GET['permanent'] === '1';

try {
    $pdo = DataBase::getConnection();
    
    if ($permanent) {
        // Suppression définitive
        $stmt = $pdo->prepare('DELETE FROM message_contact WHERE id_message = ?');
        $stmt->execute([$id]);
    } else {
        // Mise à la corbeille
        $stmt = $pdo->prepare('UPDATE message_contact SET supprime = 1 WHERE id_message = ?');
        $stmt->execute([$id]);
    }
    
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php' . ($permanent ? '?trash=1' : ''));
    exit();
} catch (Exception $e) {
    error_log("Erreur lors de la suppression du message : " . $e->getMessage());
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?error=delete');
    exit();
}
