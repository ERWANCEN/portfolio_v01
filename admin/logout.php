<?php
require_once __DIR__ . '/../config/paths.php';

session_start();
session_destroy();
header('Location: ' . BASE_PATH . '/admin/login.php');
exit();
