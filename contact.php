<?php
// Inclure le fichier de configuration
require_once __DIR__ . '/config/config.php';

include BASE_PATH . '/config/inc/head.inc.php';

// Inclure l'autoload pour charger les classes automatiquement
require_once __DIR__ . '/autoload.php';
use Config\Database;
use Models\Contact;

// Démarrer la session pour le token CSRF
// session_start();

// Génération d'un token CSRF s'il n'existe pas
// if (empty($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }

// Initialisation des variables
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérification du champ honeypot (doit être vide)
        if (!empty($_POST['honeypot'])) {
            throw new Exception('Requête suspecte détectée.');
        }

        // Vérification du token CSRF
        // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        //     throw new Exception('Requête non valide. Token CSRF invalide.');
        // }

        // Récupération des données avec nettoyage
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validation des champs obligatoires
        if (empty($nom) || empty($email) || empty($message)) {
            throw new Exception('Tous les champs sont obligatoires.');
        }

        // Vérification du format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Veuillez entrer une adresse email valide.');
        }

        // Limitation de la taille des champs
        if (strlen($nom) > 100 || strlen($email) > 150 || strlen($message) > 1000) {
            throw new Exception('Un des champs dépasse la longueur maximale autorisée.');
        }

        // Enregistrement du message en BDD
        $db = Database::getConnection();
        $contact = new Contact(null, $nom, $email, $message);
        $contact->save($db);

        // Message de confirmation
        $successMessage = 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        $errorMessage = 'Erreur lors de l\'envoi du message : ' . htmlspecialchars($e->getMessage());
    }
}
?>

<title>Portfolio - Erwan CÉNAC</title>
</head>
<body>
<div id="container">
    <?php include BASE_PATH . '/config/inc/header.inc.php'; ?>

    <!-- Formulaire de contact -->
    <form id="formulaire_de_contact" method="post" action="contact.php">
        <h1 id="titre_contact" class="titre_principal texte_dark_mode">Contact</h1>
        <div id="message_formulaire">
            <!-- Affichage des messages de succès ou d'erreur -->
            <?php if ($successMessage): ?>
                <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
            <?php elseif ($errorMessage): ?>
                <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>
        </div>

        <!-- Champ honeypot caché -->
        <div style="display: none;">
            <label for="honeypot">Ne remplissez pas ce champ</label>
            <input type="text" name="honeypot" id="honeypot">
        </div>



        <div id="champ_nom">
            <label for="nom" class="texte_dark_mode">Comment vous appelez-vous ?</label>
            <input class="input_form texte_dark_mode" type="text" name="nom" id="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required maxlength="100">
        </div>

        <div id="champ_email">
            <label for="email" class="texte_dark_mode">Quel est votre email ?</label>
            <input class="input_form texte_dark_mode" type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required maxlength="150">
        </div>

        <div id="champ_message">
            <label for="message" class="texte_dark_mode">Quel est votre message ?</label>
            <textarea class="input_form texte_dark_mode" name="message" id="message" required maxlength="1000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>

        <button class="cta" type="submit">Envoyer</button>
    </form>
</div>

<?php include BASE_PATH . '/config/inc/footer.inc.php'; ?>
