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

        // Mise à jour des étapes
        if (isset($_POST['etapes']) && is_array($_POST['etapes'])) {
            foreach ($_POST['etapes'] as $id_etape => $etape) {
                if (!empty($etape['titre']) && !empty($etape['description'])) {
                    if ($id_etape === 'new') {
                        // Nouvelle étape
                        $stmt = $pdo->prepare('INSERT INTO etapes_projet (id_projet, description) VALUES (?, ?)');
                        $stmt->execute([$id_projet, $etape['description']]);
                    } else {
                        // Mise à jour d'une étape existante
                        $stmt = $pdo->prepare('UPDATE etapes_projet SET description = ? WHERE id_etape = ? AND id_projet = ?');
                        $stmt->execute([$etape['description'], $id_etape, $id_projet]);
                    }
                }
            }
        }

        // Mise à jour des outils
        if (isset($_POST['outils']) && is_array($_POST['outils'])) {
            foreach ($_POST['outils'] as $id_outil => $outil) {
                if (!empty($outil['nom'])) {
                    if ($id_outil === 'new') {
                        // Nouvel outil
                        $stmt = $pdo->prepare('INSERT INTO outils_utilises (id_projet, nom_outil, image_outil) VALUES (?, ?, ?)');
                        $stmt->execute([$id_projet, $outil['nom'], $outil['image'] ?? null]);
                    } else {
                        // Mise à jour d'un outil existant
                        $stmt = $pdo->prepare('UPDATE outils_utilises SET nom_outil = ?, image_outil = ? WHERE id_outil = ? AND id_projet = ?');
                        $stmt->execute([$outil['nom'], $outil['image'] ?? null, $id_outil, $id_projet]);
                    }
                }
            }
        }

        // Gestion des images
        if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
            $uploadDir = __DIR__ . '/../../assets/images/';
            
            foreach ($_FILES['images']['name'] as $key => $name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$key];
                    $fileName = uniqid() . '_' . securePath($name);
                    $titre = $_POST['images_titre'][$key] ?? '';
                    $texte = $_POST['images_texte'][$key] ?? '';

                    if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                        $stmt = $pdo->prepare('INSERT INTO images_contexte (id_projet, image, titre_contexte, texte_contexte) VALUES (?, ?, ?, ?)');
                        $stmt->execute([$id_projet, $fileName, $titre, $texte]);
                    }
                }
            }
        }

        // Suppression des éléments marqués
        if (!empty($_POST['delete'])) {
            foreach ($_POST['delete'] as $type => $ids) {
                foreach ($ids as $id) {
                    switch ($type) {
                        case 'etapes':
                            $stmt = $pdo->prepare('DELETE FROM etapes_projet WHERE id_etape = ? AND id_projet = ?');
                            break;
                        case 'outils':
                            $stmt = $pdo->prepare('DELETE FROM outils_utilises WHERE id_outil = ? AND id_projet = ?');
                            break;
                        case 'images':
                            // Récupérer le nom du fichier avant la suppression
                            $stmt = $pdo->prepare('SELECT image FROM images_contexte WHERE id_image = ? AND id_projet = ?');
                            $stmt->execute([$id, $id_projet]);
                            if ($image = $stmt->fetch()) {
                                unlink($uploadDir . $image['image']);
                            }
                            $stmt = $pdo->prepare('DELETE FROM images_contexte WHERE id_image = ? AND id_projet = ?');
                            break;
                    }
                    $stmt->execute([$id, $id_projet]);
                }
            }
        }

        $pdo->commit();
        $success = 'Projet mis à jour avec succès';
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

