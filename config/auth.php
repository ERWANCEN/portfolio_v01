<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    // Débogage
    error_log('Session data: ' . print_r($_SESSION, true));
    
    if (!isset($_SESSION['admin'])) {
        error_log('No admin session');
        return false;
    }
    
    if (!is_numeric($_SESSION['admin'])) {
        error_log('Admin session value is not numeric');
        return false;
    }
    
    // Vérifier si l'administrateur existe dans la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=portfolio', 'root', 'root');
        $stmt = $db->prepare('SELECT id FROM administrateur WHERE id = :id');
        $stmt->execute(['id' => $_SESSION['admin']]);
        return $stmt->fetch() !== false;
    } catch (PDOException $e) {
        return false;
    }
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /portfolio_v01/admin/login.php');
        exit();
    }
}
