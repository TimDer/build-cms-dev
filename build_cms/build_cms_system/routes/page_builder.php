<?php

// view
routes::set("/admin/pages", function() {
    add_pageController::get_add_page();
}, "user_id", "author");
routes::set("/admin/pages/edit-pages", function() {
    edit_pageController::get_select_page();
}, "user_id", "author");

// submit
routes::set("/admin_submit/page", function () {
    save_pageController::save_pages();
}, "user_id", "author");
routes::set("/admin_submit/page/delete_page", function () {
    save_pageController::delete_page();
}, "user_id", "author");

// load files
routes::set("/admin_files/page_builder", function () {
    load_filesController::load_file("/build_cms_system/www-root/admin/page", "404 Not found");
}, "user_id", "author");

// load block (CSS)
routes::set("/files/page_builder/load_blocks.css", function () {
    header("Content-Type: text/css");
    page_builder_template_loader::load_css(user_url::$get_var, false);
});