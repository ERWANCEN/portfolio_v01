<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../autoload.php';

use Config\DataBase;

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['admin']) && is_numeric($_SESSION['admin'])) {
    header('Location: ' . BASE_PATH . '/admin/index.php');
    exit();
}

// Initialisation des variables
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Session expirée, veuillez réessayer.');
        }

        // Validation des entrées
        $nom = trim($_POST['nom'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($nom) || empty($password)) {
            throw new Exception('Identifiant ou mot de passe invalide.');
        }

        // Connexion à la base de données
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare('SELECT id, mot_de_passe FROM administrateur WHERE nom = ?');
        $stmt->execute([$nom]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['mot_de_passe'])) {
            throw new Exception('Identifiant ou mot de passe incorrect.');
        }

        // Connexion réussie
        $_SESSION['admin'] = $admin['id'];
        // Régénérer l'ID de session pour prévenir la fixation de session
        session_regenerate_id(true);
        
        // Redirection vers le dashboard
        header('Location: ' . BASE_PATH . '/admin/index.php');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Génération d'un nouveau token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$pageTitle = 'Administration - Connexion';
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
        <?php include __DIR__ . '/../config/inc/header.inc.php'; ?>

        <main>
            <div class="admin-container">
                <div class="login-form">
                    <h1 class="titre_principal texte_dark_mode">Administration</h1>
                    
                    <?php if ($error): ?>
                        <div class="error-message"><?= escapeHtml($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?= escapeAttr($_SESSION['csrf_token']) ?>">
                        
                        <div class="form-group">
                            <label for="nom">Identifiant</label>
                            <input type="text" id="nom" name="nom" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn-restore">Se connecter</button>
                    </form>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../config/inc/footer.inc.php'; ?>
    </div>

    <script src="<?= BASE_PATH ?>/assets/js/dark_mode.js"></script>
</body>
</html>