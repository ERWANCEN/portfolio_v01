<?php 
// Inclure les fichiers nécessaires
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/autoload.php';

use Config\Database;

// Vérifier si l'ID est présent
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /portfolio_v01/projets.php');
    exit;
}

$id_projet = (int)$_GET['id'];

try {
    $db = Database::getConnection();
    
    // Récupérer les informations du projet
    $stmt = $db->prepare('SELECT * FROM projet_template WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les outils utilisés
    $stmt = $db->prepare('SELECT * FROM outils_utilises WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $outils = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les avis
    $stmt = $db->prepare('SELECT * FROM avis_projet WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les images de contexte
    $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = ?');
    $stmt->execute([$id_projet]);
    $images_contexte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les étapes
    $stmt = $db->prepare('SELECT * FROM etapes_projet WHERE id_projet = ? ORDER BY id_etape');
    $stmt->execute([$id_projet]);
    $etapes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$projet) {
        header('Location: /portfolio_v01/projets.php');
        exit;
    }
} catch (Exception $e) {
    header('Location: /portfolio_v01/projets.php');
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
                        <img src="/portfolio_v01/assets/images/projets/<?php echo htmlspecialchars($projet['image_principale']); ?>" 
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
                                    <img src="/portfolio_v01/assets/images/projets/<?php echo htmlspecialchars($image['image']); ?>" 
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
                                    <?php if (!empty($etape['titre'])): ?>
                                    <h3><?php echo htmlspecialchars($etape['titre']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($etape['description'])): ?>
                                    <div class="texte"><?php echo nl2br(htmlspecialchars($etape['description'])); ?></div>
                                    <?php endif; ?>
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
                                    <img src="/portfolio_v01/assets/images/<?php echo htmlspecialchars($outil['image_outil']); ?>" 
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