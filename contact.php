<?php
session_start();

require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\DataBase;
use Models\Contact;

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logging pour le débogage
error_log("Démarrage du script contact.php");

// Génération d'un token CSRF s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialisation des variables
$successMessage = '';
$errorMessage = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Formulaire soumis. POST data: " . print_r($_POST, true));
    
    try {
        $pdo = DataBase::getConnection();
        error_log("Connexion à la base de données établie");
        
        // Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Token CSRF invalide');
        }

        $contact = new Contact($pdo);
        $contact->nom = $_POST['nom'] ?? '';
        $contact->email = $_POST['email'] ?? '';
        $contact->message = $_POST['message'] ?? '';
        
        error_log("Tentative de sauvegarde du message");
        if ($contact->save()) {
            $successMessage = "Message envoyé avec succès !";
            // Réinitialisation du token CSRF après un envoi réussi
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            error_log("Message sauvegardé avec succès");
        } else {
            $errorMessage = "Une erreur est survenue lors de l'envoi du message.";
            error_log("Échec de la sauvegarde du message");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        error_log("Erreur contact : " . $e->getMessage() . "\n" . $e->getTraceAsString());
    }
}

    include __DIR__ . '/config/inc/head.inc.php'; ?>
    <title>Contact - Erwan CÉNAC</title>
</head>
<body>
    <div id="container">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>
        
        <main>
            <section id="container_contact">
                <h1 id="titre_contact" class="titre_principal texte_dark_mode">Contact</h1>
                
                
                <form class="formulaire_de_contact" method="POST" action="">
                    <?php if ($successMessage): ?>
                        <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($errorMessage): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    
                    <div class="form-group">
                        <label for="nom" class="texte_dark_mode">Nom</label>
                        <input type="text" id="nom" name="nom" required class="input_form texte_dark_mode" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="texte_dark_mode">Email</label>
                        <input type="email" id="email" name="email" required class="input_form texte_dark_mode" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="texte_dark_mode">Message</label>
                        <textarea id="message" name="message" required class="input_form texte_dark_mode"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" class="cta">Envoyer</button>
                </form>
            </section>
        </main>
        
        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
</body>
</html>
