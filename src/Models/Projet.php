<?php

namespace Models;

use PDO;
use Exception;

class Projet
{
    private $id;
    private $titre;
    private $description;

    public function __construct($id = null, $titre = null, $description = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
    }

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    // SETTERS
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    // Méthode pour créer un projet dans la base de données
    public function create(PDO $db)
    {
        // Validation des champs obligatoires
        if (empty($this->titre) || empty($this->description)) {
            throw new Exception('Les champs titre et description sont obligatoires.');
        }

        $stmt = $db->prepare('INSERT INTO projets (titre, description) VALUES (:titre, :description)');
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de la création du projet.');
        }

        $this->id = $db->lastInsertId();
    }

    // Méthode pour récupérer un projet par son ID
    public static function findById(PDO $db, $id)
    {
        $stmt = $db->prepare('SELECT * FROM projets WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return new self($result['id'], $result['titre'], $result['description']);
    }

    // Méthode pour récupérer tous les projets
    public static function findAll(PDO $db)
    {
        $stmt = $db->query('SELECT * FROM projets ORDER BY id DESC');
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
