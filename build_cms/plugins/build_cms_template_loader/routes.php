<?php

routes::set("/admin/settings/td_template_loader", function () {
    buildCmsTLAdmin_pluginController::templateManager();
}, "user_id", "admin");

routes::set("/admin_files/template_loader", function () {
    load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root", "ltrim"), "404 not found");
}, "user_id", "admin");