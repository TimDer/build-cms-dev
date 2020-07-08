// make a new image
$(function () {
    make_block_function("image", function (block_id) {
        return '<div class="image" block_type="image"><div class="header">image</div><div class="content"><button class="delete_block">Delete</button><button class="image-open-modal-btn">Select an image</button><img src="" alt="Select an image" class="img_data" id="image-' + block_id + '" image_id="' + block_id + '" img_filename="" img_size_mode="auto" img_width="0" img_height="0"></div></div>';
    });

    droppable_custom_function("image", function (block_id) {
        $("#block_id_" + block_id).each(function () {
            $(this).removeAttr("style");
        });
    });
});

