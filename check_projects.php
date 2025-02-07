<?php
require_once __DIR__ . '/autoload.php';
use Config\Database;

try {
    $db = Database::getConnection();
    
    // Vérification des projets dans projet_template
    $stmt = $db->query('SELECT * FROM projet_template ORDER BY id_projet');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>État des projets :</h2>";
    foreach ($projets as $projet) {
        echo "<h3>Projet : {$projet['titre']} (ID: {$projet['id_projet']})</h3>";
        
        // Vérifier images_contexte
        $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = ?');
        $stmt->execute([$projet['id_projet']]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<strong>Images de contexte (" . count($images) . ") :</strong><br>";
        foreach ($images as $img) {
            echo "- {$img['titre_contexte']} ({$img['image']})<br>";
        }
        echo "<br>";
        
        // Vérifier etapes_projet
        $stmt = $db->prepare('SELECT * FROM etapes_projet WHERE id_projet = ?');
        $stmt->execute([$projet['id_projet']]);
        $etapes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<strong>Étapes (" . count($etapes) . ") :</strong><br>";
        foreach ($etapes as $index => $etape) {
            echo ($index + 1) . ". " . substr($etape['description'], 0, 100) . "...<br>";
        }
        echo "<br>";
        
        // Vérifier outils_utilises
        $stmt = $db->prepare('SELECT * FROM outils_utilises WHERE id_projet = ?');
        $stmt->execute([$projet['id_projet']]);
        $outils = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<strong>Outils (" . count($outils) . ") :</strong><br>";
        foreach ($outils as $outil) {
            echo "- {$outil['nom_outil']} ({$outil['image_outil']})<br>";
        }
        echo "<br>";
        
        // Vérifier avis_projet
        $stmt = $db->prepare('SELECT * FROM avis_projet WHERE id_projet = ?');
        $stmt->execute([$projet['id_projet']]);
        $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<strong>Avis (" . count($avis) . ") :</strong><br>";
        foreach ($avis as $a) {
            echo "- {$a['nom_auteur']} (Note: {$a['note']}/5)<br>";
        }
        echo "<hr>";
    }
    
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
