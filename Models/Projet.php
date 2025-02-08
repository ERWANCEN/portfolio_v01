<?php

namespace Models;

class Projet {
    private $id;
    private $titre;
    private $description;
    private $created_at;
    private $templates;
    private $images_contexte;
    private $outils;
    private $etapes;
    private $avis;

    public function __construct(array $data = []) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->created_at; }
    public function getTemplates() { return $this->templates; }
    public function getImagesContexte() { return $this->images_contexte; }
    public function getOutils() { return $this->outils; }
    public function getEtapes() { return $this->etapes; }
    public function getAvis() { return $this->avis; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTitre($titre) { $this->titre = $titre; }
    public function setDescription($description) { $this->description = $description; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setTemplates($templates) { $this->templates = $templates; }
    public function setImagesContexte($images_contexte) { $this->images_contexte = $images_contexte; }
    public function setOutils($outils) { $this->outils = $outils; }
    public function setEtapes($etapes) { $this->etapes = $etapes; }
    public function setAvis($avis) { $this->avis = $avis; }

    public static function findById($db, $id) {
        try {
            // Récupération des informations du projet depuis projet_template
            $stmt = $db->prepare('SELECT * FROM projet_template WHERE id_projet = ?');
            $stmt->execute([$id]);
            $projet = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$projet) {
                return null;
            }

            // Restructuration des données
            $projetData = [
                'id' => $projet['id_projet'],
                'titre' => $projet['titre'] ?? '',
                'description' => '',  // La description n'est plus nécessaire car nous avons texte_contexte
                'image_principale' => $projet['image_principale'] ?? '',
                'texte_contexte' => $projet['texte_contexte'] ?? '',
                'texte_details' => $projet['texte_details'] ?? '',
                'date_creation' => $projet['date_creation'] ?? date('Y-m-d H:i:s'),
                'images_contexte' => [],
                'outils' => [],
                'etapes' => [],
                'avis' => []
            ];

            // Récupération des images de contexte
            $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = ?');
            $stmt->execute([$id]);
            $projetData['images_contexte'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Récupération des outils
            $stmt = $db->prepare('SELECT * FROM outils_utilises WHERE id_projet = ?');
            $stmt->execute([$id]);
            $projetData['outils'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Récupération des étapes
            $stmt = $db->prepare('SELECT ep.*, e.nom as nom_etape FROM etapes_projet ep
                                 LEFT JOIN etapes e ON ep.id_etape = e.id
                                 WHERE ep.id_projet = ?');
            $stmt->execute([$id]);
            $projetData['etapes'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Récupération des avis
            $stmt = $db->prepare('SELECT * FROM avis_projet WHERE id_projet = ?');
            $stmt->execute([$id]);
            $projetData['avis'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $projetData;
        } catch (\Exception $e) {
            error_log('Erreur lors de la récupération du projet : ' . $e->getMessage());
            return null;
        }
    }
}
