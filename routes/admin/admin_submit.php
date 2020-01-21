<?php

/* ============================== login - logout ============================== */
    routes::set("/admin_submit/login", "admin_submit_login", function() {
        login_submit::submit_login();
    });

    routes::set("/admin_submit/logout", "admin_submit_logout", function() {
        user_session::unset_all_sessions("/admin/login");
    });
/* ============================== /login - logout ============================== */

/* ============================== settings/general ============================== */
    routes::set("/admin_submit/settings/general", "settings general submit", function () {
        general::submit_general();
    });
/* ============================== /settings/general ============================== */

/* ============================== page ============================== */
    routes::set("/admin_submit/page", "save page", function () {
        save_page::save_pages();
    });
    routes::set("/admin_submit/page/load-page", "save page", function () {
        load_page::load();
    });
    routes::set("/admin_submit/page/delete_page", "save page", function () {
        save_page::delete_page();
    });
/* ============================== page ============================== */