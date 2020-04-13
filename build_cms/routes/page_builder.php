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
    load_filesController::load_file("/www-root/admin/page", "404 Not found");
}, "user_id", "author");