<?php
require_once __DIR__ . '/../auth.php';
?>
<nav class="nav_tablette_desktop nav_admin">
    <a href="/portfolio_v01/admin/index.php">Tableau de bord</a>
    <a href="/portfolio_v01/admin/contacts/index.php">Messages</a>
    <a href="/portfolio_v01/admin/projets/list.php">Projets</a>
    <?php if (isLoggedIn()): ?>
        <a href="/portfolio_v01/admin/logout.php" class="deconnexion">Déconnexion</a>
    <?php endif; ?>
</nav>
