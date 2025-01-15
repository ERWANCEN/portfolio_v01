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
            <p id="texte_deroulant">Recherche stage et alternance</p>
            <div class="bande_jaune" id="bande_jaune_bas"></div>
        </div>

        <div id="container_introduction">
            <h2 id="prenom">Erwan CÉNAC</h2>
            <h1 id="texte_introduction">Actuellement à la recherche d’un <strong>stage</strong> et d’une <strong>alternance</strong>.
            Entre <strong>technique</strong> et <strong>design</strong>, <strong>je m'adapte aux besoins du web moderne</strong> avec une <strong>curiosité</strong> pour les <strong>outils innovants</strong>.</h1>
            <button class="cta">Me contacter</button>
        </div>

        <div id="container_projets">

        </div>

        <div id="container_qui_suis_je">
            <h2 id="qui_suis_je">Qui suis-je ?</h2>
            <h3 id="intro_qui_suis_je">Étudiant en Développement Web & Curieux des Nouvelles Technologies</h3>
            <p id="texte_qui_suis_je">Actuellement en première année de spécialité Développement Web, je suis <b>passionné</b> par la création de sites et d’outils numériques. Avec un <b>intérêt grandissant pour l’</b><strong>intelligence artificielle</strong>, je découvre comment ces technologies peuvent <b>enrichir le développement web</b> et simplifier certains processus. Bien que je ne les incorpore pas encore directement dans mes projets, je m’y adapte pour être prêt à répondre aux évolutions de la profession. Polyvalent et motivé, je recherche un stage ou une alternance pour continuer à apprendre et contribuer à des projets innovants.</p>
        </div>
        