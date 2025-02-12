<?php

namespace Controllers;

use Models\Contact;
use Config\Database;
use Exception;

class ContactController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listContacts()
    {
        try {
            // Récupérer les messages de contact
            $contacts = Contact::findAll($this->db);

            // Inclure la vue correcte
            include __DIR__ . '/../../views/admin/contacts/list.php';
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des contacts : ' . $e->getMessage();
        }
    }

    public function moveToTrash($id)
    {
        try {
            $query = "UPDATE message_contact SET supprime = 1 WHERE id_message = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            // Rediriger vers la liste des messages avec un message de succès
            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?success=1');
            exit();
        } catch (Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?error=1');
            exit();
        }
    }

    public function restoreFromTrash($id)
    {
        try {
            $query = "UPDATE message_contact SET supprime = 0 WHERE id_message = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&success=1');
            exit();
        } catch (Exception $e) {
            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&error=1');
            exit();
        }
    }

    public function deleteMessage($id)
    {
        try {
            $query = "DELETE FROM message_contact WHERE id_message = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&success=1');
            exit();
        } catch (Exception $e) {
            header('Location: ' . BASE_PATH . '/admin/contacts/index.php?trash=1&error=1');
            exit();
        }
    }
}
