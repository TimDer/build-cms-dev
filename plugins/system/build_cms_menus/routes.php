<?php

routes::set("/admin/settings/menus", function () {
    build_cms_menus_menus_pluginController::get_menus();
}, "user_id", "author");

routes::set("/admin_submit/settings/menus", function () {
    build_cms_menus_menus_pluginController::save_menu(user_url::$post_var);
}, "user_id", "author");

routes::set("/admin_submit/settings/add-menu", function () {
    build_cms_menus_menus_pluginController::add_menu(user_url::$post_var);
}, "user_id", "author");

routes::set("/admin_submit/settings/delete-menu", function () {
    build_cms_menus_menus_pluginController::delete_menu(user_url::$post_var);
}, "user_id", "author");

routes::set("/admin_files/plugin/menus", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root", "ltrim"),
        "select a file (404)",
        "block"
    );
}, "user_id", "author");