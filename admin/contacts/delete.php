<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Controllers\ContactController;

requireAdmin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&error=1');
    exit();
}

$controller = new ContactController();
$controller->deleteMessage($_GET['id']);
