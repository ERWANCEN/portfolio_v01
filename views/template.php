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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">

<title><?= htmlspecialchars($project['titre']) ?></title>
</head>
<body>

<header>
    <div class="container_header_tablette_desktop">
        <a href="index.php" class="logo_container">
            <img class="logo_nav_mode_jour logo_visible" src="../assets/images/logo_noir_sans_baseline.webp" alt="logo noir" loading="lazy">
            <img class="logo_nav_mode_nuit" src="../assets/images/logo_blanc_sans_baseline.webp" alt="logo blanc" loading="lazy">
        </a>

        <div class="container_header">
        <nav id="nav_bar">
            <ul id="nav">
                <li><a class="texte_dark_mode" href="index.php">Accueil</a></li>
                <li><a class="texte_dark_mode" href="projets.php">Projets</a></li>
                <li><a class="texte_dark_mode" href="index.php#container_qui_suis_je">À propos</a></li>
                <li><a class="texte_dark_mode" href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <img src="../assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
            <div class="mode_jour_nuit_container">
                <img class="mode_jour_nuit" src="../assets/images/soleil_blanc.svg" alt="soleil indiquant le mode jour">
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
    <img src="<?= htmlspecialchars($project['image_principale']) ?>" alt="Image principale du projet">
<?php else: ?>
    <p class="texte texte_dark_mode">Aucune image principale disponible.</p>
<?php endif; ?>


<!-- Texte de contexte -->
<?php if (!empty($project['texte_contexte'])): ?>
    <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($project['texte_contexte'])) ?></p>
<?php else: ?>
    <p class="texte texte_dark_mode">Texte de contexte non disponible.</p>
<?php endif; ?>


<!-- Images de contexte -->
<section>
    <h2 class="sous-titre texte texte_dark_mode">Contexte du projet</h2>
    <?php if (!empty($imagesContexte)): ?>
        <?php foreach ($imagesContexte as $image): ?>
            <div>
                <h3 class="texte texte_dark_mode"><?= htmlspecialchars($image['titre_contexte']) ?></h3>
                <img src="<?= htmlspecialchars($image['image']) ?>" alt="Image contexte">
                <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($image['texte_contexte'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="texte texte_dark_mode">Aucune image de contexte disponible.</p>
    <?php endif; ?>
</section>

<!-- Détails du projet -->
<h2 class="sous-titre texte texte_dark_mode">Détails du projet</h2>
<?php if (!empty($project['texte_details'])): ?>
    <p class="texte texte_dark_mode"><?= nl2br(htmlspecialchars($project['texte_details'])) ?></p>
<?php else: ?>
    <p class="texte texte_dark_mode">Aucun détail supplémentaire pour ce projet.</p>
<?php endif; ?>


<!-- Étapes du projet -->
<h2 class="sous-titre texte texte_dark_mode">Les étapes du projet</h2>
<?php if (!empty($etapes)): ?>
    <ul>
        <?php foreach ($etapes as $etape): ?>
            <li><?= htmlspecialchars($etape['description']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="texte texte_dark_mode">Aucune étape définie pour ce projet.</p>
<?php endif; ?>


<!-- Outils utilisés -->
<h2 class="sous-titre texte texte_dark_mode">Outils utilisés</h2>
<?php if (!empty($outils)): ?>
    <div>
        <?php foreach ($outils as $outil): ?>
            <img src="<?= htmlspecialchars($outil['image_outil']) ?>" alt="<?= htmlspecialchars($outil['nom_outil']) ?>">
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="texte texte_dark_mode">Aucun outil utilisé spécifié pour ce projet.</p>
<?php endif; ?>

<!-- Avis sur le projet -->
<h2 class="titre_principal texte texte_dark_mode">Avis sur le travail</h2>
<?php if (!empty($avis)): ?>
    <?php foreach ($avis as $a): ?>
        <blockquote>
            <p class="texte"><?= nl2br(htmlspecialchars($a['texte_avis'])) ?></p>
            <cite class="texte"><?= htmlspecialchars($a['nom_auteur']) ?> (Note: <?= htmlspecialchars($a['note']) ?>/5)</cite>
        </blockquote>
    <?php endforeach; ?>
<?php else: ?>
    <p class="texte">Aucun avis disponible.</p>
<?php endif; ?>

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
                        <img  class="logos_langages" src="../assets/images/github_blanc.webp" alt="Logo du service web d'hébergement et de gestion de développement de logiciels Github." height="55px" loading="lazy">
                    </a>
                    <a href="https://www.linkedin.com/in/erwancenac/" target="_blank" rel="nofollow">
                        <img  class="logos_langages" src="../assets/images/linkedin.webp" alt="Logo du réseau social professionnel LinkedIn." height="55px" loading="lazy">
                    </a>
                </div>
                <a href="mentions_legales.php" class="ml_pdc">Mentions légales</a>
                <!-- <a id="politiques_de_confidentialite" class="ml_pdc">Politiques de confidentialité</a> -->
            </div>
        <!-- </div> -->
    </footer>
    </div>
    <script src="../assets/js/app.js"></script>
</body>
</html>
