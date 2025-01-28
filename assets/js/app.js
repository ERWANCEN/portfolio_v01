'use strict';

let slider = document.getElementsByClassName('slider');
slider.addEventListener('click', () => {
    console.log("Coucou");
    document.getElementsByTagName('body').style.background = '#1A1A2E';
})