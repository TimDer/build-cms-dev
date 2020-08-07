<?php

// load scripts (CSS, js etc)
routes::set("/admin_files/plugin/media", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root/admin", "ltrim"),
        "select a file (404)"
    );
}, "user_id", "author");

// ============================== Images ==============================
// load images
routes::set("/images", function () {
    load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root/images", "ltrim"), "Image not found (404)", "block");
});

// Images page
routes::set("/admin/media/images", function () {
    build_cms_media_pluginController::load_images();
}, "user_id", "author");

// images upload
routes::set("/admin/media/images/upload", function () {
    build_cms_media_pluginController::upload_data("image");
}, "user_id", "author");

// Images delete
routes::set("/admin/media/images/delete", function () {
    build_cms_media_pluginController::delete_data("image");
}, "user_id", "author");
// ============================== /Images ==============================


// ============================== Downloads ==============================
// load download
routes::set("/downloads", function () {
    load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root/downloads", "ltrim"), "Download not found (404)", "echo");
});

// Downloads page
routes::set("/admin/media/downloads", function () {
    build_cms_media_pluginController::load_downloads();
}, "user_id", "author");

// Downloads upload
routes::set("/admin/media/downloads/upload", function () {
    build_cms_media_pluginController::upload_data("download");
}, "user_id", "author");

// downloads delete
routes::set("/admin/media/downloads/delete", function () {
    build_cms_media_pluginController::delete_data("download");
}, "user_id", "author");
// ============================== /Downloads ==============================