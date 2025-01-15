<?php include "./inc/head.inc.php"; ?>
<title>Portfolio - Erwan CÉNAC</title>

</head>
<body>
    <div id="container">

        <header>
            <div id="container_header_tablette_desktop">
                <img src="assets/images/logo_noir_sans_baseline.webp" alt="logo de Erwan CÉNAC" class="logo_nav_mode_jour">
                <?php include "inc/nav.inc.php"; ?>
                <img src="assets/images/france.webp" alt="" class="mode_langue">
                <div class="toggle-switch">
                    <label class="switch-label">
                        <input type="checkbox" class="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>  
            </div>

            <div id="container_header_mobile">
                <img src="assets/images/logo_noir_sans_baseline.webp" alt="logo de Erwan CÉNAC" class="logo_nav_mode_jour">
                <img src="assets/images/france.webp" alt="" class="mode_langue">

                <div class="toggle-switch">
                    <label class="switch-label">
                        <input type="checkbox" class="checkbox">
                        <span class="slider"></span>
                    </label>
                </div> 

                <label class="burger" for="burger">
                    <input type="checkbox" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </header>

        <div id="container_bandeau_deroulant">
            <div class="bande_jaune" id="bande_jaune_haut"></div>
            <p id="texte_deroulant" class="texte">Recherche stage et alternance</p>
            <div class="bande_jaune" id="bande_jaune_bas"></div>
        </div>

        <div id="container_introduction">
            <h2 id="prenom" class="titre_principal">Erwan CÉNAC</h2>
            <h1 id="texte_introduction" class="texte">Actuellement à la recherche d’un <strong>stage</strong> et d’une <strong>alternance</strong>.
            Entre <strong>technique</strong> et <strong>design</strong>, <strong>je m'adapte aux besoins du web moderne</strong> avec une <strong>curiosité</strong> pour les <strong>outils innovants</strong>.</h1>
            <button class="cta">Me contacter</button>
        </div>

        <div id="container_projets">

        </div>

        <div id="container_qui_suis_je">
            <h2 id="qui_suis_je" class="titre_principal">Qui suis-je ?</h2>
            <h3 id="intro_qui_suis_je" class="sous-titre">Étudiant en Développement Web & Curieux des Nouvelles Technologies</h3>
            <p id="texte_qui_suis_je" class="texte">Actuellement en première année de spécialité Développement Web, je suis <b>passionné</b> par la création de sites et d’outils numériques. Avec un <b>intérêt grandissant pour l’</b><strong>intelligence artificielle</strong>, je découvre comment ces technologies peuvent <b>enrichir le développement web</b> et simplifier certains processus. Bien que je ne les incorpore pas encore directement dans mes projets, je m’y adapte pour être prêt à répondre aux évolutions de la profession. Polyvalent et motivé, je recherche un stage ou une alternance pour continuer à apprendre et contribuer à des projets innovants.</p>
        </div>

        <div id="photo_erwan">
            <img id="image_erwan"src="assets/images/photo_erwan.webp" alt="Erwan souriant face à la caméra">
        </div>
        
        <div id="container_qui_suis_je_pro_perso">
            <h2 id="au_travail" class="titre_principal">Au travail</h2>
            <p id="texte_au_travail" class="texte">Dans ma vie professionnelle, je suis quelqu’un de rigoureux et méthodique. J’aime relever des défis techniques et collaborer sur des projets concrets. Mon parcours en design graphique enrichit ma vision en développement web, me permettant de concevoir des interfaces à la fois fonctionnelles et attrayantes. Toujours en quête d’apprentissage, je m’intéresse aussi aux technologies émergentes comme l’intelligence artificielle pour comprendre comment elles peuvent transformer notre métier.</p>
            <h2 id="dans_la_vie" class="titre_principal">Dans la vie</h2>
            <p id="texte_dans_la_vie" class="texte">Dans ma vie personnelle, je suis curieux et créatif. J’aime explorer de nouvelles idées et m’inspirer du monde qui m’entoure, que ce soit à travers des lectures, des expériences ou des projets personnels. Passionné de numérique, je consacre une partie de mon temps libre à approfondir mes compétences et à expérimenter avec des outils innovants. En dehors de l’écran, j’aime partager des moments simples avec mes proches et découvrir de nouveaux horizons.</p>
        </div>