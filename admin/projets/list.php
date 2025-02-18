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
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal texte_dark_mode">Projets</h1>

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
                    <a href="<?= BASE_PATH ?>/admin/projets/create.php" class="btn-restore">Ajouter un projet</a>
                </div>

                <?php if (empty($projets)): ?>
                    <p class="no-messages texte_dark_mode">Aucun projet</p>
                <?php else: ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projets as $projet): ?>
                                    <tr>
                                        <td class="project-image">
                                            <?php if (!empty($projet['image_principale'])): ?>
                                                <img src="<?= BASE_PATH ?>/assets/images/<?= htmlspecialchars($projet['image_principale']) ?>" 
                                                     alt="Aperçu de <?= htmlspecialchars($projet['titre']) ?>"
                                                     class="preview-image">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($projet['titre']) ?></td>
                                        <td><?= (new DateTime($projet['date_creation']))->format('d/m/Y H:i') ?></td>
                                        <td class="actions">
                                            <a href="<?= BASE_PATH ?>/admin/projets/edit.php?id=<?= $projet['id_projet'] ?>" class="btn-restore">Modifier</a>
                                            <a href="<?= BASE_PATH ?>/admin/projets/delete.php?id=<?= $projet['id_projet'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <?php include __DIR__ . '/../../config/inc/footer.inc.php'; ?>
    </div>

    <script src="<?= BASE_PATH ?>/assets/js/dark_mode.js"></script>
</body>
</html>
