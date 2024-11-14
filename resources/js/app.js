import DataTable from "datatables.net-dt";
import jQuery from "jquery";
import "popper.js";
import "bootstrap";
import "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.$ = jQuery;

const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
});
$(function () {
    let table = new DataTable("#myTable", {
        responsive: true,
    });
});
