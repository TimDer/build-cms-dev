<?php

routes::set("/images", "load images", function () {
    load_files::load_file("/build_cms/view/images/", "select an image (404)");
});