<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../config/functions.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\Database;

requireAdmin();

// Initialisation
$error = '';
$success = '';
$projet = null;

// Vérification de l'ID du projet
$id_projet = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);
if (!$id_projet) {
    header('Location: ' . BASE_PATH . '/admin/projets/list.php');
    exit();
}

try {
    $pdo = Database::getConnection();
    
    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Session expirée, veuillez réessayer.');
        }

        // Validation et nettoyage des données du projet
        $titre = validateString($_POST['titre'] ?? '', 1, 255) ?: throw new Exception('Le titre est invalide');
        $texte_contexte = validateString($_POST['texte_contexte'] ?? '', 1, 65535) ?: throw new Exception('Le texte de contexte est invalide');
        $texte_details = validateString($_POST['texte_details'] ?? '', 1, 65535) ?: throw new Exception('Le texte de détails est invalide');

        // Début de la transaction
        $pdo->beginTransaction();

        // Mise à jour du projet
        $stmt = $pdo->prepare('UPDATE projet_template SET titre = ?, texte_contexte = ?, texte_details = ? WHERE id_projet = ?');
        $stmt->execute([$titre, $texte_contexte, $texte_details, $id_projet]);

        // Gestion de l'image principale si une nouvelle est uploadée
        if (isset($_FILES['image_principale']) && $_FILES['image_principale']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/images/';
            $filename = basename($_FILES['image_principale']['name']);
            $uploadFile = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $uploadFile)) {
                $stmt = $pdo->prepare('UPDATE projet_template SET image_principale = ? WHERE id_projet = ?');
                $stmt->execute([$filename, $id_projet]);
            }
        }

        // Mise à jour des étapes
        if (isset($_POST['etapes']) && is_array($_POST['etapes'])) {
            // Supprimer les anciennes étapes
            $stmt = $pdo->prepare('DELETE FROM etapes_projet WHERE id_projet = ?');
            $stmt->execute([$id_projet]);
            
            // Ajouter les nouvelles étapes
            $queryEtape = "INSERT INTO etapes_projet (id_projet, description) VALUES (:id_projet, :description)";
            $stmtEtape = $pdo->prepare($queryEtape);
            
            foreach ($_POST['etapes'] as $description) {
                if (!empty(trim($description))) {
                    $stmtEtape->execute([
                        'id_projet' => $id_projet,
                        'description' => $description
                    ]);
                }
            }
        }

        // Mise à jour des images de contexte
        if (isset($_FILES['images_contexte']) && isset($_POST['titres_contexte']) && isset($_POST['textes_contexte'])) {
            // Supprimer les anciennes images de contexte
            $stmt = $pdo->prepare('DELETE FROM images_contexte WHERE id_projet = ?');
            $stmt->execute([$id_projet]);
            
            $queryImage = "INSERT INTO images_contexte (id_projet, image, titre_contexte, texte_contexte) 
                          VALUES (:id_projet, :image, :titre_contexte, :texte_contexte)";
            $stmtImage = $pdo->prepare($queryImage);
            
            foreach ($_FILES['images_contexte']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images_contexte']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['images_contexte']['name'][$key]);
                    $uploadFile = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $stmtImage->execute([
                            'id_projet' => $id_projet,
                            'image' => $filename,
                            'titre_contexte' => $_POST['titres_contexte'][$key],
                            'texte_contexte' => $_POST['textes_contexte'][$key]
                        ]);
                    }
                }
            }
        }

        // Mise à jour des outils
        if (isset($_FILES['images_outil']) && isset($_POST['noms_outil'])) {
            // Supprimer les anciens outils
            $stmt = $pdo->prepare('DELETE FROM outils_utilises WHERE id_projet = ?');
            $stmt->execute([$id_projet]);
            
            $queryOutil = "INSERT INTO outils_utilises (id_projet, image_outil, nom_outil) 
                          VALUES (:id_projet, :image_outil, :nom_outil)";
            $stmtOutil = $pdo->prepare($queryOutil);
            
            foreach ($_FILES['images_outil']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images_outil']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['images_outil']['name'][$key]);
                    $uploadFile = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $stmtOutil->execute([
                            'id_projet' => $id_projet,
                            'image_outil' => $filename,
                            'nom_outil' => $_POST['noms_outil'][$key]
                        ]);
                    }
                }
            }
        }

        $pdo->commit();
        header('Location: ' . BASE_PATH . '/admin/projets/list.php?success=1&edited=1');
        exit();
    }

    // Récupération des données du projet et de ses éléments
    $stmt = $pdo->prepare('SELECT * FROM projet_template WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM etapes_projet WHERE id_projet = ? ORDER BY id_etape');
    $stmt->execute([$id_projet]);
    $etapes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM outils_utilises WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $outils = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM images_contexte WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$projet) {
        header('Location: ' . BASE_PATH . '/admin/projets/list.php');
        exit();
    }

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $error = $e->getMessage();
}

