<?php
// Chargement automatique des classes et authentification
require_once '../../autoload.php';
require_once '../../config/auth.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

use Controllers\ProjetController;

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=portfolio_crud', 'root', 'root');

// Appel du contrôleur
$controller = new ProjetController($db);
$controller->listProjets();
?>

<a class="liens_tableau_de_bord" href="/portfolio_v01/admin/">Retour au tableau de bord</a>

<?php include __DIR__ . '/../../config/inc/admin_footer.inc.php'; ?>
