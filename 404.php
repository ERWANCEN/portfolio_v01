<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - 404</title>
    <link rel="stylesheet" href="/portfolio_v01/assets/css/style.css">
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>
        
        <main class="error-404">
            <h1 class="titre_principal texte_dark_mode">Page non trouvée</h1>
            <p class="texte texte_dark_mode">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            <a href="/portfolio_v01/" class="cta">Retour à l'accueil</a>
        </main>

        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
</body>
</html>
