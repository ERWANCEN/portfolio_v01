<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\DataBase;

session_start();

// Vérifier si l'ID est présent dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: projets.php');
    exit;
}

$id_projet = (int)$_GET['id'];

try {
    $pdo = DataBase::getConnection();
    
    // Récupération du projet
    $stmt = $pdo->prepare('SELECT * FROM projet_template WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$projet) {
        header('Location: projets.php');
        exit;
    }

    // Récupération des images de contexte
    $stmt = $pdo->prepare('SELECT * FROM images_contexte WHERE id_projet = ? ORDER BY id_image_contexte ASC');
    $stmt->execute([$id_projet]);
    $images_contexte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des outils
    $stmt = $pdo->prepare('SELECT * FROM outils_utilises WHERE id_projet = ? ORDER BY id_outil ASC');
    $stmt->execute([$id_projet]);
    $outils = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des étapes
    $stmt = $pdo->prepare('SELECT * FROM etapes_projet WHERE id_projet = ? ORDER BY id_etape ASC');
    $stmt->execute([$id_projet]);
    $etapes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des avis
    $stmt = $pdo->prepare('SELECT * FROM avis_projet WHERE id_projet = ? ORDER BY id_avis DESC');
    $stmt->execute([$id_projet]);
    $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Erreur : " . $e->getMessage());
    header('Location: projets.php');
    exit;
}

include __DIR__ . '/config/inc/head.inc.php';
?>
    <title><?php echo htmlspecialchars($projet['titre']); ?> - Erwan CÉNAC</title>
</head>
<body class="<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : ''; ?>">
    <div id="container_general">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>

        <div id="container_projet">
            <div class="projet-section-blanche">
                <div class="projet-section-contenu">
                    <h1 class="titre_principal"><?php echo htmlspecialchars($projet['titre']); ?></h1>
                    <div class="projet-image-principale">
                        <?php
                        $image_path = $projet['image_principale'];
                        // Supprimer les préfixes "images/" et "projets/" s'ils existent
                        $image_path = str_replace(['images/', 'projets/'], '', $image_path);
                        ?>
                        <img src="<?php echo asset('images/' . htmlspecialchars($image_path)); ?>" 
                             alt="<?php echo htmlspecialchars($projet['titre']); ?>">
                    </div>
                </div>

                <div class="projet-section-contenu">
                    <?php if (!empty($projet['texte_contexte'])): ?>
                    <div class="projet-section">
                        <h2 class="texte_dark_mode">Contexte</h2>
                        <div class="projet-texte texte_dark_mode">
                            <?php echo nl2br(htmlspecialchars($projet['texte_contexte'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($images_contexte)): ?>
                    <div class="projet-section">
                        <div class="images-contexte">
                            <?php foreach ($images_contexte as $index => $image): ?>
                            <div class="image-contexte <?php echo $index % 2 === 0 ? 'image-gauche' : 'image-droite'; ?>">
                                <div class="image-wrapper">
                                    <?php
                                    $image_path = $image['image'];
                                    // Supprimer les préfixes "images/" et "projets/" s'ils existent
                                    $image_path = str_replace(['images/', 'projets/'], '', $image_path);
                                    ?>
                                    <img src="<?php echo asset('images/' . htmlspecialchars($image_path)); ?>" 
                                         alt="<?php echo htmlspecialchars($image['titre_contexte']); ?>">
                                </div>
                                <div class="texte-wrapper">
                                    <?php if (!empty($image['titre_contexte'])): ?>
                                    <h3 class="titre-contexte texte_dark_mode">
                                        <?php echo htmlspecialchars($image['titre_contexte']); ?>
                                    </h3>
                                    <?php endif; ?>
                                    <?php if (!empty($image['texte_contexte'])): ?>
                                    <div class="texte-contexte texte_dark_mode">
                                        <?php echo nl2br(htmlspecialchars($image['texte_contexte'])); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($etapes)): ?>
                    <div class="projet-section">
                        <h2 class="texte_dark_mode">Étapes du projet</h2>
                        <div class="etapes-liste">
                            <?php foreach ($etapes as $index => $etape): ?>
                            <div class="etape-item">
                                <div class="etape-numero"><?php echo $index + 1; ?></div>
                                <div class="etape-content">
                                    <div class="texte"><?php echo nl2br(htmlspecialchars($etape['description'])); ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($outils)): ?>
                    <div class="projet-section">
                        <h2 class="texte_dark_mode">Outils utilisés</h2>
                        <div class="outils-liste">
                            <?php foreach ($outils as $outil): ?>
                            <div class="outil-item">
                                <?php if (!empty($outil['image_outil'])): ?>
                                <div class="outil-logo-wrapper">
                                    <?php
                                    $image_path = $outil['image_outil'];
                                    // Supprimer le préfixe "images/" s'il existe
                                    $image_path = str_replace('images/', '', $image_path);
                                    ?>
                                    <img src="<?php echo asset('images/' . htmlspecialchars($image_path)); ?>" 
                                         alt="Logo <?php echo htmlspecialchars($outil['nom_outil']); ?>"
                                         class="outil-logo">
                                </div>
                                <?php endif; ?>
                                <span class="outil-nom"><?php echo htmlspecialchars($outil['nom_outil']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($avis)): ?>
                    <div class="projet-section">
                        <h2 class="texte_dark_mode">Avis</h2>
                        <div class="avis-liste">
                            <?php foreach ($avis as $avis_item): ?>
                            <div class="avis-item">
                                <div class="avis-auteur"><?php echo htmlspecialchars($avis_item['nom_auteur']); ?></div>
                                <div class="avis-note"><?php echo str_repeat('★', $avis_item['note']); ?></div>
                                <div class="avis-texte"><?php echo nl2br(htmlspecialchars($avis_item['texte_avis'])); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($projet['texte_details'])): ?>
                    <div class="projet-section">
                        <div class="projet-details">
                            <h2 class="texte_dark_mode">Détails</h2>
                            <div class="projet-texte">
                                <?php echo nl2br(htmlspecialchars($projet['texte_details'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($projet['lien'])): ?>
                    <div class="projet-liens">
                        <a href="<?php echo htmlspecialchars($projet['lien']); ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="cta">
                            Voir le projet
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
    <script src="/portfolio_v01/assets/js/script.js"></script>
</body>
</html>