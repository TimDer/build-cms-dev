<?php

// install a plugin
routes::set("/admin/plugins/install", function () {
    controller::getAdminHeader();
    echo "install";
    controller::getAdminFooter();
}, "user_id", "admin");

// ============================== create a plugin ==============================
    routes::set("/admin/plugins/create", function () {
        createPluginController::get_view();
    }, "user_id", "admin");

    routes::set("/admin_submit/plugins/create", function () {
        createPluginController::submit();
    }, "user_id", "admin");
// ============================== /create a plugin ==============================

// edit plugins
routes::set("/admin/plugins", function () {
    pluginsController::get_plugins_view();
}, "user_id", "admin");