// Génération d'un nouveau token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le projet - Administration</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
    <style>
        .dynamic-form-group { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .dynamic-form-group .form-group { margin-bottom: 10px; }
        .remove-item { cursor: pointer; }
        .add-item { margin-top: 10px; }
        .current-image { max-width: 200px; margin: 10px 0; }
    </style>
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal texte_dark_mode">Modifier le projet</h1>

                <?php if (!empty($error)): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" class="admin-form">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <!-- Informations principales -->
                    <div class="form-section">
                        <h2>Informations principales</h2>
                        <div class="form-group">
                            <label for="titre">Titre du projet</label>
                            <input type="text" id="titre" name="titre" required 
                                   value="<?= htmlspecialchars($projet['titre']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="texte_contexte">Contexte</label>
                            <textarea id="texte_contexte" name="texte_contexte" required rows="4"><?= htmlspecialchars($projet['texte_contexte']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="texte_details">Détails</label>
                            <textarea id="texte_details" name="texte_details" required rows="8"><?= htmlspecialchars($projet['texte_details']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <?php if (!empty($projet['image_principale'])): ?>
                                <p>Image principale actuelle :</p>
                                <img src="<?= BASE_PATH ?>/assets/images/<?= htmlspecialchars($projet['image_principale']) ?>" 
                                     alt="Image principale actuelle" class="current-image">
                            <?php endif; ?>
                            <label for="image_principale">Nouvelle image principale (laisser vide pour conserver l'actuelle)</label>
                            <input type="file" id="image_principale" name="image_principale" accept="image/*">
                        </div>
                    </div>

                    <!-- Étapes du projet -->
                    <div class="form-section">
                        <h2>Étapes du projet</h2>
                        <div id="etapes-container">
                            <?php foreach ($etapes as $etape): ?>
                                <div class="dynamic-form-group">
                                    <div class="form-group">
                                        <label>Description de l'étape</label>
                                        <textarea name="etapes[]" rows="3" required><?= htmlspecialchars($etape['description']) ?></textarea>
                                    </div>
                                    <button type="button" class="btn-delete remove-item" onclick="this.closest('.dynamic-form-group').remove()">Supprimer</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addEtape()">Ajouter une étape</button>
                    </div>

                    <!-- Images de contexte -->
                    <div class="form-section">
                        <h2>Images de contexte</h2>
                        <div id="images-contexte-container">
                            <?php foreach ($images as $image): ?>
                                <div class="dynamic-form-group">
                                    <img src="<?= BASE_PATH ?>/assets/images/<?= htmlspecialchars($image['image']) ?>" 
                                         alt="Image de contexte" class="current-image">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="images_contexte[]" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label>Titre du contexte</label>
                                        <input type="text" name="titres_contexte[]" required value="<?= htmlspecialchars($image['titre_contexte']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Texte du contexte</label>
                                        <textarea name="textes_contexte[]" rows="3" required><?= htmlspecialchars($image['texte_contexte']) ?></textarea>
                                    </div>
                                    <button type="button" class="btn-delete remove-item" onclick="this.closest('.dynamic-form-group').remove()">Supprimer</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addImageContexte()">Ajouter une image de contexte</button>
                    </div>

                    <!-- Outils utilisés -->
                    <div class="form-section">
                        <h2>Outils utilisés</h2>
                        <div id="outils-container">
                            <?php foreach ($outils as $outil): ?>
                                <div class="dynamic-form-group">
                                    <?php if (!empty($outil['image_outil'])): ?>
                                        <img src="<?= BASE_PATH ?>/assets/images/<?= htmlspecialchars($outil['image_outil']) ?>" 
                                             alt="Image de l'outil" class="current-image">
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label>Image de l'outil</label>
                                        <input type="file" name="images_outil[]" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label>Nom de l'outil</label>
                                        <input type="text" name="noms_outil[]" required value="<?= htmlspecialchars($outil['nom_outil']) ?>">
                                    </div>
                                    <button type="button" class="btn-delete remove-item" onclick="this.closest('.dynamic-form-group').remove()">Supprimer</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn-restore add-item" onclick="addOutil()">Ajouter un outil</button>
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
    </script>
</body>
</html>
