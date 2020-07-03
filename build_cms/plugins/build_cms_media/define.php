<?php

page_functions::define_block("image", "Image");

page_functions::set_load_block("image", function ($data) { media_loadImageBlock_pluginController::author_get_image_block($data); });

// insert image block in the database
page_functions::set_insert_block("image", function ($block_array, $page_id, $page_blocks_id) {
    pluginClass_build_cms_media::add_image($block_array, $page_id, $page_blocks_id);
});

// update image block in the database
page_functions::set_update_block("image", function ($block_array, $page_id) {
    pluginClass_build_cms_media::save_image($block_array, $page_id);
});

page_functions::set_delete_block("image", function ($block_array, $page_id) {
    pluginClass_build_cms_media::delete_image_block($block_array, $page_id);
});


page_functions::set_custom_js_footer("/admin/footer.php", __DIR__);


// custom area (modal)
page_functions::bottom_custom_area("image_modal", function () {
    controller::getView("/admin/image_modal.php", __DIR__);
});