export function initializeImageUpload($uploadContainer) {
    let removedImageIds = [];
    const $input = $uploadContainer.find(".upload__input");
    const previewContainer = $uploadContainer.find(".upload__preview");
    const $removedInput = $uploadContainer
        .closest("form")
        .find("#removed_image_ids");

    $uploadContainer.find(".upload__preview-item").each(function () {
        const imageId = $(this).data("id");
        if (imageId) {
            $(this).data("existing", true);
        }
    });

    $input.on("change", function (e) {
        const files = Array.from(e.target.files);
        files.forEach((file) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const previewHTML = `
                    <div class="upload__preview-item" style="background-image: url('${event.target.result}')">
                        <button type="button" class="upload__remove-button">&times;</button>
                    </div>`;
                previewContainer.append(previewHTML);
            };
            reader.readAsDataURL(file);
        });
    });

    $uploadContainer.on("click", ".upload__remove-button", function () {
        const $item = $(this).closest(".upload__preview-item");
        console.log($item.data("id"));
        const imageId = $item.data("id");

        if (imageId) {
            removedImageIds.push(imageId);
        }
        $item.remove();
        $removedInput.val(JSON.stringify(removedImageIds));
    });
}
