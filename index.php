<?php include "./config/inc/head.inc.php"; ?>
<title>Portfolio - Erwan CÉNAC</title>

</head>
<body>
    <div id="container_general">

        <?php include "./config/inc/header.inc.php"; ?>

        <div id="container_bandeau_deroulant">
            <div class="bande_jaune" id="bande_jaune_haut"></div>
            <p id="texte_deroulant" class="texte texte_dark_mode">Recherche stage et alternance en développement web</p>
            <div id="bande_jaune_bas" class="bande_jaune"></div>
        </div>

        <div id="container_introduction">
            <h2 id="prenom" class="titre_principal texte_dark_mode">Erwan CÉNAC</h2>
            <h1 id="texte_introduction" class="texte texte_dark_mode">Développeur web polyvalent en recherche de stage et alternance. Entre technique et design, je m'adapte aux besoins du web moderne avec une passion pour les outils innovants.</h1>
            <a id="bouton_intro_me_contacter" class="cta" href="./contact.php">Me contacter</a>
        </div>



        <div id="container_projets">
            <h2 id="mes_réalisations" class="titre_principal">Mes réalisations</h2>
            <div id="projets_grid">
                <button id="projets_dev">dev</button>
                <button id="projets_design">design</button>
                <p class="texte" id="texte_projets_dev">Découvrez mes projets en développement web, mettant en avant la performance, l'écologie et une UX optimisée.</p>
                <div class="vignette_projet">
                    <div class="container_image_projet">
                        <img class="image_projet" src="assets/images/projets/antelope_canyon_01.jpeg" alt="">
                    </div>
                    <div class="bas_vignette">
                        <h3 class="nom_du_projet">Projet 01</h3>
                        <img class="fleche_droite" src="assets/images/fleche_droite.svg" alt="">
                    </div>
                </div>
                <div class="vignette_projet">
                    <div class="container_image_projet">
                        <img class="image_projet" src="assets/images/projets/montgolfieres_01.jpeg" alt="">
                    </div>
                    <div class="bas_vignette">
                        <h3 class="nom_du_projet">Projet 02</h3>
                        <img class="fleche_droite" src="assets/images/fleche_droite.svg" alt="">
                    </div>
                </div>
                <div class="vignette_projet">
                    <div class="container_image_projet">
                        <img class="image_projet" src="assets/images/projets/mont_fuji_01.jpeg" alt="">
                    </div>
                    <div class="bas_vignette">
                        <h3 class="nom_du_projet">Projet 03</h3>
                        <img class="fleche_droite" src="assets/images/fleche_droite.svg" alt="">
                    </div>
                </div>
                <a class="cta" href="projets.php">Voir tous les projets</a>
            </div>
        </div>



        <section id="container_qui_suis_je">
            <h2 id="qui_suis_je" class="titre_principal texte_dark_mode">Qui suis-je ?</h2>
            <h3 id="intro_qui_suis_je" class="sous_titre texte_dark_mode">Étudiant en Développement Web & Curieux des Nouvelles Technologies</h3>
            <p id="texte_qui_suis_je" class="texte texte_dark_mode">Actuellement en première année de spécialité Développement Web, je suis passionné par la création de sites et d’outils numériques. Avec un intérêt grandissant pour l’intelligence artificielle, je découvre comment ces technologies peuvent enrichir le développement web et simplifier certains processus. Bien que je ne les incorpore pas encore directement dans mes projets, je m’y adapte pour être prêt à répondre aux évolutions de la profession. Polyvalent et motivé, je recherche un stage ou une alternance pour continuer à apprendre et contribuer à des projets innovants.</p>
            <div id="photo_erwan">
                <img id="image_erwan"src="assets/images/photo_erwan.webp" alt="Erwan souriant face à la caméra" loading="lazy">
            </div>
        </section>

        
        <section id="container_qui_suis_je_pro_perso">
            <h2 id="au_travail" class="titre_principal">Au travail</h2>
            <p id="texte_au_travail" class="texte">Dans ma vie professionnelle, je suis quelqu’un de rigoureux et méthodique. J’aime relever des défis techniques et collaborer sur des projets concrets. Mon parcours en design graphique enrichit ma vision en développement web, me permettant de concevoir des interfaces à la fois fonctionnelles et attrayantes. Toujours en quête d’apprentissage, je m’intéresse aussi aux technologies émergentes comme l’intelligence artificielle pour comprendre comment elles peuvent transformer notre métier.</p>
            <h2 id="dans_la_vie" class="titre_principal">Dans la vie</h2>
            <p id="texte_dans_la_vie" class="texte">Dans ma vie personnelle, je suis curieux et créatif. J’aime explorer de nouvelles idées et m’inspirer du monde qui m’entoure, que ce soit à travers des lectures, des expériences ou des projets personnels. Passionné de numérique, je consacre une partie de mon temps libre à approfondir mes compétences et à expérimenter avec des outils innovants. En dehors de l’écran, j’aime partager des moments simples avec mes proches et découvrir de nouveaux horizons.</p>
        </section>

        <div id="container_competences">
            <h2 id="compétences" class="titre_principal texte_dark_mode">Mes compétences</h2>

            <h3 id="langages" class="sous_titre sous_titre_competences texte_dark_mode">Langages</h3>
            <div class="container_ligne_pointille_et_logos">
            <div class="ligne_pointille"></div>
                <img id="html" class="logos_langages" src="assets/images/html.webp" alt="Logo du langage de balisage HTML." height="65px" loading="lazy" title="HTML">
                <img id="css" class="logos_langages" src="assets/images/css_nouveau_logo.webp" alt="Logo du langage informatique CSS." height="65px" loading="lazy" title="CSS">
                <img id="javascript" class="logos_langages" src="assets/images/javascript.webp" alt="Logo du langage de programmation JaveScript." height="65px" loading="lazy" title="JavaScript">
                <img id="php" class="logos_langages" src="assets/images/php.webp" alt="Logo du langage de programmation PHP." height="65px" loading="lazy" title="PHP">
            </div>

            <h3 id="frameworks" class="sous_titre sous_titre_competences texte_dark_mode">Frameworks</h3>
            <div class="container_ligne_pointille_et_logos">
                <div class="ligne_pointille"></div>
                <img id="vuejs" class="logos_langages" src="assets/images/vuejs.webp" alt="Logo du frameword JavaScript open-source VueJS." height="65px" loading="lazy" title="VueJS">
                <img id="symfony" class="logos_langages" src="assets/images/symfony.webp" alt="Logo du framework modèle-vue-contrôleur Symfony." height="65px" loading="lazy" title="Symfony">
            </div>
            

            <h3 id="sgbdr" class="sous_titre sous_titre_competences texte_dark_mode">SGBDR</h3>
            <div class="container_ligne_pointille_et_logos">
                <div class="ligne_pointille"></div>
                <img id="mysql" class="logos_langages" src="assets/images/mysql.webp" alt="Logo du système de gestion de bases de données MySQL." height="65px" loading="lazy" title="MySQL">
            </div>
            
            <h3 id="plateformes_web_collaboratives" class="sous_titre sous_titre_competences texte_dark_mode">Plateformes web collaboratives</h3>
            <div class="container_ligne_pointille_et_logos">
                <div class="ligne_pointille"></div>
                <img id="logo_github" class="logos_langages" src="assets/images/github.webp" alt="Logo GitHub" height="65px" loading="lazy" title="GitHub">

            </div>

            <h3 id="wordpress" class="sous_titre sous_titre_competences texte_dark_mode">WordPress</h3>
            <div class="container_ligne_pointille_et_logos">
                <div class="ligne_pointille"></div>
                <img id="wordpress_logo" class="logos_langages" src="assets/images/wordpress.webp" alt="Logo du CMS (content management system) WordPress." height="65px" loading="lazy" title="WordPress">
            </div>

            <h3 id="outils_creatifs" class="sous_titre sous_titre_competences texte_dark_mode">Outils créatifs</h3>
            <div class="container_ligne_pointille_et_logos">
                <div class="ligne_pointille"></div>
                <img id="photoshop" class="logos_langages" src="assets/images/adobe_photoshop.webp" alt="Logo de l’application de retouche photo et design Photoshop." height="65px" loading="lazy" title="Photoshop">
                <img id="illustrator" class="logos_langages" src="assets/images/adobe_illustrator.webp" alt="Logo du logiciel de création graphique vectorielle Illustrator." height="65px" loading="lazy" title="Illustrator">
                <img id="indesign" class="logos_langages" src="assets/images/adobe_indesign.webp" alt="Logo de l'application de mise en page et PAO InDesign." height="65px" loading="lazy" title="InDesign">
                <img id="figma" class="logos_langages" src="assets/images/figma.webp" alt="Logo de l'éditeur de graphiques vectoriels et outil de prototypage Figma." height="65px" loading="lazy" title="Figma">
            </div>
            <div id="cta_compétences">
                <button class="cta">Me contacter</button>
            </div>

        </div>

        <?php include "./config/inc/footer.inc.php"; ?>