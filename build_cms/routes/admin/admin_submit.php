<?php

/* ============================== login - logout ============================== */
    routes::set("/admin_submit/login", function() {
        loginController::submit_login();
    });

    routes::set("/admin_submit/logout", function() {
        user_session::unset_all_sessions("/admin/login");
    }, "user_id");
/* ============================== /login - logout ============================== */

/* ============================== settings/general ============================== */
    routes::set("/admin_submit/settings/general", function () {
        generalController::submit_general();
    }, "user_id", "admin");
/* ============================== /settings/general ============================== */

/* ============================== page ============================== */
    routes::set("/admin_submit/page", function () {
        save_pageController::save_pages();
    }, "user_id", "author");
    routes::set("/admin_submit/page/load-page", function () {
        load_pageController::load();
    }, "user_id", "author");
    routes::set("/admin_submit/page/delete_page", function () {
        save_pageController::delete_page();
    }, "user_id", "author");
/* ============================== page ============================== */