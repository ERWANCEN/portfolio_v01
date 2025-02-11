<?php
session_start();

require_once __DIR__ . '/autoload.php';
use Config\Database;

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query('SELECT id_projet, titre, image_principale FROM projet_template');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<pre>";
    print_r($projets);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
