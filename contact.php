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

    <form id="formulaire_de_contact" action="">
        <h1 id="titre_contact" class="titre_principal">Contact</h1>

        <div id="champ_nom">
            <label for="nom">Comment vous appelez-vous ?</label>
            <input class="input_form" type="text" name="nom" id="nom">
        </div>

        <div id="champ_email">
            <label for="email">Quel est votre email ?</label>
            <input class="input_form" type="text" name="email" id="email">
        </div>

        <div id="champ_message">
            <label for="message">Quel est votre message ?</label>
            <input class="input_form" type="text" name="message" id="message">
        </div>
    </form>
</div>


<?php include "inc/footer.inc.php"; ?>