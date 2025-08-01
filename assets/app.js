// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/default.css'

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// document.addEventListener("turbo:load", () => {
window.addEventListener("load", () => {
    console.log("hello world")


    let menu = document.querySelector(".menu");
    let menuOpen = document.querySelector(".menu-open");
    menu.addEventListener("click", () => {
        menuOpen.classList.toggle("hidden");
    });

});

import './reactions.js';
import './message-answer.js';
