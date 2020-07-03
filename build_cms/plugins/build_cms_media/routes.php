<?php

routes::set("/admin_files/plugin/media", function () {
    load_filesController::load_file(
        config_dir::PLUGINDIR(__DIR__, "/www-root/admin", "ltrim"),
        "select a file (404)"
    );
}, "user_id", "author");