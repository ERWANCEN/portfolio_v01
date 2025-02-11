<?php
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/../paths.php';
}
?>
<nav class="nav_tablette_desktop nav_admin">
    <a href="<?= BASE_PATH ?>/admin/index.php">Tableau de bord</a>
    <a href="<?= BASE_PATH ?>/admin/contacts/index.php">Messages</a>
    <a href="<?= BASE_PATH ?>/admin/projets/list.php">Projets</a>
    <a href="<?= BASE_PATH ?>/admin/logout.php" class="deconnexion">Déconnexion</a>
</nav>
