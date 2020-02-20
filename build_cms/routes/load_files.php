<?php

// ============================== system plugin manager files ==============================
routes::set("/admin_files/plugins", function () {
    load_filesController::load_file("/www-root/admin/plugins", "select a file (404)");
}, "user_id", "admin");
// ============================== /system plugin manager files ==============================

// ============================== Dashboard files ==============================
routes::set("/admin_files/dashboard", function () {
    load_filesController::load_file("/www-root/admin/dashboard", "select a file (404)");
}, "user_id", "user");
// ============================== /Dashboard files ==============================

// ============================== template_loader login files ==============================
routes::set("/admin_files/root", function () {
    load_filesController::load_file("/www-root/admin/template_loader", "select a file (404)");
}, "user_id", "user");
// ============================== /template_loader login files ==============================

routes::set("/view", function () {
    load_filesController::load_file("/www-root", "select a file (404)");
});