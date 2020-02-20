<?php

/* ============================== login - logout ============================== */
    routes::set("/admin_submit/login", function() {
        loginController::submit_login();
    });

    routes::set("/admin_submit/logout", function() {
        user_session::unset_all_sessions("/admin/login");
    }, "user_id");
/* ============================== /login - logout ============================== */

/* ============================== dashboard dir ============================== */
    routes::set("/admin_submit/dashboard/user_profile", function() {
        dashboardController::submit_user_profile_dashboard();
    }, "user_id", "user");
/* ============================== /dashboard dir ============================== */

/* ============================== settings/general ============================== */
    routes::set("/admin_submit/settings/general", function () {
        generalController::submit_general();
    }, "user_id", "admin");
/* ============================== /settings/general ============================== */