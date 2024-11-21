import jQuery from "jquery";
import DataTable from "datatables.net-dt";
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
    initializeImageUpload();
});

function initializeImageUpload() {
    $(".upload").each(function () {
        let imageArr = [];
        const $uploadContainer = $(this);
        const $input = $uploadContainer.find(".upload__input");

        $input.on("change", function (e) {
            const previewContainer = $uploadContainer.find(".upload__preview");
            const maxLength = parseInt($input.data("max-length"));
            const files = Array.from(e.target.files);

            if (imageArr.length + files.length > maxLength) return;

            files.forEach((file) => {
                if (!file.type.match("image.*")) return;
                if (imageArr.length >= maxLength) return;

                imageArr.push(file);

                const reader = new FileReader();
                reader.onload = function (event) {
                    const previewHTML = `
                      <div class="upload__preview-item" style="background-image: url('${event.target.result}')">
                            <button type="button" class="upload__remove-button" data-file="${file.name}">&times;</button>
                        </div>`;
                    previewContainer.append(previewHTML);
                };
                reader.readAsDataURL(file);
            });
        });

        $uploadContainer.on("click", ".upload__remove-button", function () {
            const fileName = $(this).data("file");
            $(this)
                .closest(".upload__preview-item")
                .data("deleted", true)
                .remove();
            imageArr = imageArr.filter((file) => file.name !== fileName);
        });

        $uploadContainer.closest("form").on("submit", function (e) {
            e.preventDefault();

            const deletedFiles = $uploadContainer
                .find(".upload__preview-item[data-deleted]")
                .map(function () {
                    return $(this).data("file");
                })
                .get();

            const filesToSubmit = imageArr.filter(
                (file) => !deletedFiles.includes(file.name)
            );

            const dataTransfer = new DataTransfer();
            filesToSubmit.forEach((file) => dataTransfer.items.add(file));
            $input[0].files = dataTransfer.files;

            this.submit();
        });
    });
}
