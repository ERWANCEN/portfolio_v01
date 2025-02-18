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
                <h1 class="titre_principal texte_dark_mode"><?= $showTrash ? 'Corbeille' : 'Messages de contact' ?></h1>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="success-message">
                        <?php if ($showTrash): ?>
                            Le message a été supprimé définitivement avec succès.
                        <?php else: ?>
                            Le message a été déplacé vers la corbeille.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">
                        Une erreur est survenue lors du traitement de votre demande.
                    </div>
                <?php endif; ?>

                <div class="admin-actions">
                    <?php if ($showTrash): ?>
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="btn-restore">Retour aux messages</a>
                    <?php else: ?>
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php?trash=1" class="btn-delete">Voir la corbeille</a>
                    <?php endif; ?>
                </div>

                <?php if (empty($messages)): ?>
                    <p class="no-messages texte_dark_mode">Aucun message <?= $showTrash ? 'dans la corbeille' : '' ?></p>
                <?php else: ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date d'envoi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($message['nom']) ?></td>
                                        <td><?= htmlspecialchars($message['email']) ?></td>
                                        <td class="message-content"><?= htmlspecialchars($message['message']) ?></td>
                                        <td><?= (new DateTime($message['date_envoi']))->format('d/m/Y H:i') ?></td>
                                        <td class="actions">
                                            <?php if ($showTrash): ?>
                                                <a href="<?= BASE_PATH ?>/admin/contacts/restore.php?id=<?= $message['id'] ?>" class="btn-restore">Restaurer</a>
                                                <a href="<?= BASE_PATH ?>/admin/contacts/delete.php?id=<?= $message['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce message ?')">Supprimer définitivement</a>
                                            <?php else: ?>
                                                <a href="mailto:<?= htmlspecialchars($message['email']) ?>" class="btn-restore">Répondre</a>
                                                <a href="<?= BASE_PATH ?>/admin/contacts/delete.php?id=<?= $message['id'] ?>" class="btn-delete">Supprimer</a>
                                            <?php endif; ?>
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