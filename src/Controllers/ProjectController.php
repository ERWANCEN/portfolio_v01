<?php

namespace Controllers;

use Config\Database;
use Exception;

class ProjectController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function moveToTrash($id)
    {
        try {
            $query = "UPDATE projet_template SET supprime = 1 WHERE id_projet = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            header('Location: ' . BASE_PATH . '/admin/projets/list.php?success=1');
            exit();
        } catch (Exception $e) {
            header('Location: ' . BASE_PATH . '/admin/projets/list.php?error=1');
            exit();
        }
    }

    public function restoreFromTrash($id)
    {
        try {
            $query = "UPDATE projet_template SET supprime = 0 WHERE id_projet = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            header('Location: ' . BASE_PATH . '/admin/projets/list.php?trash=1&success=1');
            exit();
        } catch (Exception $e) {
            header('Location: ' . BASE_PATH . '/admin/projets/list.php?trash=1&error=1');
            exit();
        }
    }

    public function deleteProject($id)
    {
        try {
            $query = "DELETE FROM projet_template WHERE id_projet = :id AND supprime = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);

            header('Location: ' . BASE_PATH . '/admin/projets/list.php?trash=1&success=1');
            exit();
        } catch (Exception $e) {
            header('Location: ' . BASE_PATH . '/admin/projets/list.php?trash=1&error=1');
            exit();
        }
    }
}
