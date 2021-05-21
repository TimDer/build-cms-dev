<?php

if (class_exists("build_cms_page_builder_page_functions")) {
    // Define the image block
    build_cms_page_builder_page_functions::define_block("image", "Image");

    // Image loader back-end (page builder)
    build_cms_page_builder_page_functions::set_load_block("image", function ($data) {
        pluginClass_build_cms_media::author_get_image_block($data);
    });

    // Insert image block in the database
    build_cms_page_builder_page_functions::set_insert_block("image", function ($block_array, $page_id, $page_blocks_id) {
        pluginClass_build_cms_media::add_image($block_array, $page_id, $page_blocks_id);
    });

    // Update image block in the database
    build_cms_page_builder_page_functions::set_update_block("image", function ($block_array, $page_id) {
        pluginClass_build_cms_media::save_image($block_array, $page_id);
    });

    // Block deleter
    build_cms_page_builder_page_functions::set_delete_block("image", function ($block_array, $page_id) {
        pluginClass_build_cms_media::delete_image_block($block_array, $page_id);
    });

    // Block loader (template loader)
    build_cms_page_builder_page_functions::set_load_block_template_function("image", function ($block_array) {
        pluginClass_build_cms_media::display_image_block($block_array);
    });

    // CSS loader (template loader)
    build_cms_page_builder_page_functions::set_load_blocks_css_function("image", function ($block_data) {
        pluginClass_build_cms_media::display_css_image_block($block_data);
    });

    // Delete all images of a page if page is deleted
    build_cms_page_builder_page_functions::set_delete_page("build_cms_media", function ($page_id) {
        pluginClass_build_cms_media::delete_page($page_id);
    });

    // Custom javascript (page builder)
    build_cms_page_builder_page_functions::set_custom_js_footer("/admin/footer.php", __DIR__);

    // Custom CSS (page builder)
    build_cms_page_builder_page_functions::set_custom_css_head("/admin/page_builder_head.php", __DIR__);

    // custom area (modal)
    build_cms_page_builder_page_functions::bottom_custom_area("image_modal", function () {
        controller::getView("/admin/image_modal.php", __DIR__);
    });
}