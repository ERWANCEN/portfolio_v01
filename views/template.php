<?php
require_once __DIR__ . '/../autoload.php';  // Correction du chemin relatif

use Models\Projet;

// Récupération de l'ID depuis l'URL
$id = $_GET['id'] ?? null;

// Vérification de l'ID
if (!$id || !is_numeric($id)) {
    die('<p style="color: red;">Erreur : ID de projet invalide ou manquant.</p>');
}

// Connexion à la base de données
$db = Config\Database::getConnection();

// Recherche du projet par ID
$project = Projet::findById($db, $id);

// Vérification si le projet existe
if (!$project) {
    die('<p style="color: red;">Erreur : Le projet demandé est introuvable.</p>');
}

?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/portfolio_v01/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">

<title><?= htmlspecialchars($project['titre']) ?></title>
</head>
<body class="projet-detail">
    <main>

<header>
    <div class="container_header_tablette_desktop">
        <a href="/portfolio_v01/" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="/portfolio_v01/assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="/portfolio_v01/assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>

        <div class="container_header">
        <nav id="nav_bar">
            <ul id="nav">
                <li><a class="texte_dark_mode" href="/portfolio_v01/">Accueil</a></li>
                <li><a class="texte_dark_mode" href="/portfolio_v01/projets.php">Projets</a></li>
                <li><a class="texte_dark_mode" href="/portfolio_v01/#container_qui_suis_je">À propos</a></li>
                <li><a class="texte_dark_mode" href="/portfolio_v01/contact.php">Contact</a></li>
            </ul>
        </nav>
        <img src="/portfolio_v01/assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
            <div class="mode_jour_nuit_container">
                <img class="mode_jour_nuit" src="/portfolio_v01/assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
            </div>
        </div>
    </div>

    <div class="container_header_mobile">
        <a href="accueil.php" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="../assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="../assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>        
        <img src="../assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
        <div class="mode_jour_nuit_container">
            <img class="mode_jour_nuit" src="../assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
        </div>        
        <label class="burger" for="burger">
            <input type="checkbox" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>
</header>


<!-- Titre principal -->
<?php if (!empty($project['titre'])): ?>
    <h1 class="texte_principal texte_dark_mode"><?= htmlspecialchars($project['titre']) ?></h1>
<?php else: ?>
    <p>Titre non défini pour ce projet.</p>
<?php endif; ?>


<!-- Image principale -->
<?php if (!empty($project['image_principale'])): ?>
    <div class="image-principale">
        <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($project['image_principale']) ?>" alt="Image principale du projet">
    </div>
<?php endif; ?>

<!-- Contexte du projet -->
<section class="projet-section contexte">
    <h2 class="sous-titre texte texte_dark_mode">Contexte du projet</h2>
    <?php if (!empty($project['texte_contexte'])): ?>
        <div class="texte-contexte">
            <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($project['texte_contexte'])) ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($project['images_contexte'])): ?>
        <div class="images-contexte">
            <?php foreach ($project['images_contexte'] as $image): ?>
                <div class="contexte-item">
                    <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($image['image']) ?>" alt="<?= htmlspecialchars($image['titre_contexte']) ?>">
                    <h3 class="texte texte_dark_mode"><?= htmlspecialchars($image['titre_contexte']) ?></h3>
                    <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($image['texte_contexte'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Détails du projet -->
<section class="projet-section details">
    <h2 class="sous-titre texte texte_dark_mode">Détails du projet</h2>
    <?php if (!empty($project['texte_details'])): ?>
        <div class="details-content">
            <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($project['texte_details'])) ?></p>
        </div>
    <?php endif; ?>
</section>

<!-- Étapes du projet -->
<section class="projet-section etapes">
    <h2 class="sous-titre texte texte_dark_mode">Les étapes du projet</h2>
    <?php if (!empty($project['etapes'])): ?>
        <div class="etapes-timeline">
            <?php foreach ($project['etapes'] as $index => $etape): ?>
                <div class="etape">
                    <span class="numero"><?= $index + 1 ?></span>
                    <p class="texte texte_dark_mode"><?= htmlspecialchars($etape['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Outils utilisés -->
<section class="projet-section outils">
    <h2 class="sous-titre texte texte_dark_mode">Outils utilisés</h2>
    <?php if (!empty($project['outils'])): ?>
        <div class="outils-grid">
            <?php foreach ($project['outils'] as $outil): ?>
                <div class="outil">
                    <img src="/portfolio_v01/assets/images/<?= htmlspecialchars($outil['image_outil']) ?>" alt="<?= htmlspecialchars($outil['nom_outil']) ?>">
                    <span class="texte texte_dark_mode"><?= htmlspecialchars($outil['nom_outil']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Avis sur le projet -->
<section class="projet-section avis">
    <h2 class="titre_principal texte texte_dark_mode">Avis sur le travail</h2>
    <?php if (!empty($project['avis'])): ?>
        <div class="avis-grid">
            <?php foreach ($project['avis'] as $avis): ?>
                <blockquote>
                    <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($avis['texte_avis'])) ?></p>
                    <cite class="texte texte_dark_mode">
                        <span class="auteur"><?= htmlspecialchars($avis['nom_auteur']) ?></span>
                        <span class="note"><?= str_repeat('★', $avis['note']) . str_repeat('☆', 5 - $avis['note']) ?></span>
                    </cite>
                </blockquote>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<footer>
        <div id="container_footer_jaune">
            <!-- <div id="textes_et_cta_footer_jaune"> -->
                <div id="container_cercle_jaune_footer">
                    <div id="cercle_jaune_footer"></div>
                </div>
                <p class="projet_stage_ou_alternance">Un projet ?</p>
                <p class="projet_stage_ou_alternance">Un stage ?</p>
                <p class="projet_stage_ou_alternance">Une alternance ?</p>
                <p id="texte_footer" class="texte">Contactez-moi pour échanger sur vos idées et découvrir comment je peux contribuer à vos projets dans le domaine du développement web. </p>
                <p id="p_cta_contacter_footer"><a id="cta_contacter_footer" href="">Me contacter</a></p>
            <!-- </div> -->
        </div>
        <!-- <div id="fond_footer_noir"> -->
            <div id="container_footer_noir">
                <p id="erwan_footer">Erwan CÉNAC</p>
                <div id="logos_footer">
                    <a href="https://github.com/ERWANCEN?tab=repositories" target="_blank" rel="nofollow">
                        <img  class="logos_langages" src="/portfolio_v01/assets/images/github_blanc.webp" alt="Logo du service web d'hébergement et de gestion de développement de logiciels Github." height="55px" loading="lazy">
                    </a>
                    <a href="https://www.linkedin.com/in/erwancenac/" target="_blank" rel="nofollow">
                        <img  class="logos_langages" src="/portfolio_v01/assets/images/linkedin.webp" alt="Logo du réseau social professionnel LinkedIn." height="55px" loading="lazy">
                    </a>
                </div>
                <a href="mentions_legales.php" class="ml_pdc">Mentions légales</a>
                <!-- <a id="politiques_de_confidentialite" class="ml_pdc">Politiques de confidentialité</a> -->
            </div>
        <!-- </div> -->
    </footer>
    </div>
    <script src="/portfolio_v01/assets/js/script.js"></script>
</body>
</html>
