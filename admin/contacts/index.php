<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\DataBase;

requireAdmin();

$pageTitle = 'Liste des messages de contact';
$pdo = DataBase::getConnection();

// Détermine si on affiche la corbeille
$showTrash = isset($_GET['trash']) && $_GET['trash'] === '1';

// Récupération des messages
try {
    $query = 'SELECT id_message as id, nom, email, message, date_envoi 
              FROM message_contact 
              WHERE supprime = :supprime 
              ORDER BY date_envoi DESC';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['supprime' => $showTrash ? 1 : 0]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log("Erreur lors de la récupération des messages : " . $e->getMessage());
    $messages = [];
}

ob_start();
?>

<div class="admin-container">
    <h1 class="texte_dark_mode"><?= $showTrash ? 'Corbeille' : 'Messages de contact' ?></h1>
    
    <div class="admin-actions">
        <?php if ($showTrash): ?>
            <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="admin-btn btn-primary">Voir les messages actifs</a>
        <?php else: ?>
            <a href="<?= BASE_PATH ?>/admin/contacts/index.php?trash=1" class="admin-btn btn-secondary">Voir la corbeille</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($messages)): ?>
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($message['date_envoi']))) ?></td>
                            <td><?= htmlspecialchars($message['nom']) ?></td>
                            <td><?= htmlspecialchars($message['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($message['message'])) ?></td>
                            <td class="actions">
                                <?php if ($showTrash): ?>
                                    <a href="<?= BASE_PATH ?>/admin/contacts/restore.php?id=<?= $message['id'] ?>" 
                                       class="btn-restore" 
                                       title="Restaurer">
                                        ↩️
                                    </a>
                                    <a href="<?= BASE_PATH ?>/admin/contacts/delete.php?id=<?= $message['id'] ?>&permanent=1" 
                                       class="btn-delete" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce message ?')"
                                       title="Supprimer définitivement">
                                        🗑️
                                    </a>
                                <?php else: ?>
                                    <a href="mailto:<?= htmlspecialchars($message['email']) ?>?subject=RE: Message depuis le portfolio" 
                                       class="btn-reply" 
                                       title="Répondre">
                                        ✉️
                                    </a>
                                    <a href="<?= BASE_PATH ?>/admin/contacts/delete.php?id=<?= $message['id'] ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir mettre ce message à la corbeille ?')"
                                       title="Mettre à la corbeille">
                                        🗑️
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="texte_dark_mode">Aucun message n'a été trouvé.</p>
    <?php endif; ?>

    <a href="<?= BASE_PATH ?>/admin/" class="back-link">Retour au tableau de bord</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../views/admin/template.php';
?>
