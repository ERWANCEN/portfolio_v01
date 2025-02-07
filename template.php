<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/autoload.php';
use Models\Template;
use Models\ImagesContexte;
use Models\EtapeProjet;
use Models\OutilsUtilises;
use Models\AvisProjet;
use Config\Database;

// Récupération de l'ID et vérification
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: /portfolio_v01/404.php');
    exit;
}

try {
    $db = Database::getConnection();
    
    // Récupération des données du projet
    $projet = Template::findById($db, $id);
    if (!$projet) {
        header('Location: /portfolio_v01/404.php');
        exit;
    }

    // Récupération des images de contexte
    $stmt = $db->prepare('SELECT * FROM images_contexte WHERE id_projet = :id_projet ORDER BY id_image_contexte');
    $stmt->execute(['id_projet' => $id]);
    $imagesContexte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des étapes du projet
    $stmt = $db->prepare('SELECT * FROM etapes_projet WHERE id_projet = :id_projet ORDER BY id_etape');
    $stmt->execute(['id_projet' => $id]);
    $etapes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des outils utilisés
    $stmt = $db->prepare('SELECT * FROM outils_utilises WHERE id_projet = :id_projet ORDER BY id_outil');
    $stmt->execute(['id_projet' => $id]);
    $outils = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des avis
    $stmt = $db->prepare('SELECT * FROM avis_projet WHERE id_projet = :id_projet ORDER BY id_avis DESC LIMIT 1');
    $stmt->execute(['id_projet' => $id]);
    $avis = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die('Erreur : ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($projet->getTitre()) ?> - Portfolio Erwan Cénec</title>
    <link rel="stylesheet" href="/portfolio_v01/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container_general">
        <?php include __DIR__ . '/config/inc/header.inc.php'; ?>

        <!-- Image principale -->
        <main>
            <div class="projet-section-noire">
                <header class="projet-header">
                    <h1 class="titre_principal"><?= htmlspecialchars($projet->getTitre()) ?></h1>
                    <img src="/portfolio_v01/assets/images/projets/<?= htmlspecialchars($projet->getImagePrincipale()) ?>" 
                         alt="Image principale de <?= htmlspecialchars($projet->getTitre()) ?>"
                         class="image-principale">
                </header>

                <!-- Section Contexte -->
                <section class="section-contexte">
                    <div class="contexte-principal">
                        <h2 class="sous_titre">Contexte</h2>
                        <p class="texte"><?= nl2br(htmlspecialchars($projet->getTexteContexte())) ?></p>
                    </div>

                    <?php foreach ($imagesContexte as $index => $image): ?>
                    <div class="contexte-image <?= $index % 2 === 0 ? 'image-gauche' : 'image-droite' ?>">
                        <div class="image-wrapper">
                            <img src="/portfolio_v01/assets/images/projets/<?= htmlspecialchars($image['image']) ?>" 
                                 alt="<?= htmlspecialchars($image['titre_contexte']) ?>">
                        </div>
                        <div class="texte-wrapper">
                            <h3 class="sous_titre"><?= htmlspecialchars($image['titre_contexte']) ?></h3>
                            <p class="texte"><?= nl2br(htmlspecialchars($image['texte_contexte'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </section>

                <!-- Section Détails -->
                <section class="section-details">
                    <h2 class="sous_titre">Détails du projet</h2>
                    <p class="texte"><?= nl2br(htmlspecialchars($projet->getTexteDetails())) ?></p>
                </section>

                <!-- Section Étapes -->
                <section class="section-etapes fond-jaune">
                    <h2 class="sous_titre">Les étapes du projet</h2>
                    <div class="etapes-liste">
                        <?php foreach ($etapes as $index => $etape): ?>
                        <div class="etape <?= $index % 2 === 0 ? 'etape-gauche' : 'etape-droite' ?>">
                            <div class="numero-wrapper">
                                <span class="numero-etape"><?= $index + 1 ?></span>
                            </div>
                            <div class="texte-wrapper">
                                <p class="texte"><?= nl2br(htmlspecialchars($etape['description'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
    
                <!-- Section Outils -->
                <section class="section-outils">
                    <h2 class="sous_titre">Outils utilisés</h2>
                    <div class="outils-liste">
                        <?php foreach ($outils as $outil): ?>
                        <div class="outil">
                            <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($outil['image_outil']) ?>" 
                                 alt="<?= htmlspecialchars($outil['nom_outil']) ?>"
                                 title="<?= htmlspecialchars($outil['nom_outil']) ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="contact.php" class="cta" id="cta_projet">Me contacter</a>
                </section>

            </div>

            <!-- Section Avis -->
            <?php if ($avis): ?>
            <section class="section-avis">
                <h2 class="titre_principal texte_dark_mode">Avis sur le travail</h2>
                <div class="avis-contenu">
                    <div class="avis-note">
                        <span class="note"><?= htmlspecialchars($avis['note']) ?></span>
                        <span class="note-max">/5</span>
                    </div>
                    <h3 class="avis-auteur"><?= htmlspecialchars($avis['nom_auteur']) ?></h3>
                    <p class="texte"><?= nl2br(htmlspecialchars($avis['texte_avis'])) ?></p>
                </div>
            </section>
            <?php endif; ?>
        </main>

        <?php include __DIR__ . '/config/inc/footer.inc.php'; ?>
    </div>
</body>
</html>
