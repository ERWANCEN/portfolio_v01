<?php
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../../config/auth.php';

requireLogin();

use Controllers\ContactController;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /portfolio_v01/admin/contacts/index.php');
    exit();
}

$controller = new ContactController();
$controller->moveToTrash($_GET['id']);
