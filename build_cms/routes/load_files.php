<?php

routes::set("/admin_files/plugins", function () {
    load_filesController::load_file("/www-root/admin/plugins", "select a file (404)");
});

routes::set("/view", function () {
    load_filesController::load_file("/www-root", "select a file (404)");
});