document.addEventListener('DOMContentLoaded', function() {
    // Mode jour/nuit
    const body = document.querySelector('body');
    const modeJourNuitContainer = document.querySelector('.mode_jour_nuit_container');
    const soleil = document.querySelector('.mode_jour_nuit.soleil');
    const lune = document.querySelector('.mode_jour_nuit.lune');

    modeJourNuitContainer.addEventListener('click', () => {
        body.classList.toggle('dark');
        soleil.classList.toggle('visible');
        lune.classList.toggle('visible');
    });

    // Menu Mobile
    const burgerCheckbox = document.querySelector('#burger');
    const menuPanel = document.querySelector('.menu_panel');
    const menuLinks = document.querySelectorAll('.mobile_nav a');

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
});
