<?php

routes::set("/images", function () {
    load_filesController::load_file("/build_cms/view/images/", "select an image (404)");
});