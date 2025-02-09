<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/Database.php';

// Vérification stricte de la session
if (!isLoggedIn()) {
    session_destroy();
    header('Location: /portfolio_v01/admin/login.php');
    exit();
}

// Inclure la vue du tableau de bord
require_once __DIR__ . '/../views/admin/dashboard.php';
