<?php

/* ============================== basic admin dir ============================== */
    routes::set("/admin", "admin", function() {
        user_session::check_session("user_id", function () {
            header("Location: " . config_url::BASE("/admin/dashboard"));
        });
    });
/* ============================== /basic admin dir ============================== */

/* ============================== login dir ============================== */
    routes::set("/admin/login", "admin_login", function() {
        loginController::get_login_view();
    });
/* ============================== /login dir ============================== */

/* ============================== dashboard dir ============================== */
    routes::set("/admin/dashboard", "dashboard", function() {
        dashboard::get_dashboard();
    });
/* ============================== /dashboard dir ============================== */

/* ============================== pages dir ============================== */
    routes::set("/admin/pages", "pages/add-page", function() {
        add_page::get_add_page();
    });

    routes::set("/admin/pages/edit-pages", "pages/add-page", function() {
        edit_page::get_select_page();
    });
/* ============================== /pages dir ============================== */

/* ============================== settings dir ============================== */
    // settings general
    routes::set("/admin/settings/general", "settings general", function () {
        generalController::get_general();
    });

    // menus
    routes::set("/admin/settings/menus", "menus", function () {
        menus::get_menus();
    });
/* ============================== /settings dir ============================== */
