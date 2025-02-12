<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../auth.php';

use Config\DataBase;

requireAdmin();

$error = '';
$success = '';
$message = null;

// Récupération du message
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare('SELECT id_message as id, nom, email, message, date_envoi FROM message_contact WHERE id_message = ?');
        $stmt->execute([(int)$_GET['id']]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Erreur lors de la récupération du message : " . $e->getMessage());
        $error = "Impossible de récupérer le message.";
    }
}

// Traitement de l'envoi de la réponse
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
    $to = $_POST['email'];
    $subject = "RE: Message depuis le portfolio";
    $replyMessage = $_POST['reply'];
    
    $headers = "From: contact@erwan-cenac.fr\r\n";
    $headers .= "Reply-To: contact@erwan-cenac.fr\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $replyMessage, $headers)) {
        $success = "Votre réponse a été envoyée avec succès.";
    } else {
        $error = "Une erreur s'est produite lors de l'envoi de la réponse.";
    }
}

$pageTitle = 'Répondre au message';
ob_start();
?>

<div id="container_general">
    <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
    <div class="admin-container">
        <h1 class="texte_dark_mode">Répondre au message</h1>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="message-details">
                <h2 class="texte_dark_mode">Message original</h2>
                <div class="message-info">
                    <p><strong>De :</strong> <?= htmlspecialchars($message['nom']) ?> (<?= htmlspecialchars($message['email']) ?>)</p>
                    <p><strong>Date :</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($message['date_envoi']))) ?></p>
                    <p><strong>Message :</strong></p>
                    <div class="message-content">
                        <?= nl2br(htmlspecialchars($message['message'])) ?>
                    </div>
                </div>

                <form method="post" class="reply-form">
                    <div class="form-group">
                        <label for="email" class="texte_dark_mode">Email du destinataire :</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($message['email']) ?>" readonly class="input_form texte_dark_mode">
                    </div>

                    <div class="form-group">
                        <label for="reply" class="texte_dark_mode">Votre réponse :</label>
                        <textarea id="reply" name="reply" required class="input_form texte_dark_mode" rows="10"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="cta">Envoyer la réponse</button>
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="back-link">Retour à la liste</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <p class="texte_dark_mode">Message non trouvé.</p>
            <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="back-link">Retour à la liste</a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../views/admin/template.php';
?>
