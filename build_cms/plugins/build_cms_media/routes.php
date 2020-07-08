<?php

routes::set("/admin_files/plugin/media", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root/admin", "ltrim"),
        "select a file (404)"
    );
}, "user_id", "author");

routes::set("/images", function () {
    load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root/images", "ltrim"), "select a file (404)");
});