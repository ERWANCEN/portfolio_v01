<?php
// Vérifier si la session n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si BASE_PATH n'est pas déjà défini
if (!defined('BASE_PATH')) {
    // Définition du chemin de base de l'application
    $isLocal = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false 
               || strpos($_SERVER['HTTP_HOST'] ?? '', ':8888') !== false;
    define('BASE_PATH', $isLocal ? '/portfolio_v01' : '');
}
?>

<header style="z-index:1003; position:relative;">
    <div class="container_header_tablette_desktop">
        <a href="<?php echo BASE_PATH; ?>/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="<?php echo BASE_PATH; ?>/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="<?php echo BASE_PATH; ?>/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>

        <div class="container_header">
            <div class="header_right_group">
                <nav id="nav_bar">
                    <ul id="nav">
                        <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/index.php">Tableau de bord</a></li>
                        <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/contacts/index.php">Messages</a></li>
                        <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/projets/list.php">Projets</a></li>
                        <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/logout.php">Déconnexion</a></li>
                    </ul>
                </nav>
                <img src="<?php echo BASE_PATH; ?>/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                <div class="mode_jour_nuit_container">
                    <button class="mode_jour_nuit">
                        <div class="mode_jour">
                            <img class="mode_jour_img" src="<?php echo BASE_PATH; ?>/assets/images/soleil_mode_jour.svg" alt="mode jour" loading="lazy">
                        </div>
                        <div class="mode_nuit">
                            <img class="mode_nuit_img" src="<?php echo BASE_PATH; ?>/assets/images/lune_mode_nuit.webp" alt="mode nuit" loading="lazy">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container_header_mobile">
        <div class="container_header_mobile_top">
            <a href="<?php echo BASE_PATH; ?>/" class="logo_container">
                <img class="logo_nav_mode_jour logo_visible" src="<?php echo BASE_PATH; ?>/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
                <img class="logo_nav_mode_nuit" src="<?php echo BASE_PATH; ?>/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
            </a>
            <div class="mode_jour_nuit_container">
                <button class="mode_jour_nuit">
                    <div class="mode_jour">
                        <img class="mode_jour_img" src="<?php echo BASE_PATH; ?>/assets/images/soleil_mode_jour.svg" alt="mode jour" loading="lazy">
                    </div>
                    <div class="mode_nuit">
                        <img class="mode_nuit_img" src="<?php echo BASE_PATH; ?>/assets/images/lune_mode_nuit.webp" alt="mode nuit" loading="lazy">
                    </div>
                </button>
            </div>
            <div class="menu_burger">
                <span class="ligne"></span>
                <span class="ligne"></span>
                <span class="ligne"></span>
            </div>
        </div>

        <nav class="nav_mobile">
            <ul>
                <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/index.php">Tableau de bord</a></li>
                <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/contacts/index.php">Messages</a></li>
                <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/projets/list.php">Projets</a></li>
                <li><a class="texte_dark_mode" href="<?php echo BASE_PATH; ?>/admin/logout.php">Déconnexion</a></li>
            </ul>
            <img src="<?php echo BASE_PATH; ?>/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
        </nav>
    </div>
</header>
