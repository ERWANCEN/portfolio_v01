<?php

namespace Models;

class Contact {
    private $id;
    private $nom;
    private $email;
    private $message;
    private $date_creation;

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }
}
