<header>
    <div class="container_header_tablette_desktop">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>

        <div class="container_header">
        <?php include __DIR__ . '/nav.inc.php'; ?>
        <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
            <div class="mode_jour_nuit_container">
                <img class="mode_jour_nuit" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
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
        <label class="burger" for="burger">
            <input type="checkbox" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>
</header>