include __DIR__ . '/../../config/inc/head.inc.php';
?>
<title>Modifier le projet - Administration</title>
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>

        <main>
            <div class="admin-container">
                <h1 class="titre_principal texte_dark_mode">Modifier le projet</h1>
                
                <?php if ($error): ?>
                    <div class="error-message"><?= escapeHtml($error) ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message"><?= escapeHtml($success) ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="edit-form" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= escapeAttr($_SESSION['csrf_token']) ?>">

                    <!-- Informations du projet -->
                    <section class="form-section">
                        <h2 class="texte_dark_mode">Informations du projet</h2>
                        
                        <div class="form-group">
                            <label for="titre" class="texte_dark_mode">Titre</label>
                            <input type="text" id="titre" name="titre" required 
                                   value="<?= escapeAttr($projet['titre']) ?>"
                                   class="input_form texte_dark_mode">
                        </div>

                        <div class="form-group">
                            <label for="texte_contexte" class="texte_dark_mode">Texte de contexte</label>
                            <textarea id="texte_contexte" name="texte_contexte" required 
                                      class="input_form texte_dark_mode"><?= escapeHtml($projet['texte_contexte']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="texte_details" class="texte_dark_mode">Texte de détails</label>
                            <textarea id="texte_details" name="texte_details" required 
                                      class="input_form texte_dark_mode"><?= escapeHtml($projet['texte_details']) ?></textarea>
                        </div>
                    </section>

                    <!-- Étapes -->
                    <section class="form-section">
                        <h2 class="texte_dark_mode">Étapes du projet</h2>
                        <div id="etapes-container">
                            <?php foreach ($etapes as $etape): ?>
                                <div class="etape-item">
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Titre de l'étape</label>
                                        <input type="text" name="etapes[<?= $etape['id_etape'] ?>][titre]" 
                                               value="<?= escapeAttr($etape['titre']) ?>"
                                               class="input_form texte_dark_mode">
                                    </div>
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Description de l'étape</label>
                                        <textarea name="etapes[<?= $etape['id_etape'] ?>][description]" 
                                                  class="input_form texte_dark_mode"><?= escapeHtml($etape['description']) ?></textarea>
                                    </div>
                                    <div class="delete-checkbox">
                                        <label>
                                            <input type="checkbox" name="delete[etapes][]" value="<?= $etape['id_etape'] ?>">
                                            Supprimer cette étape
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Template pour nouvelle étape -->
                            <div class="etape-item new-item">
                                <div class="form-group">
                                    <label class="texte_dark_mode">Nouvelle étape</label>
                                    <input type="text" name="etapes[new][titre]" placeholder="Titre" 
                                           class="input_form texte_dark_mode">
                                    <textarea name="etapes[new][description]" placeholder="Description" 
                                              class="input_form texte_dark_mode"></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Outils -->
                    <section class="form-section">
                        <h2 class="texte_dark_mode">Outils utilisés</h2>
                        <div id="outils-container">
                            <?php foreach ($outils as $outil): ?>
                                <div class="outil-item">
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Nom de l'outil</label>
                                        <input type="text" name="outils[<?= $outil['id_outil'] ?>][nom]" 
                                               value="<?= escapeAttr($outil['nom_outil']) ?>"
                                               class="input_form texte_dark_mode">
                                    </div>
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Image de l'outil</label>
                                        <div class="file-upload">
                                            <button type="button" class="file-upload-button">Choisir un fichier</button>
                                            <span class="file-upload-label">Aucun fichier choisi</span>
                                            <input type="file" name="outils[<?= $outil['id_outil'] ?>][image]" 
                                                   class="input_form texte_dark_mode">
                                        </div>
                                    </div>
                                    <div class="delete-checkbox">
                                        <label>
                                            <input type="checkbox" name="delete[outils][]" value="<?= $outil['id_outil'] ?>">
                                            Supprimer cet outil
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Template pour nouvel outil -->
                            <div class="outil-item new-item">
                                <div class="form-group">
                                    <label class="texte_dark_mode">Nouvel outil</label>
                                    <input type="text" name="outils[new][nom]" placeholder="Nom de l'outil" 
                                           class="input_form texte_dark_mode">
                                    <div class="file-upload">
                                        <button type="button" class="file-upload-button">Choisir un fichier</button>
                                        <span class="file-upload-label">Aucun fichier choisi</span>
                                        <input type="file" name="outils[new][image]" 
                                               class="input_form texte_dark_mode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Images -->
                    <section class="form-section">
                        <h2 class="texte_dark_mode">Images du projet</h2>
                        <div id="images-container">
                            <?php foreach ($images as $image): ?>
                                <div class="image-item">
                                    <img src="<?= BASE_PATH ?>/assets/images/<?= escapeAttr($image['image']) ?>" 
                                         alt="<?= escapeAttr($image['titre_contexte']) ?>" 
                                         class="preview-image">
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Titre de l'image</label>
                                        <input type="text" name="images[<?= $image['id_image'] ?>][titre]" 
                                               value="<?= escapeAttr($image['titre_contexte']) ?>"
                                               class="input_form texte_dark_mode">
                                    </div>
                                    <div class="form-group">
                                        <label class="texte_dark_mode">Texte de l'image</label>
                                        <textarea name="images[<?= $image['id_image'] ?>][texte]" 
                                                  class="input_form texte_dark_mode"><?= escapeHtml($image['texte_contexte']) ?></textarea>
                                    </div>
                                    <div class="delete-checkbox">
                                        <label>
                                            <input type="checkbox" name="delete[images][]" value="<?= $image['id_image'] ?>">
                                            Supprimer cette image
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- Upload de nouvelles images -->
                            <div class="image-item new-item">
                                <div class="form-group">
                                    <label class="texte_dark_mode">Ajouter des images</label>
                                    <div class="file-upload">
                                        <button type="button" class="file-upload-button">Choisir des fichiers</button>
                                        <span class="file-upload-label">Aucun fichier choisi</span>
                                        <input type="file" name="images[]" multiple accept="image/*" 
                                               class="input_form texte_dark_mode">
                                    </div>
                                    <input type="text" name="images_titre[]" placeholder="Titre de l'image" 
                                           class="input_form texte_dark_mode">
                                    <textarea name="images_texte[]" placeholder="Texte de l'image" 
                                              class="input_form texte_dark_mode"></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="form-actions">
                        <button type="submit" class="cta">Enregistrer les modifications</button>
                        <a href="<?= BASE_PATH ?>/admin/projets/list.php" class="cta">Retour à la liste</a>
                    </div>
                </form>
            </div>
        </main>

        <?php include __DIR__ . '/../../config/inc/footer.inc.php'; ?>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gérer tous les inputs de type file
    document.querySelectorAll('.file-upload input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            const label = this.parentElement.querySelector('.file-upload-label');
            if (this.multiple) {
                label.textContent = this.files.length > 1 
                    ? `${this.files.length} fichiers sélectionnés` 
                    : this.files[0]?.name || 'Aucun fichier choisi';
            } else {
                label.textContent = this.files[0]?.name || 'Aucun fichier choisi';
            }
        });

        // Cliquer sur le bouton déclenche l'input file
        const button = input.parentElement.querySelector('.file-upload-button');
        button.addEventListener('click', function() {
            input.click();
        });
    });
});
</script>
</html>
