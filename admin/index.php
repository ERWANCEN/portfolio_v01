<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../autoload.php';
use Config\DataBase;

session_start();

// Vérification de la connexion admin
if (!isset($_SESSION['admin']) || !is_numeric($_SESSION['admin'])) {
    header('Location: ' . BASE_PATH . '/admin/login.php');
    exit();
}

try {
    // Vérifier si l'administrateur existe toujours dans la base de données
    $pdo = DataBase::getConnection();
    $stmt = $pdo->prepare('SELECT id FROM administrateur WHERE id = ?');
    $stmt->execute([$_SESSION['admin']]);
    
    if (!$stmt->fetch()) {
        // L'administrateur n'existe plus
        session_destroy();
        header('Location: ' . BASE_PATH . '/admin/login.php');
        exit();
    }
} catch (Exception $e) {
    // En cas d'erreur de base de données, déconnecter par sécurité
    session_destroy();
    header('Location: ' . BASE_PATH . '/admin/login.php');
    exit();
}

// Connexion à la base de données
$pdo = DataBase::getConnection();

// Récupérer les statistiques
try {
    // Compter les messages non supprimés
    $query = "SELECT COUNT(*) as count FROM message_contact WHERE supprime = 0";
    $stmt = $pdo->query($query);
    $messagesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Compter les projets
    $query = "SELECT COUNT(*) as count FROM projet_template";
    $stmt = $pdo->query($query);
    $projetsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (Exception $e) {
    error_log("Erreur lors de la récupération des statistiques : " . $e->getMessage());
    $messagesCount = 0;
    $projetsCount = 0;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/../config/inc/admin_header.inc.php'; ?>
        
        <main>
            <div class="admin-container">
                <h1 class="titre_principal texte_dark_mode">Tableau de bord</h1>
                
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <h3 class="texte_dark_mode">Messages</h3>
                        <p class="stat-number"><?= $messagesCount ?></p>
                        <a href="<?= BASE_PATH ?>/admin/contacts/index.php" class="btn-restore">Voir tous les messages</a>
                    </div>
                    
                    <div class="stat-card">
                        <h3 class="texte_dark_mode">Projets</h3>
                        <p class="stat-number"><?= $projetsCount ?></p>
                        <a href="<?= BASE_PATH ?>/admin/projets/list.php" class="btn-restore">Gérer les projets</a>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../config/inc/footer.inc.php'; ?>
    </div>

    <script src="<?= BASE_PATH ?>/assets/js/dark_mode.js"></script>
</body>
</html>
