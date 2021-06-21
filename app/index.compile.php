<?php

// do not change this line (config_dir::ROOT_DIR())
$GLOBALS["index_root_dir"] = __DIR__;

// dir to build_cms
$GLOBALS["dir_to_build_cms"] = __DIR__ . "/build_cms";

// load the CMS
require $GLOBALS["dir_to_build_cms"] . "/start.php";