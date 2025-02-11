<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\Database;

requireAdmin();

$pageTitle = 'Liste des projets';
$pdo = Database::getConnection();

// Récupération des projets
try {
    $stmt = $pdo->query('SELECT * FROM projet_template ORDER BY id_projet DESC');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $projets = [];
}

ob_start();
?>

<div class="admin-container">
    <h1 class="texte_dark_mode">Liste des projets</h1>
    <a href="<?= BASE_PATH ?>/admin/projets/create.php" class="cta">Ajouter un projet</a>

    <?php if (!empty($projets)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet): ?>
                    <tr>
                        <td><?= htmlspecialchars($projet['id_projet']) ?></td>
                        <td><?= htmlspecialchars($projet['titre']) ?></td>
                        <td>
                            <a href="<?= BASE_PATH ?>/admin/projets/edit.php?id=<?= $projet['id_projet'] ?>" class="btn-edit">Modifier</a>
                            <a href="<?= BASE_PATH ?>/admin/projets/delete.php?id=<?= $projet['id_projet'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="texte_dark_mode">Aucun projet n'a été trouvé.</p>
    <?php endif; ?>

    <a href="<?= BASE_PATH ?>/admin/" class="back-link">Retour au tableau de bord</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../views/admin/template.php';
?>
