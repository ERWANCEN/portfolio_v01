<?php
session_start();

require_once __DIR__ . '/autoload.php';
use Config\Database;

try {
    $pdo = Database::getConnection();
    
    // Mise à jour des extensions jpg vers webp
    $stmt = $pdo->prepare('UPDATE projet_template SET image_principale = REPLACE(image_principale, ".jpg", ".webp") WHERE image_principale LIKE "%.jpg"');
    $stmt->execute();
    
    // Vérification des mises à jour
    $stmt = $pdo->query('SELECT id_projet, titre, image_principale FROM projet_template');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<pre>";
    echo "Images mises à jour avec succès :\n";
    print_r($projets);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
