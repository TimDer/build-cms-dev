<?php

require config_dir::ROUTES("/admin/admin.php");
require config_dir::ROUTES("/admin/admin_submit.php");
require config_dir::ROUTES("/load_files.php");
require config_dir::ROUTES("/plugins.php");
require config_dir::ROUTES("/template_loader.php");

routes::set("/admin/keep-user-loggedin", function () {
    user_session::keep_user_loggedin();
});

routes::set(false, function () {
    template_loaderController::get_template_view();
});
routes::set("/admin/iframes/root", function () {
    template_loaderController::get_login_view();
}, "user_id", "user");

routes::get("/admin/login");