document.addEventListener('DOMContentLoaded', function() {
    // Mode jour/nuit
    const body = document.querySelector('body');
    const modeJourNuitContainer = document.querySelector('.mode_jour_nuit_container');
    const soleil = document.querySelector('.mode_jour_nuit.soleil');
    const lune = document.querySelector('.mode_jour_nuit.lune');
    const logosJour = document.querySelectorAll('.logo_nav_mode_jour');
    const logosNuit = document.querySelectorAll('.logo_nav_mode_nuit');

    // Fonction pour définir un cookie
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Fonction pour obtenir un cookie
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Fonction pour mettre à jour le mode sombre
    function updateDarkMode(isDark) {
        // Mise à jour des classes
        if (isDark) {
            body.classList.add('dark');
            if (soleil) soleil.classList.remove('visible');
            if (lune) lune.classList.add('visible');
        } else {
            body.classList.remove('dark');
            if (soleil) soleil.classList.add('visible');
            if (lune) lune.classList.remove('visible');
        }

        // Mise à jour des logos
        if (logosJour) {
            logosJour.forEach(logo => {
                logo.classList.toggle('logo_visible', !isDark);
            });
        }

        if (logosNuit) {
            logosNuit.forEach(logo => {
                logo.classList.toggle('logo_visible', isDark);
            });
        }

        // Sauvegarder la préférence
        setCookie('darkMode', isDark, 365);
    }

    // Restaurer la préférence du mode sombre depuis le cookie
    const darkMode = getCookie('darkMode') === 'true';
    updateDarkMode(darkMode);

    // Vérifier si les éléments du mode jour/nuit existent et ajouter l'écouteur d'événements
    if (modeJourNuitContainer) {
        modeJourNuitContainer.addEventListener('click', () => {
            const isDark = !body.classList.contains('dark');
            updateDarkMode(isDark);
        });
    }

    // Menu Mobile
    const burgerCheckbox = document.querySelector('#burger');
    const menuLinks = document.querySelectorAll('.mobile_nav a');

    // Vérifier si le burger menu existe
    if (burgerCheckbox) {
        // Fonction pour basculer le menu
        function toggleMenu() {
            // Empêcher le défilement du body quand le menu est ouvert
            document.body.style.overflow = burgerCheckbox.checked ? 'hidden' : '';
        }

        // Event listener pour le checkbox du burger
        burgerCheckbox.addEventListener('change', toggleMenu);

        // Event listeners pour les liens du menu
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                burgerCheckbox.checked = false;
                toggleMenu(); // Ferme le menu quand un lien est cliqué
            });
        });
    }
});
