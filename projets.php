<?php include "./inc/head.inc.php"; ?>
<title>Portfolio - Erwan CÉNAC</title>

</head>
<body>
    <div id="container">
        <header>
            <div id="container_header_tablette_desktop">
                <img src="assets/images/logo_noir_sans_baseline.webp" alt="logo de Erwan CÉNAC" class="logo_nav_mode_jour" loading="lazy">
                <div id="container_header">
                    <?php include "inc/nav.inc.php"; ?>
                    <img src="assets/images/france.webp" alt="" class="mode_langue" loading="lazy">
                    <div class="toggle-switch">
                        <label class="switch-label">
                            <input type="checkbox" class="checkbox">
                            <span class="slider"></span>
                        </label>
                    </div>  
                </div>
            </div>

            <div id="container_header_mobile">
                <img src="assets/images/logo_noir_sans_baseline.webp" alt="logo de Erwan CÉNAC" class="logo_nav_mode_jour" loading="lazy">
                <img src="assets/images/france.webp" alt="" class="mode_langue" loading="lazy">

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
    </div>

    <div id="container_projets">
        <h2 id="mes_réalisations" class="titre_principal">Mes réalisations</h2>
        <div id="projets_grid">
            <button id="projets_dev">dev</button>
            <button id="projets_design">design</button>
            <p class="texte" id="texte_projets_dev">Découvrez mes projets en développement web, où la structure, la performance et l'interactivité sont au cœur de mes réalisations.</p>

                
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/antelope_canyon_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 01</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/montgolfieres_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 02</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/mont_fuji_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 03</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/shiprock_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 04</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/montagne_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 05</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/plaine_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 06</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <div class="vignette_projet">
                <div class="container_image_projet">
                    <img class="image_projet" src="assets/images/projets/falaise_01.jpeg" alt="">
                </div>
                <div class="bas_vignette">
                    <h3 class="nom_du_projet">Projet 07</h3>
                    <a><img class="fleche_droite" src="assets/images/fleche_droite.svg" alt=""></a>
                </div>
            </div>
            <a id="bouton_repos_github" href="https://github.com/ERWANCEN?tab=repositories" target="_blank" rel="noopener noreferrer">
                <!-- <button class="cta">Accéder au repos GitHub</button> -->
                Accéder au repos GitHub
            </a>
        </div>
    </div>

    <?php include "inc/footer.inc.php"; ?>