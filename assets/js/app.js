'use strict';

// Sélection des éléments nécessaires
let body = document.querySelector('body');
let textesDarkMode = document.querySelectorAll('.texte_dark_mode');
let pointilleDarkMode = document.querySelectorAll('.ligne_pointille');
let inputFormDarkMode = document.querySelectorAll('.input_form');
let logosJour = document.querySelectorAll('.logo_nav_mode_jour');
let logosNuit = document.querySelectorAll('.logo_nav_mode_nuit');
let modeJourNuitContainers = document.querySelectorAll('.mode_jour_nuit_container');
let logosGitHub = document.querySelectorAll('.logo_github');

function ajoutClassNuit(elements) {
    elements.forEach(element => {
        element.classList.add('nuit');
    });
}

function retraitClassNuit(elements) {
    elements.forEach(element => {
        element.classList.remove('nuit');
    });
}

// Fonction pour activer le mode nuit
function activerModeNuit() {
    body.classList.add('nuit');
    modeJourNuitContainers.forEach(container => {
        container.querySelector('.mode_jour_nuit').setAttribute('src', 'assets/images/lune_noire.svg');
        container.classList.add('nuit');
    });

    ajoutClassNuit(textesDarkMode);
    ajoutClassNuit(pointilleDarkMode);
    ajoutClassNuit(inputFormDarkMode);

    logosJour.forEach(logo => logo.classList.remove('logo_visible'));
    logosNuit.forEach(logo => logo.classList.add('logo_visible'));

    logosGitHub.forEach(logo => logo.setAttribute('src', 'assets/images/github_blanc.webp'));

    localStorage.setItem('mode', 'nuit');
}

// Fonction pour activer le mode jour
function activerModeJour() {
    body.classList.remove('nuit');
    modeJourNuitContainers.forEach(container => {
        container.querySelector('.mode_jour_nuit').setAttribute('src', 'assets/images/soleil_blanc.svg');
        container.classList.remove('nuit');
    });

    retraitClassNuit(textesDarkMode);
    retraitClassNuit(pointilleDarkMode);
    retraitClassNuit(inputFormDarkMode);

    logosNuit.forEach(logo => logo.classList.remove('logo_visible'));
    logosJour.forEach(logo => logo.classList.add('logo_visible'));

    logosGitHub.forEach(logo => logo.setAttribute('src', 'assets/images/github.webp'));

    localStorage.setItem('mode', 'jour');
}

// Événement au clic sur les boutons jour/nuit
modeJourNuitContainers.forEach(container => {
    container.addEventListener('click', () => {
        if (body.classList.contains('nuit')) {
            activerModeJour();
        } else {
            activerModeNuit();
        }
    });
});

// Récupérer la préférence enregistrée au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    const modeEnregistre = localStorage.getItem('mode');
    if (modeEnregistre === 'nuit') {
        activerModeNuit();
    } else {
        activerModeJour();
    }
});
