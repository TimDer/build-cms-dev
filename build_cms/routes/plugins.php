<?php

// install a plugin
routes::set("/admin/plugins/install", function () {
    controller::getAdminHeader();
    echo "install";
    controller::getAdminFooter();
}, "user_id", "admin");

// create a plugin
routes::set("/admin/plugins/create", function () {
    controller::getAdminHeader();
    echo "create";
    controller::getAdminFooter();
}, "user_id", "admin");

// edit plugins
routes::set("/admin/plugins", function () {
    pluginsController::get_plugins_view();
}, "user_id", "admin");