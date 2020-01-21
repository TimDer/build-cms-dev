<?php

routes::set("/images", "load images", function () {
    load_files::load_file("/view/images/", "select an image (404)");
});