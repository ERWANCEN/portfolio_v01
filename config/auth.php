<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/paths.php';
use Config\Database;

function isLoggedIn() {
    if (!isset($_SESSION['admin']) || !is_numeric($_SESSION['admin'])) {
        return false;
    }
    
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT id FROM administrateur WHERE id = ?');
        $stmt->execute([$_SESSION['admin']]);
        return (bool) $stmt->fetch();
    } catch (Exception $e) {
        error_log('Erreur de vérification admin : ' . $e->getMessage());
        return false;
    }
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_PATH . '/admin/login.php');
        exit();
    }
}
