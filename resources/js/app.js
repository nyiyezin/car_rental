import jQuery from "jquery";
import * as bootstrap from "bootstrap";
import "popper.js";
import "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { initializeImageUpload } from "./multi-imageupload";

window.$ = jQuery;
window.bootstrap = bootstrap;
window.initializeImageUpload = initializeImageUpload;

const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
});
