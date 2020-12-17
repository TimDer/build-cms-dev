<?php

// view
routes::set("/admin/pages", function() {
    build_cms_paga_builder_add_page_pluginController::get_add_page();
}, "user_id", "author");
routes::set("/admin/pages/edit-pages", function() {
    build_cms_page_builder_edit_page_pluginController::get_select_page();
}, "user_id", "author");

// submit
routes::set("/admin_submit/page", function () {
    build_cms_page_builder_save_pageController::build_cms_page_builder_save_pages();
}, "user_id", "author");
routes::set("/admin_submit/page/delete_page", function () {
    build_cms_page_builder_save_pageController::delete_page();
}, "user_id", "author");

// load files
routes::set("/admin_files/page_builder", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root", "ltrim"),
        "404 Not found"
    );
}, "user_id", "author");

// load block (CSS)
routes::set("/files/page_builder/load_blocks.css", function () {
    header("Content-Type: text/css");
    build_cms_page_builder_template_loader::load_css(user_url::$get_var, false);
});