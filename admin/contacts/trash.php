<?php
require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../../config/auth.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

use Controllers\ContactController;

$controller = new ContactController();
$controller->listContacts(true); // true pour afficher les messages supprimés

?>

<body>
    <div id="container_general">
        <?php include __DIR__ . '/../../config/inc/admin_header.inc.php'; ?>
    </div>
</body>
