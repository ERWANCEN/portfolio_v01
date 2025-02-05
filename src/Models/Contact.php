<?php

namespace Models;

use PDO;
use Exception;

class Contact
{
    private $idMessage;
    private $nom;
    private $email;
    private $message;
    private $dateEnvoi;

    public function __construct($idMessage = null, $nom = null, $email = null, $message = null, $dateEnvoi = null)
    {
        $this->idMessage = $idMessage;
        $this->nom = $nom;
        $this->email = $email;
        $this->message = $message;
        $this->dateEnvoi = $dateEnvoi;
    }

    // GETTERS
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    // Méthode pour enregistrer un contact en base de données
    public function save(PDO $db)
    {
        // Validation des champs obligatoires
        if (empty($this->nom) || empty($this->email) || empty($this->message)) {
            throw new Exception('Les champs nom, email et message sont obligatoires.');
        }

        $stmt = $db->prepare('INSERT INTO message_contact (nom, email, message) VALUES (:nom, :email, :message)');
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':message', $this->message);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de l\'enregistrement du message.');
        }

        $this->idMessage = $db->lastInsertId();
    }

    // Méthode pour récupérer tous les messages
    public static function findAll(PDO $db)
    {
        $stmt = $db->query('SELECT * FROM message_contact ORDER BY date_envoi DESC');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $contacts = [];
        foreach ($results as $row) {
            $contacts[] = new self($row['id_message'], $row['nom'], $row['email'], $row['message'], $row['date_envoi']);
        }
    
        return $contacts;
    }
    

    // Méthode pour récupérer un contact par son ID
    public static function findById(PDO $db, $idMessage)
    {
        $stmt = $db->prepare('SELECT * FROM message_contact WHERE id_message = :id_message');
        $stmt->bindParam(':id_message', $idMessage, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return new self($result['id_message'], $result['nom'], $result['email'], $result['message'], $result['date_envoi']);
    }
}
