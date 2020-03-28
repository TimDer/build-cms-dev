<?php

// template loader admin view
routes::set("/admin/settings/td_template_loader", function () {
    buildCmsTLAdmin_pluginController::templateManager();
}, "user_id", "admin");

// upload template
routes::set("/admin_submit/template_loader/new_template", function () {
    buildCmsTLAdmin_pluginController::upload_template();
}, "user_id", "admin");
routes::set("/admin_submit/template_loader/delete_unzip_folder", function () {
    buildCmsTLAdmin_pluginController::delete_unzip_dir();
}, "user_id", "admin");

// Activate a template
routes::set("/admin_submit/template_loader/activate", function () {
    buildCmsTLAdmin_pluginController::activate_template();
}, "user_id", "admin");

// download template
routes::set("/admin_submit/template_loader/download_template", function () {
    buildCmsTLAdmin_pluginController::download_template_zip();
}, "user_id", "admin");

// create a new template
routes::set("/admin_submit/template_loader/create_new_template", function () {
    buildCmsTLAdmin_pluginController::create_new_template();
}, "user_id", "admin");

// delete a template
routes::set("/admin_submit/template_loader/delete_template", function () {
    buildCmsTLAdmin_pluginController::delete_template();
}, "user_id", "admin");

/* ============================== load files ============================== */
    routes::set("/admin_files/template_loader", function () {
        load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/www-root", "ltrim"), "404 not found");
    }, "user_id", "admin");
    routes::set("/admin/template_loader", function () {
        load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/view/templates", "ltrim"), "404 not found");
    }, "user_id", "admin");
    routes::set("/template", function () {
        load_filesController::load_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . templateLoaderFiles::$template_dir . "/www-root", "ltrim"), "404 not found");
    });
/* ============================== /load files ============================== */