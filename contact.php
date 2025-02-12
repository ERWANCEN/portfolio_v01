<?php
// Désactiver l'affichage des erreurs en production
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

session_start();

require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\DataBase;
use Models\Contact;

// Génération d'un token CSRF s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialisation des variables
$successMessage = '';
$errorMessage = '';
$formData = [
    'nom' => '',
    'email' => '',
    'message' => ''
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Session expirée, veuillez réessayer.');
        }

        // 2. Protection anti-spam
        if (isSpamRequest()) {
            throw new Exception('Veuillez patienter quelques secondes avant de renvoyer un message.');
        }

        // 3. Validation et nettoyage des entrées
        $nom = validateString($_POST['nom'] ?? '', 2, 100);
        $email = validateEmail($_POST['email'] ?? '');
        $message = validateMessage($_POST['message'] ?? '', 3000);

        if (!$nom) {
            throw new Exception('Le nom est invalide (2 à 100 caractères).');
        }
        if (!$email) {
            throw new Exception('L\'adresse email est invalide.');
        }
        if (!$message) {
            throw new Exception('Le message est invalide (max 3000 caractères).');
        }

        // 4. Connexion à la base de données
        $pdo = DataBase::getConnection();
        
        // 5. Sauvegarde du message
        $contact = new Contact($pdo);
        $contact->nom = $nom;
        $contact->email = $email;
        $contact->message = $message;
        
        if ($contact->save()) {
            $successMessage = "Message envoyé avec succès !";
            // Réinitialisation du token CSRF et des données du formulaire
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $formData = ['nom' => '', 'email' => '', 'message' => ''];
        } else {
            throw new Exception("Une erreur est survenue lors de l'envoi du message.");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        // Conserver les données du formulaire en cas d'erreur
        $formData = [
            'nom' => $_POST['nom'] ?? '',
            'email' => $_POST['email'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];
    }
}

// Protection contre le clickjacking
header('X-Frame-Options: DENY');
// Protection XSS
header('X-XSS-Protection: 1; mode=block');
// Protection contre le MIME-sniffing
header('X-Content-Type-Options: nosniff');
// Politique de sécurité du contenu
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");

include __DIR__ . '/config/inc/head.inc.php'; ?>
<title>Contact - Erwan CÉNAC</title>
</head>
<body>
    <div id="container">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>
        
        <main>
            <section id="container_contact">
                <h1 id="titre_contact" class="titre_principal texte_dark_mode">Contact</h1>
                
                <form class="formulaire_de_contact" method="POST" action="<?= escapeAttr($_SERVER['PHP_SELF']) ?>">
                    <?php if ($successMessage): ?>
                        <div class="success-message"><?= escapeHtml($successMessage) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($errorMessage): ?>
                        <div class="error-message"><?= escapeHtml($errorMessage) ?></div>
                    <?php endif; ?>

                    <input type="hidden" name="csrf_token" value="<?= escapeAttr($_SESSION['csrf_token']) ?>">
                    
                    <div class="form-group">
                        <label for="nom" class="texte_dark_mode">Nom</label>
                        <input type="text" id="nom" name="nom" required 
                               class="input_form texte_dark_mode" 
                               maxlength="100"
                               value="<?= escapeAttr($formData['nom']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="texte_dark_mode">Email</label>
                        <input type="email" id="email" name="email" required 
                               class="input_form texte_dark_mode"
                               maxlength="255" 
                               value="<?= escapeAttr($formData['email']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="texte_dark_mode">Message</label>
                        <textarea id="message" name="message" required 
                                  class="input_form texte_dark_mode"
                                  maxlength="3000"><?= escapeHtml($formData['message']) ?></textarea>
                    </div>
                    
                    <button type="submit" class="cta">Envoyer</button>
                </form>
            </section>
        </main>
        
        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
</body>
</html>
