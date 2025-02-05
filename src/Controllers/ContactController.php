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
}
