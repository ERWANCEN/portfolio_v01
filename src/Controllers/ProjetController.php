<?php

namespace Controllers;

use Models\Projet;
use Models\ImagesContexte;
use Models\EtapeProjet;
use Models\OutilsUtilises;
use Models\AvisProjet;
use Config\Database;
use Exception;
use Models\Template;

class ProjetController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listProjets()
    {
        try {
            $projets = Projet::findAll($this->db);
            include __DIR__ . '/../../views/admin/projets/list.php';
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des projets : ' . $e->getMessage();
        }
    }

    public function showProjet($id)
    {
        try {
            if (empty($id) || !is_numeric($id)) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=invalid_id');
                exit;
            }

            $projet = Projet::findById($this->db, $id);
            if (!$projet) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=notfound');
                exit;
            }

            include __DIR__ . '/../../views/admin/projets/show.php';
        } catch (Exception $e) {
            header('Location: /portfolio_v01/admin/projets/list.php?error=exception');
            exit;
        }
    }

    public function createProjet($data)
    {
        try {
            // Validation des données
            if (empty($data['titre']) || empty($data['texte_contexte']) || empty($data['image_principale'])) {
                die('Erreur : Tous les champs sont obligatoires.');
            }
    
            // Création du modèle
            $template = new Template(
                null,
                $data['titre'],
                $data['image_principale'],
                $data['texte_contexte'],
                $data['description']
            );
    
            // Sauvegarde en base de données
            $template->create($this->db);
    
            // Redirection en cas de succès
            header('Location: /portfolio_v01/admin/projets/list.php?success=created');
            exit;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    

    public function updateProjet($id, $data)
    {
        try {
            if (empty($id) || !is_numeric($id)) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=invalid_id');
                exit;
            }
    
            $titre = trim($data['titre']);
            $description = trim($data['description']);
    
            if (empty($titre) || empty($description)) {
                header('Location: /portfolio_v01/admin/projets/edit.php?id=' . $id . '&error=validation');
                exit;
            }
    
            $projet = Projet::findById($this->db, $id);
            if (!$projet) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=notfound');
                exit;
            }
    
            $projet->setTitre($titre);
            $projet->setDescription($description);
            $projet->update($this->db);
    
            // Redirection vers la liste après mise à jour
            header('Location: /portfolio_v01/admin/projets/list.php?success=updated');
            exit;
        } catch (Exception $e) {
            header('Location: /portfolio_v01/admin/projets/list.php?error=exception');
            exit;
        }
    }
    

    public function deleteProjet($id)
    {
        try {
            if (empty($id) || !is_numeric($id)) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=invalid_id');
                exit;
            }

            $projet = Projet::findById($this->db, $id);
            if (!$projet) {
                header('Location: /portfolio_v01/admin/projets/list.php?error=notfound');
                exit;
            }

            $projet->delete($this->db);
            header('Location: /portfolio_v01/admin/projets/list.php?success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: /portfolio_v01/admin/projets/list.php?error=exception');
            exit;
        }
    }

    public function showFullProject($id)
    {
        $db = Database::getConnection();

        // Récupérer les données liées au projet
        $projet = Projet::findById($db, $id);
        $imagesContexte = ImagesContexte::findByProjectId($db, $id);
        $etapes = EtapeProjet::findByProjectId($db, $id);
        $outils = OutilsUtilises::findByProjectId($db, $id);
        $avis = AvisProjet::findByProjectId($db, $id);

        // Si le projet n'existe pas
        if (!$projet) {
            die('Erreur : Le projet demandé est introuvable.');
        }

        // Inclure la vue pour afficher le projet
        include __DIR__ . '/../../views/template.php';
    }
}
