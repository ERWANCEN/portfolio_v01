document.addEventListener('DOMContentLoaded', function() {
    // Mode jour/nuit
    const body = document.querySelector('body');
    const modeJourNuitContainers = document.querySelectorAll('.mode_jour_nuit_container');
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
        if (isDark) {
            body.classList.add('dark');
        } else {
            body.classList.remove('dark');
        }

        // Mise à jour des logos
        logosJour.forEach(logo => {
            logo.classList.toggle('logo_visible', !isDark);
        });
        logosNuit.forEach(logo => {
            logo.classList.toggle('logo_visible', isDark);
        });

        // Sauvegarder la préférence
        setCookie('darkMode', isDark, 365);
    }

    // Restaurer la préférence du mode sombre depuis le cookie
    const darkMode = getCookie('darkMode') === 'true';
    updateDarkMode(darkMode);

    // Ajouter les écouteurs d'événements pour le bouton mode jour/nuit
    modeJourNuitContainers.forEach(container => {
        const button = container.querySelector('.mode_jour_nuit');
        button.addEventListener('click', () => {
            const isDark = !body.classList.contains('dark');
            updateDarkMode(isDark);
        });
    });

    // Mobile Menu
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

    // Menu mobile
    const menuBurger = document.querySelector('.menu_burger');
    const menuMobile = document.querySelector('.menu_mobile');
    
    if (menuBurger && menuMobile) {
        menuBurger.addEventListener('click', function() {
            this.classList.toggle('active');
            menuMobile.classList.toggle('active');
            document.body.style.overflow = menuMobile.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking on a link
        const menuLinks = menuMobile.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuBurger.classList.remove('active');
                menuMobile.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
});
