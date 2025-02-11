<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\DataBase;

session_start();

try {
    $pdo = DataBase::getConnection();
    
    // Récupération des projets
    $stmt = $pdo->query('SELECT * FROM projet_template ORDER BY id_projet DESC');
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $projets = [];
    error_log("Erreur : " . $e->getMessage());
}

include __DIR__ . '/config/inc/head.inc.php';
?>
    <title>Projets - Erwan CÉNAC</title>
</head>
<body class="<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : ''; ?>">
    <div id="container">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>

        <main>
            <section id="container_projets">
                <h1 id="titre_projets" class="titre_principal texte_dark_mode">Projets</h1>
                <?php foreach ($projets as $projet): ?>
                <a href="projet.php?id=<?php echo htmlspecialchars($projet['id_projet']); ?>" class="vignette_projet">
                    <div class="container_image_projet">
                        <img class="image_projet" src="<?php echo asset('images/projets/' . htmlspecialchars($projet['image_principale'])); ?>" alt="<?php echo htmlspecialchars($projet['titre']); ?>">
                    </div>
                    <div class="bas_vignette">
                        <h3 class="nom_du_projet"><?php echo htmlspecialchars($projet['titre']); ?></h3>
                        <img class="fleche_droite" src="<?php echo asset('images/fleche_droite.svg'); ?>" alt="">
                    </div>
                </a>
                <?php endforeach; ?>
            </section>
        </main>

        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>

    </div>
</body>
</html>
