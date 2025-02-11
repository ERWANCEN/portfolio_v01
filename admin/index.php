<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../autoload.php';
use Config\DataBase;

session_start();

// Vérification de la connexion admin
if (!isset($_SESSION['admin']) || !is_numeric($_SESSION['admin'])) {
    header('Location: ' . BASE_PATH . '/admin/login.php');
    exit();
}

try {
    // Vérifier si l'administrateur existe toujours dans la base de données
    $pdo = DataBase::getConnection();
    $stmt = $pdo->prepare('SELECT id FROM administrateur WHERE id = ?');
    $stmt->execute([$_SESSION['admin']]);
    
    if (!$stmt->fetch()) {
        // L'administrateur n'existe plus
        session_destroy();
        header('Location: ' . BASE_PATH . '/admin/login.php');
        exit();
    }
} catch (Exception $e) {
    // En cas d'erreur de base de données, déconnecter par sécurité
    session_destroy();
    header('Location: ' . BASE_PATH . '/admin/login.php');
    exit();
}

// Inclure la vue du tableau de bord
require_once __DIR__ . '/../views/admin/dashboard.php';
