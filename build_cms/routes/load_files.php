<?php

routes::set("/images", function () {
    load_filesController::load_file("/www-root/images", "select an image (404)");
});

routes::set("/view", function () {
    load_filesController::load_file("/www-root", "select a file (404)");
});