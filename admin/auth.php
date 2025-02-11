<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../autoload.php';
use Config\DataBase;

function requireAdmin() {
    if (!isset($_SESSION['admin']) || !is_numeric($_SESSION['admin'])) {
        header('Location: ' . BASE_PATH . '/admin/login.php');
        exit();
    }

    try {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare('SELECT id FROM administrateur WHERE id = ?');
        $stmt->execute([$_SESSION['admin']]);
        
        if (!$stmt->fetch()) {
            session_destroy();
            header('Location: ' . BASE_PATH . '/admin/login.php');
            exit();
        }
    } catch (Exception $e) {
        error_log('Erreur de vérification admin : ' . $e->getMessage());
        session_destroy();
        header('Location: ' . BASE_PATH . '/admin/login.php');
        exit();
    }
}
