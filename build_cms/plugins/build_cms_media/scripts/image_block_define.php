<?php

// Define the image block
page_functions::define_block("image", "Image");

// Image loader back-end (page builder)
page_functions::set_load_block("image", function ($data) {
    pluginClass_build_cms_media::author_get_image_block($data);
});

// Insert image block in the database
page_functions::set_insert_block("image", function ($block_array, $page_id, $page_blocks_id) {
    pluginClass_build_cms_media::add_image($block_array, $page_id, $page_blocks_id);
});

// Update image block in the database
page_functions::set_update_block("image", function ($block_array, $page_id) {
    pluginClass_build_cms_media::save_image($block_array, $page_id);
});

// Block deleter
page_functions::set_delete_block("image", function ($block_array, $page_id) {
    pluginClass_build_cms_media::delete_image_block($block_array, $page_id);
});

// Block loader (template loader)
page_functions::set_load_block_template_function("image", function ($block_array) {
    pluginClass_build_cms_media::display_image_block($block_array);
});

// CSS loader (template loader)
page_functions::set_load_blocks_css_function("image", function ($block_data) {
    pluginClass_build_cms_media::display_css_image_block($block_data);
});

// Delete all images of a page if page is deleted
page_functions::set_delete_page("build_cms_media", function ($page_id) {
    pluginClass_build_cms_media::delete_page($page_id);
});

// Custom javascript (page builder)
page_functions::set_custom_js_footer("/admin/footer.php", __DIR__);

// custom area (modal)
page_functions::bottom_custom_area("image_modal", function () {
    controller::getView("/admin/image_modal.php", __DIR__);
});