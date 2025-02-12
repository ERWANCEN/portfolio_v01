<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

requireAdmin();

use Controllers\ContactController;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&error=1');
    exit();
}

$controller = new ContactController();
$controller->restoreFromTrash($_GET['id']);
