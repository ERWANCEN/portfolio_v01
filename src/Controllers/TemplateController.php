<?php

namespace Controllers;

use Models\Template;
use Config\Database;
use Exception;

class TemplateController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Afficher un projet template avec ses données
    public function showTemplate($idProjet)
    {
        try {
            $data = Template::findById($this->db, $idProjet);
            
            // Extraction des données à passer à la vue
            $project = $data['projet'];
            $imagesContexte = $data['images_contexte'];
            $etapes = $data['etapes'];
            $outils = $data['outils'];
            $avis = $data['avis'];
    
            include __DIR__ . '/../../views/template.php';
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    
}
