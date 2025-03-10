<?php

namespace Models;

use PDO;

class ImagesContexte
{
    public static function findByProjectId(PDO $db, $idProjet)
    {
        $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = :id_projet');
        $stmt->bindParam(':id_projet', $idProjet, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
