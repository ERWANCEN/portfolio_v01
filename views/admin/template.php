<?php 
// Assurez-vous que paths.php est inclus pour avoir accès à BASE_PATH
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/../../config/paths.php';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/admin-buttons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <title><?= $pageTitle ?? 'Administration' ?></title>
</head>
<body id="body_tableau_de_bord" class="<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : ''; ?>">
    <div id="container_general">
        <header style="z-index:1003; position:relative;">
            <div class="container_header_tablette_desktop">
                <a href="<?= BASE_PATH ?>/" class="logo_container" title="Retour au site">
                    <img class="logo_nav_mode_jour logo_visible" src="/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
                    <img class="logo_nav_mode_nuit" src="/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
                </a>
                <div class="container_header">
                    <div class="header_right_group">
                        <?php include __DIR__ . '/../../config/inc/admin_nav.inc.php'; ?>
                        <img src="/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                        <div class="mode_jour_nuit_container">
                            <div class="mode_jour_nuit">
                                <img class="mode_jour_img" src="/assets/images/mode_jour.webp" alt="mode jour" loading="lazy">
                                <img class="mode_nuit_img" src="/assets/images/mode_nuit.webp" alt="mode nuit" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?= $content ?>
        </main>

        <?php include __DIR__ . '/../../config/inc/footer.inc.php'; ?>
    </div>
    <script src="/assets/js/script.js"></script>
</body>
</html>