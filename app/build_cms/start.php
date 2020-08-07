<?php

$GLOBALS["autoLoadStartDir"] = __DIR__;
require __DIR__ . "/build_cms_system/autoload.php";
config::start_cms();
require __DIR__ . "/build_cms_system/routes/routes.php";