<?php

// ============================== system plugin manager files ==============================
routes::set("/admin_files/plugins", function () {
    load_filesController::load_file("/build_cms_system/www-root/admin/plugins", "select a file (404)");
}, "user_id", "admin");
// ============================== /system plugin manager files ==============================

// ============================== Dashboard files ==============================
routes::set("/admin_files/dashboard", function () {
    load_filesController::load_file("/build_cms_system/www-root/admin/dashboard", "select a file (404)");
}, "user_id", "user");
// ============================== /Dashboard files ==============================

// ============================== template_loader login files ==============================
routes::set("/admin_files/root", function () {
    load_filesController::load_file("/build_cms_system/www-root/admin/template_loader", "select a file (404)");
}, "user_id", "user");
// ============================== /template_loader login files ==============================

// ============================== Users www-root dir ==============================
routes::set("/admin_files/settings/users", function () {
    load_filesController::load_file("/build_cms_system/www-root/admin/settings/users", "select a file (404)");
}, "user_id", "admin");
// ============================== Users www-root dir ==============================

routes::set("/view", function () {
    load_filesController::load_file("/build_cms_system/www-root", "select a file (404)");
});