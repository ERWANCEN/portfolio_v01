<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Débogage
var_dump($_SESSION);

// Si déjà connecté, rediriger vers le tableau de bord
if (isset($_SESSION['admin']) && is_numeric($_SESSION['admin'])) {
    // Vérifier si l'administrateur existe toujours dans la base de données
    try {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id FROM administrateur WHERE id = :id');
        $stmt->execute(['id' => $_SESSION['admin']]);
        if (!$stmt->fetch()) {
            // L'administrateur n'existe plus, détruire la session
            session_destroy();
            session_start();
        } else {
            header('Location: /portfolio_v01/admin/index.php');
            exit();
        }
    } catch (Exception $e) {
        // En cas d'erreur, détruire la session par sécurité
        session_destroy();
        session_start();
    }
}

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/auth.php';

use Config\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $db = Database::getConnection();

    // Vérification du nom d'utilisateur
    $stmt = $db->prepare('SELECT * FROM administrateur WHERE nom = :nom');
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        if (password_verify($password, $admin['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['admin'] = $admin['id'];
            header('Location: /portfolio_v01/admin/index.php');
            exit;
        } else {
            $error = 'Mot de passe incorrect.';
        }
    } else {
        $error = 'Nom d\'utilisateur non trouvé.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/portfolio_v01/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Connexion Administrateur</title>
</head>
<body>
    <?php include __DIR__ . '/../config/inc/header.inc.php'; ?>


        <form class="formulaire_de_contact" method="post" action="/portfolio_v01/admin/login.php">
            <h1 id="titre_login" class="titre_principal texte_dark_mode">Connexion</h1>
            <?php if (isset($error)): ?>
                <p id="message_erreur" class="texte"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="champ_nom">
                <label class="texte texte_dark_mode">Nom d'utilisateur</label>
                <input class="input_form texte_dark_mode" type="text" name="nom" required>
            </div>

            <div class="champ_password">
                <label class="texte texte_dark_mode">Mot de passe</label>
                <input class="input_form texte_dark_mode" type="password" name="password" required>
            </div>

            <button class="cta" type="submit">Se connecter</button>
        </form>


<?php include __DIR__ . '/../config/inc/footer.inc.php'; ?>
<script src="/portfolio_v01/assets/js/script.js"></script>
