<?php

namespace Controllers;

use PDO;

class ProjetController {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=portfolio', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function listProjets() {
        $query = $this->db->query('
            SELECT * FROM projet_template
            ORDER BY id_projet DESC
        ');
        $projets = $query->fetchAll();
        require_once __DIR__ . '/../../views/admin/projets/list.php';
    }

    public function getProjet($id) {
        $stmt = $this->db->prepare('SELECT * FROM projet_template WHERE id_projet = :id');
        $stmt->execute(['id' => $id]);
        $projet = $stmt->fetch();

        if ($projet) {
            // Récupérer les images de contexte
            $stmt = $this->db->prepare('SELECT * FROM images_contexte WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['images_contexte'] = $stmt->fetchAll();

            // Récupérer les outils
            $stmt = $this->db->prepare('SELECT * FROM outils_utilises WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['outils'] = $stmt->fetchAll();

            // Récupérer les étapes
            $stmt = $this->db->prepare('SELECT * FROM etapes_projet WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['etapes'] = $stmt->fetchAll();

            // Récupérer les avis
            $stmt = $this->db->prepare('SELECT * FROM avis_projet WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['avis'] = $stmt->fetchAll();
        }

        return $projet;
    }

    public function showProjet($id) {
        $projet = $this->getProjet($id);
        if ($projet) {
            require_once __DIR__ . '/../../views/admin/projets/show.php';
        } else {
            header('Location: /portfolio_v01/admin/projets/');
            exit();
        }
    }

    public function createProjet($data) {
        try {
            $stmt = $this->db->prepare('INSERT INTO projet_template (titre, texte_contexte, texte_details, image_principale, date_creation) 
                                       VALUES (:titre, :texte_contexte, :texte_details, :image_principale, NOW())');
            $success = $stmt->execute([
                'titre' => $data['titre'],
                'texte_contexte' => $data['texte_contexte'] ?? '',
                'texte_details' => $data['texte_details'] ?? '',
                'image_principale' => $data['image_principale'] ?? ''
            ]);

            if ($success) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            error_log('Erreur lors de la création du projet : ' . $e->getMessage());
            return false;
        }
    }

    public function updateProjet($id, $data) {
        try {
            $stmt = $this->db->prepare('UPDATE projet_template 
                                       SET titre = :titre, 
                                           texte_contexte = :texte_contexte, 
                                           texte_details = :texte_details, 
                                           image_principale = :image_principale 
                                       WHERE id_projet = :id');
            return $stmt->execute([
                'id' => $id,
                'titre' => $data['titre'],
                'texte_contexte' => $data['texte_contexte'] ?? '',
                'texte_details' => $data['texte_details'] ?? '',
                'image_principale' => $data['image_principale'] ?? ''
            ]);
        } catch (\PDOException $e) {
            error_log('Erreur lors de la mise à jour du projet : ' . $e->getMessage());
            return false;
        }
    }

    public function deleteProjet($id) {
        try {
            // Supprimer d'abord les enregistrements liés
            $tables = ['images_contexte', 'outils_utilises', 'etapes_projet', 'avis_projet'];
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id_projet = :id");
                $stmt->execute(['id' => $id]);
            }

            // Puis supprimer le projet lui-même
            $stmt = $this->db->prepare('DELETE FROM projet_template WHERE id_projet = :id');
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            error_log('Erreur lors de la suppression du projet : ' . $e->getMessage());
            return false;
        }
    }
}
