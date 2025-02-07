<?php

namespace Models;

use PDO;
use Exception;

class Template
{
    private $idProjet;
    private $titre;
    private $imagePrincipale;
    private $texteContexte;
    private $texteDetails;
    private $dateCreation;

    public function __construct($idProjet = null, $titre = null, $imagePrincipale = null, $texteContexte = null, $texteDetails = null, $dateCreation = null)
    {
        $this->idProjet = $idProjet;
        $this->titre = $titre;
        $this->imagePrincipale = $imagePrincipale;
        $this->texteContexte = $texteContexte;
        $this->texteDetails = $texteDetails;
        $this->dateCreation = $dateCreation;
    }

    // GETTERS
    public function getIdProjet() { return $this->idProjet; }
    public function getTitre() { return $this->titre; }
    public function getImagePrincipale() { return $this->imagePrincipale; }
    public function getTexteContexte() { return $this->texteContexte; }
    public function getTexteDetails() { return $this->texteDetails; }
    public function getDateCreation() { return $this->dateCreation; }

    // Méthode pour créer un projet
    public function create(PDO $db)
    {
        $stmt = $db->prepare('INSERT INTO projet_template (titre, image_principale, texte_contexte, texte_details) VALUES (:titre, :image_principale, :texte_contexte, :texte_details)');
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':image_principale', $this->imagePrincipale);
        $stmt->bindParam(':texte_contexte', $this->texteContexte);
        $stmt->bindParam(':texte_details', $this->texteDetails);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de la création du projet.');
        }

        $this->idProjet = $db->lastInsertId();
    }

    // Méthode pour récupérer un projet
    public static function findById(PDO $db, $idProjet)
    {
        $stmt = $db->prepare('SELECT * FROM projet_template WHERE id_projet = :id_projet');
        $stmt->bindParam(':id_projet', $idProjet, PDO::PARAM_INT);
        $stmt->execute();

        $projet = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$projet) {
            throw new Exception('Projet introuvable.');
        }

        return new self(
            $projet['id_projet'],
            $projet['titre'],
            $projet['image_principale'],
            $projet['texte_contexte'],
            $projet['texte_details'],
            $projet['date_creation']
        );
    }
}
