<?php
session_start();

require_once __DIR__ . '/autoload.php';
use Config\Database;

try {
    $pdo = Database::getConnection();
    
    // Afficher les chemins d'images actuels
    echo "Chemins d'images actuels :\n";
    $stmt = $pdo->query('SELECT id_projet, titre, image_principale FROM projet_template');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($projets);
    
    // Mettre à jour les extensions jpg en webp
    $stmt = $pdo->prepare('UPDATE projet_template SET image_principale = REPLACE(image_principale, ".jpg", ".webp") WHERE image_principale LIKE "%.jpg"');
    $stmt->execute();
    
    // Mettre à jour les chemins qui contiennent "images/" en double
    $stmt = $pdo->prepare('UPDATE projet_template SET image_principale = REPLACE(image_principale, "images/images/", "images/") WHERE image_principale LIKE "%images/images/%"');
    $stmt->execute();
    
    // Afficher les chemins d'images mis à jour
    echo "\nChemins d'images après mise à jour :\n";
    $stmt = $pdo->query('SELECT id_projet, titre, image_principale FROM projet_template');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($projets);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
