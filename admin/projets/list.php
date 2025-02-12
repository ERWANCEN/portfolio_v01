<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\Database;

requireAdmin();

$pageTitle = 'Liste des projets';
$pdo = Database::getConnection();

// Récupération des projets
try {
    $query = 'SELECT id_projet, titre, date_creation, image_principale 
              FROM projet_template 
              ORDER BY date_creation DESC';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log("Erreur lors de la récupération des projets : " . $e->getMessage());
    $projets = [];
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
                <h1 class="titre_principal">Projets</h1>

                <?php if (isset($_GET['success'])): ?>
                    <div class="success-message">
                        Le projet a été supprimé avec succès.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">
                        Une erreur est survenue lors du traitement de votre demande.
                    </div>
                <?php endif; ?>

                <div class="admin-actions">
                    <a href="<?= BASE_PATH ?>/admin/projets/create.php" class="btn-reply">Ajouter un projet</a>
                </div>

                <?php if (empty($projets)): ?>
                    <p class="no-messages">Aucun projet</p>
                <?php else: ?>
                    <div class="messages-list">
                        <?php foreach ($projets as $projet): ?>
                            <div class="message-item">
                                <div class="message-header">
                                    <div class="message-info">
                                        <strong><?= htmlspecialchars($projet['titre']) ?></strong>
                                        <span>Créé le <?= (new DateTime($projet['date_creation']))->format('d/m/Y H:i') ?></span>
                                    </div>
                                    <div class="message-actions">
                                        <a href="<?= BASE_PATH ?>/admin/projets/edit.php?id=<?= $projet['id_projet'] ?>" class="btn-reply">Modifier</a>
                                        <a href="<?= BASE_PATH ?>/admin/projets/delete.php?id=<?= $projet['id_projet'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
                                    </div>
                                </div>
                                <?php if (!empty($projet['image_principale'])): ?>
                                <div class="project-preview">
                                    <img src="<?= BASE_PATH ?>/assets/images/<?= htmlspecialchars($projet['image_principale']) ?>" 
                                         alt="Aperçu de <?= htmlspecialchars($projet['titre']) ?>"
                                         class="preview-image">
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <?php include __DIR__ . '/../../config/inc/footer.inc.php'; ?>
    </div>

    <script src="<?= BASE_PATH ?>/assets/js/dark_mode.js"></script>
</body>
</html>
