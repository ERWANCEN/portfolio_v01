<header style="z-index:1003; position:relative;">
    <div class="container_header_tablette_desktop">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>

        <div class="container_header">
            <div class="header_right_group">
                <?php include __DIR__ . '/nav.inc.php'; ?>
                <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                <div class="mode_jour_nuit_container">
                    <img class="mode_jour_nuit soleil visible" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
                    <img class="mode_jour_nuit lune" src="/portfolio_v01/assets/images/lune_noire.svg" alt="lune indiquant le mode nuit">
                </div>
            </div>
        </div>
    </div>

    <div class="container_header_mobile">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>
        <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
        <div class="mode_jour_nuit_container">
            <img class="mode_jour_nuit" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
        </div>
        <div class="mobile_menu_container">
            <input type="checkbox" id="burger">
            <label class="burger" for="burger">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <div class="menu_panel">
                <nav class="mobile_nav">
                    <ul>
                        <li><a class="texte_dark_mode" href="/portfolio_v01/index.php">Accueil</a></li>
                        <li><a class="texte_dark_mode" href="/portfolio_v01/projets.php">Projets</a></li>
                        <li><a class="texte_dark_mode" href="/portfolio_v01/index.php#container_qui_suis_je">À propos</a></li>
                        <li><a class="texte_dark_mode" href="/portfolio_v01/contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
