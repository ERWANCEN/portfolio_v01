'use strict';

let counter = 0;
let modeJourNuit = document.getElementById('mode_jour_nuit');
let modeJourNuitContainer = document.getElementById('mode_jour_nuit_container');
let body = document.querySelector('body');
let textesDarkMode = document.querySelectorAll('.texte_dark_mode'); // Textes à changer
let logoJour = document.querySelector('.logo_nav_mode_jour'); // Logo noir (jour)
let logoNuit = document.querySelector('.logo_nav_mode_nuit'); // Logo blanc (nuit)

modeJourNuitContainer.addEventListener('click', () => {
    console.log(counter);

    if (counter % 2 === 0) {
        // Mode nuit
        body.style.background = '#1A1A2E'; 
        modeJourNuit.setAttribute('src', 'assets/images/lune_noire.svg');
        modeJourNuitContainer.classList.add('nuit'); // Active le mode nuit

        // Texte passe en mode nuit
        textesDarkMode.forEach(element => {
            element.classList.add('nuit');
        });

        // Changer logo (jour vers nuit)
        logoJour.classList.remove('logo_visible');
        logoNuit.classList.add('logo_visible');
    } else {
        // Mode jour
        body.style.background = '#FFFDF2'; 
        modeJourNuit.setAttribute('src', 'assets/images/soleil.svg');
        modeJourNuitContainer.classList.remove('nuit'); // Désactive le mode nuit

        // Texte passe en mode jour
        textesDarkMode.forEach(element => {
            element.classList.remove('nuit');
        });

        // Changer logo (nuit vers jour)
        logoNuit.classList.remove('logo_visible');
        logoJour.classList.add('logo_visible');
    }

    counter++; 
});
