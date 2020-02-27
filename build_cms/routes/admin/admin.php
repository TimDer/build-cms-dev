<?php

/* ============================== basic admin dir ============================== */
    routes::set("/admin", function() {
        header("Location: " . config_url::BASE("/admin/iframes/root"));
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

    // get a list of all the users
    routes::set("/admin/settings/users", function () {
        usersController::get_all_users();
    }, "user_id", "admin");

    // edit a specific user
    routes::set("/admin/settings/users/edit", function () {
        usersController::edit_a_user();
    }, "user_id", "admin");

    // edit a specific user
    routes::set("/admin/settings/users/add_new", function () {
        usersController::add_a_new_user();
    }, "user_id", "admin");
/* ============================== /settings dir ============================== */
