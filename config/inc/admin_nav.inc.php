<?php
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/../paths.php';
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="admin-header">
    <nav class="admin-nav">
        <ul class="admin-menu">
            <li>
                <a href="<?= BASE_PATH ?>/admin/dashboard.php" class="<?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
                    Tableau de bord
                </a>
            </li>
            <li>
                <a href="<?= BASE_PATH ?>/admin/messages/list.php" class="<?= strpos($current_page, 'messages') !== false ? 'active' : '' ?>">
                    Messages
                </a>
            </li>
            <li>
                <a href="<?= BASE_PATH ?>/admin/projets/list.php" class="<?= strpos($current_page, 'projets') !== false ? 'active' : '' ?>">
                    Projets
                </a>
            </li>
            <li>
                <a href="<?= BASE_PATH ?>/admin/logout.php">
                    Déconnexion
                </a>
            </li>
        </ul>
    </nav>
</header>
