<?php 
// Inclure les fichiers nécessaires
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\Database;

try {
    $db = Database::getConnection();
    $stmt = $db->query('SELECT * FROM projet_template ORDER BY id_projet DESC');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $projets = [];
}

include __DIR__ . '/config/inc/head.inc.php'; 
?>

<title>Projets - Erwan CÉNAC</title>

</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>

        <div id="container_projets">
            <h2 id="mes_réalisations" class="titre_principal">Mes réalisations</h2>
            <div id="projets_grid">
                <button id="projets_dev">dev</button>
                <button id="projets_design">design</button>
                <p class="texte" id="texte_projets_dev">Découvrez mes projets en développement web, où la structure, la performance et l'interactivité sont au cœur de mes réalisations.</p>

                <?php foreach ($projets as $projet): ?>
                <a href="<?php echo getProjectUrl($projet['id_projet']); ?>" class="vignette_projet">
                    <div class="container_image_projet">
                        <img class="image_projet" src="/portfolio_v01/assets/images/projets/<?php echo htmlspecialchars($projet['image_principale']); ?>" alt="<?php echo htmlspecialchars($projet['titre']); ?>">
                    </div>
                    <div class="bas_vignette">
                        <h3 class="nom_du_projet"><?php echo htmlspecialchars($projet['titre']); ?></h3>
                        <img class="fleche_droite" src="/portfolio_v01/assets/images/fleche_droite.svg" alt="">
                    </div>
                </a>
                <?php endforeach; ?>
                <a href="https://github.com/ERWANCEN?tab=repositories" target="_blank" rel="noopener noreferrer" class="cta">
                    Accéder au repos GitHub
                </a>
            </div>
        </div>

        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
    <script src="/portfolio_v01/assets/js/app.js"></script>
</body>
</html>
