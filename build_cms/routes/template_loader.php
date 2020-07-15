<?php

// template loader admin view
routes::set("/admin/settings/template_loader", function () {
    buildCmsTLAdminController::templateManager();
}, "user_id", "admin");

// upload template
routes::set("/admin_submit/template_loader/new_template", function () {
    buildCmsTLAdminController::upload_template();
}, "user_id", "admin");
routes::set("/admin_submit/template_loader/delete_unzip_folder", function () {
    buildCmsTLAdminController::delete_unzip_dir();
}, "user_id", "admin");

// Activate a template
routes::set("/admin_submit/template_loader/activate", function () {
    buildCmsTLAdminController::activate_template();
}, "user_id", "admin");

// download template
routes::set("/admin_submit/template_loader/download_template", function () {
    buildCmsTLAdminController::download_template_zip();
}, "user_id", "admin");

users::is_developer(function () {
    // create a new template
    routes::set("/admin_submit/template_loader/create_new_template", function () {
        buildCmsTLAdminController::create_new_template();
    }, "user_id", "admin");
});

// delete a template
routes::set("/admin_submit/template_loader/delete_template", function () {
    buildCmsTLAdminController::delete_template();
}, "user_id", "admin");

/* ============================== load files ============================== */
    routes::set("/admin_files/template_loader", function () {
        load_filesController::load_file("/www-root/admin/template_loader/select_template", "404 not found");
    }, "user_id", "admin");
    routes::set("/admin/template_loader", function () {
        load_filesController::load_file("/view/templates", "404 not found");
    }, "user_id", "admin");
    routes::set("/template", function () {
        load_filesController::load_file("/view/templates/" . templateLoader::$template_dir . "/www-root", "404 not found");
    });
/* ============================== /load files ============================== */