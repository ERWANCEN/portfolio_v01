<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/Database.php';

// Vérification stricte de la session
if (!isLoggedIn()) {
    session_destroy();
    header('Location: /portfolio_v01/admin/login.php');
    exit();
}

include __DIR__ . '/../config/inc/head.inc.php';
?>
    <title>Tableau de bord - Portfolio</title>
</head>
<body id="body_tableau_de_bord">
    <header style="z-index:1003; position:relative;">
    <div class="container_header_tablette_desktop">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>
        <div class="container_header">
            <div class="header_right_group">
                <?php include __DIR__ . '/../config/inc/admin_nav.inc.php'; ?>
                <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                <div class="mode_jour_nuit_container">
                    <img class="mode_jour_nuit soleil visible" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
                    <img class="mode_jour_nuit lune" src="/portfolio_v01/assets/images/lune_noire.svg" alt="lune indiquant le mode nuit">
                </div>
            </div>
        </div>
    </div>
</header>
    <h1 id="titre_tableau_de_bord">Tableau de bord</h1>
    <p id="texte_tableau_de_bord">Bienvenue dans l'administration de votre portfolio. Vous pouvez gérer vos projets et vos messages de contact ici.</p>

    <div class="dashboard-container">
        <ul id="ul_tableau_de_bord">
            <li class="li_tableau_de_bord"><a class="liens_tableau_de_bord" href="/portfolio_v01/admin/contacts/index.php">Gérer les messages de contact</a></li>
            <li class="li_tableau_de_bord"><a class="liens_tableau_de_bord" href="/portfolio_v01/admin/projets/list.php">Gérer les projets</a></li>
        </ul>
    </div>
    <?php include __DIR__ . '/../config/inc/footer.inc.php'; ?>
<script src="/portfolio_v01/assets/js/script.js"></script>
