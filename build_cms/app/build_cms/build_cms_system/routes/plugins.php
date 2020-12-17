<?php

// ============================== create a plugin ==============================
    users::is_developer(function () {
        // Create (html display)
        routes::set("/admin/plugins/create", function () {
            createPluginController::get_view();
        }, "user_id", "admin");

        // Create (submit)
        routes::set("/admin_submit/plugins/create", function () {
            createPluginController::submit();
        }, "user_id", "admin");
    });
// ============================== /create a plugin ==============================

// ============================== edit plugins ==============================
    routes::set("/admin/plugins", function () {
        pluginsController::get_plugins_view();
    }, "user_id", "admin");

    users::is_developer(function () {
        routes::set("/admin_submit/plugins/download/", function () {
            pluginsController::download_plugin();
        }, "user_id", "admin");
    });

    routes::set("/admin_submit/plugins/install", function () {
        pluginsController::install_plugin();
    }, "user_id", "admin");

    routes::set("/admin_submit/plugins/delete", function () {
        pluginsController::delete_plugin();
    }, "user_id", "admin");
// ============================== /edit plugins ==============================