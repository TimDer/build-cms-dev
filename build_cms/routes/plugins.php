<?php

// install a plugin
routes::set("/admin/plugins/install", function () {
    controller::getView("/admin/admin_basics/header.php");
    echo "install";
    controller::getView("/admin/admin_basics/footer.php");
}, "user_id", "admin");

// create a plugin
routes::set("/admin/plugins/create", function () {
    controller::getView("/admin/admin_basics/header.php");
    echo "create";
    controller::getView("/admin/admin_basics/footer.php");
}, "user_id", "admin");

// edit plugins
routes::set("/admin/plugins", function () {
    controller::getView("/admin/admin_basics/header.php");
    echo "plugins";
    controller::getView("/admin/admin_basics/footer.php");
}, "user_id", "admin");