<?php

if (!isset($GLOBALS["dir_to_build_cms"])) {
    $GLOBALS["dir_to_build_cms"] = __DIR__;
}

$GLOBALS["autoLoadStartDir"] = __DIR__;
require __DIR__ . "/build_cms_system/autoload.php";
config::start_cms();
require __DIR__ . "/build_cms_system/routes/routes.php";