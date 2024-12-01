import jQuery from "jquery";
import * as bootstrap from "bootstrap";
import "popper.js";
import "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { initializeImageUpload } from "./multi-imageupload";

window.$ = jQuery;
window.bootstrap = bootstrap;
window.initializeImageUpload = initializeImageUpload;

const overlay = document.querySelector("[data-overlay]");
const navbar = document.querySelector("[data-navbar]");
const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const navToggleFunc = function () {
    navToggleBtn.classList.toggle("active");
    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
};

navToggleBtn.addEventListener("click", navToggleFunc);
overlay.addEventListener("click", navToggleFunc);

for (let i = 0; i < navbarLinks.length; i++) {
    navbarLinks[i].addEventListener("click", navToggleFunc);
}

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
    window.scrollY >= 10
        ? header.classList.add("active")
        : header.classList.remove("active");
});
