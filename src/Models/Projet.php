<?php

namespace Models;

use PDO;
use Exception;

class Projet
{
    private $id_projet;
    private $titre;
    private $texte_contexte;
    private $texte_details;
    private $image_principale;
    private $date_creation;

    public function __construct($id_projet = null, $titre = null, $texte_contexte = null, $texte_details = null, $image_principale = null)
    {
        $this->id_projet = $id_projet;
        $this->titre = $titre;
        $this->texte_contexte = $texte_contexte;
        $this->texte_details = $texte_details;
        $this->image_principale = $image_principale;
    }

    // GETTERS
    public function getId()
    {
        return $this->id_projet;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getTexteContexte()
    {
        return $this->texte_contexte;
    }

    public function getTexteDetails()
    {
        return $this->texte_details;
    }

    public function getImagePrincipale()
    {
        return $this->image_principale;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    // SETTERS
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setTexteContexte($texte_contexte)
    {
        $this->texte_contexte = $texte_contexte;
    }

    public function setTexteDetails($texte_details)
    {
        $this->texte_details = $texte_details;
    }

    public function setImagePrincipale($image_principale)
    {
        $this->image_principale = $image_principale;
    }

    // Méthode pour créer un projet dans la base de données
    public function create(PDO $db)
    {
        // Validation des champs obligatoires
        if (empty($this->titre)) {
            throw new Exception('Le champ titre est obligatoire.');
        }

        $stmt = $db->prepare('INSERT INTO projet_template (titre, texte_contexte, texte_details, image_principale, date_creation) 
                             VALUES (:titre, :texte_contexte, :texte_details, :image_principale, NOW())');
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':texte_contexte', $this->texte_contexte);
        $stmt->bindParam(':texte_details', $this->texte_details);
        $stmt->bindParam(':image_principale', $this->image_principale);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de la création du projet.');
        }

        $this->id_projet = $db->lastInsertId();
    }

    // Méthode pour récupérer un projet par son ID
    public static function findById(PDO $db, $id)
    {
        $stmt = $db->prepare('SELECT * FROM projet_template WHERE id_projet = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $projet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($projet) {
            // Récupérer les images de contexte
            $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['images_contexte'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les outils
            $stmt = $db->prepare('SELECT * FROM outils_utilises WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['outils'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les étapes
            $stmt = $db->prepare('SELECT * FROM etapes_projet WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['etapes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les avis
            $stmt = $db->prepare('SELECT * FROM avis_projet WHERE id_projet = :id_projet');
            $stmt->execute(['id_projet' => $id]);
            $projet['avis'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $projet;
    }

    // Méthode pour récupérer tous les projets
    public static function findAll(PDO $db)
    {
        $stmt = $db->query('SELECT * FROM projet_template ORDER BY id_projet DESC');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $projets = [];

        foreach ($results as $row) {
            $projets[] = new self($row['id'], $row['titre'], $row['description']);
        }

        return $projets;
    }

    // Méthode pour mettre à jour un projet
    public function update(PDO $db)
    {
        // Validation des champs obligatoires
        if (empty($this->titre) || empty($this->description)) {
            throw new Exception('Les champs titre et description sont obligatoires.');
        }

        if (!$this->id) {
            throw new Exception('Impossible de mettre à jour un projet sans ID.');
        }

        $stmt = $db->prepare('UPDATE projets SET titre = :titre, description = :description WHERE id = :id');
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de la mise à jour du projet.');
        }
    }

    // Méthode pour supprimer un projet
    public function delete(PDO $db)
    {
        if (!$this->id) {
            throw new Exception('Impossible de supprimer un projet sans ID.');
        }

        $stmt = $db->prepare('DELETE FROM projets WHERE id = :id');
        $stmt->bindParam(':id', $this->id);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de la suppression du projet.');
        }
    }
}
