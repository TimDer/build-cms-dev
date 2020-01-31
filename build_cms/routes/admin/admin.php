<?php

/* ============================== basic admin dir ============================== */
    routes::set("/admin", function() {
        header("Location: " . config_url::BASE("/admin/dashboard"));
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

/* ============================== pages dir ============================== */
    routes::set("/admin/pages", function() {
        add_pageController::get_add_page();
    }, "user_id", "author");

    routes::set("/admin/pages/edit-pages", function() {
        edit_pageController::get_select_page();
    }, "user_id", "author");
/* ============================== /pages dir ============================== */

/* ============================== settings dir ============================== */
    // settings general
    routes::set("/admin/settings/general", function () {
        generalController::get_general();
    }, "user_id", "admin");

    // menus
    routes::set("/admin/settings/menus", function () {
        menusController::get_menus();
    }, "user_id", "admin");
/* ============================== /settings dir ============================== */
