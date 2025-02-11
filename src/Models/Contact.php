<?php
namespace Models;

use PDO;
use Config\DataBase;

class Contact
{
    private $pdo;
    public $nom;
    public $email;
    public $message;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save()
    {
        try {
            // Validation
            if (empty($this->nom) || empty($this->email) || empty($this->message)) {
                throw new \Exception("Tous les champs sont obligatoires");
            }

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("L'adresse email n'est pas valide");
            }

            // Insertion dans la base de données
            $sql = "INSERT INTO message_contact (nom, email, message, date_envoi) VALUES (:nom, :email, :message, NOW())";
            error_log("SQL Query: " . $sql);
            error_log("Params: " . json_encode([
                ':nom' => $this->nom,
                ':email' => $this->email,
                ':message' => $this->message
            ]));
            
            $stmt = $this->pdo->prepare($sql);
            
            $result = $stmt->execute([
                ':nom' => $this->nom,
                ':email' => $this->email,
                ':message' => $this->message
            ]);

            if (!$result) {
                $error = $stmt->errorInfo();
                error_log("SQL Error: " . json_encode($error));
                throw new \Exception("Erreur lors de l'insertion : " . $error[2]);
            }

            return true;
        } catch (\Exception $e) {
            error_log("Erreur dans Contact::save() : " . $e->getMessage());
            throw $e;
        }
    }
}
