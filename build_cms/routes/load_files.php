<?php

routes::set("/images", function () {
    load_filesController::load_file("/view/images", "select an image (404)");
});

routes::set("/view", function () {
    load_filesController::load_file("/view", "select a file (404)");
});