<?php

/* ============================== basic admin dir ============================== */
    routes::set("/admin", function() {
        header("Location: " . config_url::BASE());
    }, "user_id");
/* ============================== /basic admin dir ============================== */

/* ============================== login dir ============================== */
    routes::set("/admin/login", function() {
        loginController::get_login_view();
    });
/* ============================== /login dir ============================== */

/* ============================== dashboard dir ============================== */
    routes::set("/admin/dashboard", function() {
        dashboardController::get_dashboard();
    }, "user_id", "user");
/* ============================== /dashboard dir ============================== */

/* ============================== settings dir ============================== */
    // settings general
    routes::set("/admin/settings/general", function () {
        generalController::get_general();
    }, "user_id", "admin");
/* ============================== /settings dir ============================== */
