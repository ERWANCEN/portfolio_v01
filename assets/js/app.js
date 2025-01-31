'use strict';

// Sélection des éléments nécessaires
let modeJourNuit = document.getElementById('mode_jour_nuit');
let modeJourNuitContainer = document.getElementById('mode_jour_nuit_container');
let body = document.querySelector('body');
let textesDarkMode = document.querySelectorAll('.texte_dark_mode');
let logoJour = document.querySelector('.logo_nav_mode_jour');
let logoNuit = document.querySelector('.logo_nav_mode_nuit');
let logoGitHub = document.getElementById('logo_github');

// Fonction pour activer le mode nuit
function activerModeNuit() {
    body.classList.add('nuit');
    modeJourNuit.setAttribute('src', 'assets/images/lune_noire.svg');
    modeJourNuitContainer.classList.add('nuit');

    textesDarkMode.forEach(element => {
        element.classList.add('nuit');
    });

    logoJour.classList.remove('logo_visible');
    logoNuit.classList.add('logo_visible');


    logoGitHub.setAttribute('src', 'assets/images/github_blanc.webp');


    localStorage.setItem('mode', 'nuit');
}

// Fonction pour activer le mode jour
function activerModeJour() {
    body.classList.remove('nuit');
    modeJourNuit.setAttribute('src', 'assets/images/soleil_blanc.svg');
    modeJourNuitContainer.classList.remove('nuit');

    textesDarkMode.forEach(element => {
        element.classList.remove('nuit');
    });

    logoNuit.classList.remove('logo_visible');
    logoJour.classList.add('logo_visible');

    logoGitHub.setAttribute('src', 'assets/images/github.webp');

    localStorage.setItem('mode', 'jour');
}

// Événement au clic sur le bouton jour/nuit
modeJourNuitContainer.addEventListener('click', () => {
    if (body.classList.contains('nuit')) {
        activerModeJour();
    } else {
        activerModeNuit();
    }
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


// 'use strict';

// // ===== Sélection des éléments nécessaires =====
// let modeJourNuit = document.getElementById('mode_jour_nuit'); // Sélectionne l'image du bouton jour/nuit
// let modeJourNuitContainer = document.getElementById('mode_jour_nuit_container'); // Sélectionne le conteneur du bouton jour/nuit
// let body = document.querySelector('body'); // Sélectionne le corps de la page (body)
// let textesDarkMode = document.querySelectorAll('.texte_dark_mode'); // Sélectionne tous les éléments ayant la classe "texte_dark_mode"
// let logoJour = document.querySelector('.logo_nav_mode_jour'); // Sélectionne le logo noir (mode jour)
// let logoNuit = document.querySelector('.logo_nav_mode_nuit'); // Sélectionne le logo blanc (mode nuit)

// // ===== Fonction pour activer le mode nuit =====
// function activerModeNuit() {
//     body.classList.add('nuit'); // Ajoute la classe "nuit" au body, activant le mode nuit dans le CSS
//     modeJourNuit.setAttribute('src', 'assets/images/lune_noire.svg'); // Change l'image du bouton jour/nuit pour afficher la lune
//     modeJourNuitContainer.classList.add('nuit'); // Ajoute la classe "nuit" au conteneur du bouton (effet de style CSS)

//     // Applique le mode nuit à tous les textes
//     textesDarkMode.forEach(element => {
//         element.classList.add('nuit'); // Ajoute la classe "nuit" aux éléments ayant la classe "texte_dark_mode"
//     });

//     // Gestion des logos : afficher le logo blanc, cacher le logo noir
//     logoJour.classList.remove('logo_visible'); // Cache le logo noir en supprimant la classe "logo_visible"
//     logoNuit.classList.add('logo_visible'); // Affiche le logo blanc en ajoutant la classe "logo_visible"

//     // Enregistre la préférence de mode nuit dans le localStorage
//     localStorage.setItem('mode', 'nuit'); // Stocke la valeur 'nuit' sous la clé 'mode'
// }

// // ===== Fonction pour activer le mode jour =====
// function activerModeJour() {
//     body.classList.remove('nuit'); // Retire la classe "nuit" du body, activant le mode jour dans le CSS
//     modeJourNuit.setAttribute('src', 'assets/images/soleil_blanc.svg'); // Change l'image du bouton jour/nuit pour afficher le soleil
//     modeJourNuitContainer.classList.remove('nuit'); // Retire la classe "nuit" du conteneur du bouton

//     // Applique le mode jour à tous les textes
//     textesDarkMode.forEach(element => {
//         element.classList.remove('nuit'); // Retire la classe "nuit" des éléments ayant la classe "texte_dark_mode"
//     });

//     // Gestion des logos : afficher le logo noir, cacher le logo blanc
//     logoNuit.classList.remove('logo_visible'); // Cache le logo blanc en supprimant la classe "logo_visible"
//     logoJour.classList.add('logo_visible'); // Affiche le logo noir en ajoutant la classe "logo_visible"

//     // Enregistre la préférence de mode jour dans le localStorage
//     localStorage.setItem('mode', 'jour'); // Stocke la valeur 'jour' sous la clé 'mode'
// }

// // ===== Événement au clic sur le bouton jour/nuit =====
// modeJourNuitContainer.addEventListener('click', () => {
//     // Vérifie si le mode nuit est actif en vérifiant la présence de la classe "nuit" sur le body
//     if (body.classList.contains('nuit')) {
//         activerModeJour(); // Si le mode nuit est actif, on repasse en mode jour
//     } else {
//         activerModeNuit(); // Sinon, on passe en mode nuit
//     }
// });

// // ===== Récupération de la préférence enregistrée au chargement de la page =====
// document.addEventListener('DOMContentLoaded', () => {
//     // Récupère la valeur de la préférence de mode dans le localStorage
//     const modeEnregistre = localStorage.getItem('mode');

//     // Si la préférence enregistrée est le mode nuit, active le mode nuit
//     if (modeEnregistre === 'nuit') {
//         activerModeNuit();
//     } else {
//         activerModeJour(); // Sinon, active le mode jour par défaut
//     }
// });
