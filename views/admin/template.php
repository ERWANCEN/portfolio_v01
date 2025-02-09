<?php include __DIR__ . '/../../config/inc/head.inc.php'; ?>
    <title><?= $pageTitle ?? 'Administration' ?></title>
</head>
<body id="body_tableau_de_bord" class="<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : ''; ?>">
    <div id="container_general">
        <header style="z-index:1003; position:relative;">
            <div class="container_header_tablette_desktop">
                <a href="/portfolio_v01/admin/logout.php" class="logo_container" title="Se déconnecter">
                    <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
                    <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
                </a>
                <div class="container_header">
                    <div class="header_right_group">
                        <?php include __DIR__ . '/../../config/inc/admin_nav.inc.php'; ?>
                        <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                        <div class="mode_jour_nuit_container">
                            <img class="mode_jour_nuit soleil visible" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
                            <img class="mode_jour_nuit lune" src="/portfolio_v01/assets/images/lune_noire.svg" alt="lune indiquant le mode nuit">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?= $content ?? '' ?>
    </div>
    
    <?php include __DIR__ . '/../../config/inc/admin_footer.inc.php'; ?>
</body>
</html>
