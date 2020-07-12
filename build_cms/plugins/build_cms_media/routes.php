<?php

// load scripts
routes::set("/admin_files/plugin/media", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root/admin", "ltrim"),
        "select a file (404)"
    );
}, "user_id", "author");

// load images
routes::set("/images", function () {
    load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root/images", "ltrim"), "select a file (404)");
});

// Images page
routes::set("/admin/media/images", function () {
    build_cms_media_pluginController::load_images();
}, "user_id", "author");

// image upload
routes::set("/admin/media/images/upload", function () {
    build_cms_media_pluginController::upload_image();
}, "user_id", "author");

// Image delete
routes::set("/admin/media/images/delete", function () {
    build_cms_media_pluginController::delete_image();
}, "user_id", "author");

// Downloads page
routes::set("/admin/media/downloads", function () {
    build_cms_media_pluginController::load_downloads();
}, "user_id", "author");