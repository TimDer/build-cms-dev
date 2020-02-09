<?php

require config_dir::ROUTES("/admin/admin.php");
require config_dir::ROUTES("/admin/admin_submit.php");
require config_dir::ROUTES("/load_files.php");
require config_dir::ROUTES("/plugins.php");

routes::set("/admin/keep-user-loggedin", function () {
    user_session::keep_user_loggedin();
});

routes::set(false, function () {
    echo "hallo else";
});

routes::get("/admin/login");