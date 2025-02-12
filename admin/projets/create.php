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
        $description = $_POST['description'] ?? '';
        
        // Gestion de l'image
        $image_principale = '';
        if (isset($_FILES['image_principale']) && $_FILES['image_principale']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/images/';
            $filename = basename($_FILES['image_principale']['name']);
            $uploadFile = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $uploadFile)) {
                $image_principale = $filename;
            } else {
                throw new Exception('Erreur lors du téléchargement de l\'image.');
            }
        }
        
        // Insérer le projet dans la base de données
        $query = "INSERT INTO projet_template (titre, texte_contexte, description, image_principale, date_creation) 
                 VALUES (:titre, :texte_contexte, :description, :image_principale, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'titre' => $titre,
            'texte_contexte' => $texte_contexte,
            'description' => $description,
            'image_principale' => $image_principale
        ]);
        
        header('Location: ' . BASE_PATH . '/admin/projets/list.php?success=1');
        exit();
    } catch (Exception $e) {
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
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal">Ajouter un projet</h1>

                <?php if (isset($error)): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" class="admin-form">
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
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required rows="8"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image_principale">Image principale</label>
                        <input type="file" id="image_principale" name="image_principale" accept="image/*" required>
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
</body>
</html>
