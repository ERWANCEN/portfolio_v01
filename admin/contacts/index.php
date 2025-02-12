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
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal"><?= $showTrash ? 'Corbeille' : 'Messages de contact' ?></h1>
                
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
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="btn-back">Retour aux messages</a>
                    <?php else: ?>
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php?trash=1" class="btn-trash">Voir la corbeille</a>
                    <?php endif; ?>
                </div>

                <?php if (empty($messages)): ?>
                    <p class="no-messages">Aucun message <?= $showTrash ? 'dans la corbeille' : '' ?></p>
                <?php else: ?>
                    <div class="messages-list">
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item">
                                <div class="message-header">
                                    <div class="message-info">
                                        <strong><?= htmlspecialchars($message['nom']) ?></strong>
                                        <span><?= htmlspecialchars($message['email']) ?></span>
                                        <span><?= (new DateTime($message['date_envoi']))->format('d/m/Y H:i') ?></span>
                                    </div>
                                    <div class="message-actions">
                                        <?php if ($showTrash): ?>
                                            <a href="<?= BASE_PATH ?>/admin/contacts/restore.php?id=<?= $message['id'] ?>" class="btn-restore">Restaurer</a>
                                            <a href="<?= BASE_PATH ?>/admin/contacts/delete.php?id=<?= $message['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce message ?')">Supprimer définitivement</a>
                                        <?php else: ?>
                                            <a href="mailto:<?= htmlspecialchars($message['email']) ?>?subject=RE: Message depuis le portfolio" class="btn-reply">Répondre</a>
                                            <a href="<?= BASE_PATH ?>/admin/contacts/move-to-trash.php?id=<?= $message['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir mettre ce message à la corbeille ?')">Mettre à la corbeille</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="message-content">
                                    <?= nl2br(htmlspecialchars($message['message'])) ?>
                                </div>
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