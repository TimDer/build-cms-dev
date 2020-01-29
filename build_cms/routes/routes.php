<?php

require config_dir::ROUTES("/admin/admin.php");
require config_dir::ROUTES("/admin/admin_submit.php");
require config_dir::ROUTES("/load_files.php");

routes::set("/admin/keep-user-loggedin", "keep_user_loggedin", function () {
    user_session::keep_user_loggedin();
});

routes::set(false, false, function () {
    echo "hallo else";
});

routes::get();