<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\DataBase;

requireAdmin();

$pageTitle = 'Ajouter un projet';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = DataBase::getConnection();
        
        // Récupérer les données du formulaire
        $titre = $_POST['titre'] ?? '';
        $texte_contexte = $_POST['texte_contexte'] ?? '';
        $texte_details = $_POST['texte_details'] ?? '';
        
        // Gestion de l'image principale
        $image_principale = '';
        if (isset($_FILES['image_principale']) && $_FILES['image_principale']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/images/';
            $filename = basename($_FILES['image_principale']['name']);
            $uploadFile = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $uploadFile)) {
                $image_principale = $filename;
            } else {
                throw new Exception('Erreur lors du téléchargement de l\'image principale.');
            }
        }
        
        // Insérer le projet dans la base de données
        $pdo->beginTransaction();

        // Insertion du projet principal
        $query = "INSERT INTO projet_template (titre, texte_contexte, texte_details, image_principale, date_creation) 
                 VALUES (:titre, :texte_contexte, :texte_details, :image_principale, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'titre' => $titre,
            'texte_contexte' => $texte_contexte,
            'texte_details' => $texte_details,
            'image_principale' => $image_principale
        ]);
        
        $projetId = $pdo->lastInsertId();

        // Insertion des étapes
        if (isset($_POST['etapes']) && is_array($_POST['etapes'])) {
            $queryEtape = "INSERT INTO etapes_projet (id_projet, description) VALUES (:id_projet, :description)";
            $stmtEtape = $pdo->prepare($queryEtape);
            
            foreach ($_POST['etapes'] as $description) {
                if (!empty(trim($description))) {
                    $stmtEtape->execute([
                        'id_projet' => $projetId,
                        'description' => $description
                    ]);
                }
            }
        }

        // Insertion des images de contexte
        if (isset($_FILES['images_contexte']) && isset($_POST['titres_contexte']) && isset($_POST['textes_contexte'])) {
            $queryImage = "INSERT INTO images_contexte (id_projet, image, titre_contexte, texte_contexte) 
                          VALUES (:id_projet, :image, :titre_contexte, :texte_contexte)";
            $stmtImage = $pdo->prepare($queryImage);
            
            foreach ($_FILES['images_contexte']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images_contexte']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['images_contexte']['name'][$key]);
                    $uploadFile = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $stmtImage->execute([
                            'id_projet' => $projetId,
                            'image' => $filename,
                            'titre_contexte' => $_POST['titres_contexte'][$key],
                            'texte_contexte' => $_POST['textes_contexte'][$key]
                        ]);
                    }
                }
            }
        }

        // Insertion des outils utilisés
        if (isset($_FILES['images_outil']) && isset($_POST['noms_outil'])) {
            $queryOutil = "INSERT INTO outils_utilises (id_projet, image_outil, nom_outil) 
                          VALUES (:id_projet, :image_outil, :nom_outil)";
            $stmtOutil = $pdo->prepare($queryOutil);
            
            foreach ($_FILES['images_outil']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images_outil']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['images_outil']['name'][$key]);
                    $uploadFile = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $stmtOutil->execute([
                            'id_projet' => $projetId,
                            'image_outil' => $filename,
                            'nom_outil' => $_POST['noms_outil'][$key]
                        ]);
                    }
                }
            }
        }

        // Insertion des avis
        if (isset($_POST['auteurs_avis']) && isset($_POST['textes_avis']) && isset($_POST['notes_avis'])) {
            $queryAvis = "INSERT INTO avis_projet (id_projet, nom_auteur, texte_avis, note) 
                         VALUES (:id_projet, :nom_auteur, :texte_avis, :note)";
            $stmtAvis = $pdo->prepare($queryAvis);
            
            foreach ($_POST['auteurs_avis'] as $key => $auteur) {
                if (!empty(trim($auteur)) && !empty(trim($_POST['textes_avis'][$key]))) {
                    $stmtAvis->execute([
                        'id_projet' => $projetId,
                        'nom_auteur' => $auteur,
                        'texte_avis' => $_POST['textes_avis'][$key],
                        'note' => $_POST['notes_avis'][$key]
                    ]);
                }
            }
        }

        $pdo->commit();
        header('Location: ' . BASE_PATH . '/admin/projets/list.php?success=1');
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
    <style>
        .dynamic-form-group { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .dynamic-form-group .form-group { margin-bottom: 10px; }
        .remove-item { cursor: pointer; }
        .add-item { margin-top: 10px; }
    </style>
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal texte_dark_mode">Ajouter un projet</h1>

                <?php if (isset($error)): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" class="admin-form">
                    <!-- Informations principales -->
                    <div class="form-section">
                        <h2>Informations principales</h2>
                        <div class="form-group">
                            <label for="titre">Titre du projet</label>
                            <input type="text" id="titre" name="titre" required 
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="texte_contexte">Contexte</label>
                            <textarea id="texte_contexte" name="texte_contexte" required rows="4"><?= isset($_POST['texte_contexte']) ? htmlspecialchars($_POST['texte_contexte']) : '' ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="texte_details">Détails</label>
                            <textarea id="texte_details" name="texte_details" required rows="8"><?= isset($_POST['texte_details']) ? htmlspecialchars($_POST['texte_details']) : '' ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image_principale">Image principale</label>
                            <input type="file" id="image_principale" name="image_principale" accept="image/*" required>
                        </div>
                    </div>

                    <!-- Étapes du projet -->
                    <div class="form-section">
                        <h2>Étapes du projet</h2>
                        <div id="etapes-container">
                            <div class="dynamic-form-group">
                                <div class="form-group">
                                    <label>Description de l'étape</label>
                                    <textarea name="etapes[]" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addEtape()">Ajouter une étape</button>
                    </div>

                    <!-- Images de contexte -->
                    <div class="form-section">
                        <h2>Images de contexte</h2>
                        <div id="images-contexte-container">
                            <div class="dynamic-form-group">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="images_contexte[]" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <label>Titre du contexte</label>
                                    <input type="text" name="titres_contexte[]" required>
                                </div>
                                <div class="form-group">
                                    <label>Texte du contexte</label>
                                    <textarea name="textes_contexte[]" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addImageContexte()">Ajouter une image de contexte</button>
                    </div>

                    <!-- Outils utilisés -->
                    <div class="form-section">
                        <h2>Outils utilisés</h2>
                        <div id="outils-container">
                            <div class="dynamic-form-group">
                                <div class="form-group">
                                    <label>Image de l'outil</label>
                                    <input type="file" name="images_outil[]" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <label>Nom de l'outil</label>
                                    <input type="text" name="noms_outil[]" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addOutil()">Ajouter un outil</button>
                    </div>

                    <!-- Avis -->
                    <div class="form-section">
                        <h2>Avis sur le projet</h2>
                        <div id="avis-container">
                            <div class="dynamic-form-group">
                                <div class="form-group">
                                    <label>Nom de l'auteur</label>
                                    <input type="text" name="auteurs_avis[]" required>
                                </div>
                                <div class="form-group">
                                    <label>Texte de l'avis</label>
                                    <textarea name="textes_avis[]" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Note (1-5)</label>
                                    <input type="number" name="notes_avis[]" min="1" max="5" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addAvis()">Ajouter un avis</button>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-reply">Enregistrer</button>
                        <a href="<?= BASE_PATH ?>/admin/projets/list.php" class="btn-back">Annuler</a>
                    </div>
                </form>
            </div>
        </main>

        <?php include __DIR__ . '/../../config/inc/footer.inc.php'; ?>
    </div>

    <script src="<?= BASE_PATH ?>/assets/js/dark_mode.js"></script>
    <script>
        function createRemoveButton() {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn-delete remove-item';
            button.textContent = 'Supprimer';
            button.onclick = function() {
                this.closest('.dynamic-form-group').remove();
            };
            return button;
        }

        function addEtape() {
            const container = document.getElementById('etapes-container');
            const div = document.createElement('div');
            div.className = 'dynamic-form-group';
            div.innerHTML = `
                <div class="form-group">
                    <label>Description de l'étape</label>
                    <textarea name="etapes[]" rows="3" required></textarea>
                </div>
            `;
            div.appendChild(createRemoveButton());
            container.appendChild(div);
        }

        function addImageContexte() {
            const container = document.getElementById('images-contexte-container');
            const div = document.createElement('div');
            div.className = 'dynamic-form-group';
            div.innerHTML = `
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="images_contexte[]" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>Titre du contexte</label>
                    <input type="text" name="titres_contexte[]" required>
                </div>
                <div class="form-group">
                    <label>Texte du contexte</label>
                    <textarea name="textes_contexte[]" rows="3" required></textarea>
                </div>
            `;
            div.appendChild(createRemoveButton());
            container.appendChild(div);
        }

        function addOutil() {
            const container = document.getElementById('outils-container');
            const div = document.createElement('div');
            div.className = 'dynamic-form-group';
            div.innerHTML = `
                <div class="form-group">
                    <label>Image de l'outil</label>
                    <input type="file" name="images_outil[]" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>Nom de l'outil</label>
                    <input type="text" name="noms_outil[]" required>
                </div>
            `;
            div.appendChild(createRemoveButton());
            container.appendChild(div);
        }

        function addAvis() {
            const container = document.getElementById('avis-container');
            const div = document.createElement('div');
            div.className = 'dynamic-form-group';
            div.innerHTML = `
                <div class="form-group">
                    <label>Nom de l'auteur</label>
                    <input type="text" name="auteurs_avis[]" required>
                </div>
                <div class="form-group">
                    <label>Texte de l'avis</label>
                    <textarea name="textes_avis[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Note (1-5)</label>
                    <input type="number" name="notes_avis[]" min="1" max="5" required>
                </div>
            `;
            div.appendChild(createRemoveButton());
            container.appendChild(div);
        }
    </script>
</body>
</html>
