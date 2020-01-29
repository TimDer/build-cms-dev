<?php

// skip the view folder
function check_for_view_folder($path, $dir) {
    $path_dir = $path . "/" . $dir;
    $check = __DIR__ . "/view";
    if ($path_dir === $check) {
        return true;
    }
    else {
        return false;
    }
}

// select a file to require
function auto_select_a_dir($dir, $file, $return = false) {
    if (file_exists($dir . "/" . $file)) {
        return $dir . "/" . $file;
    }

    foreach (scandir($dir) as $item) {
        // (skip the '.', '..' or the 'view' folder) or (skip everything if the file has bin found)
        if ($return || $item == '.' || $item == '..' || ($item === "view" AND check_for_view_folder($dir, $item)) ) {
            continue;
        }

        // select the file
        if (is_dir($dir . "/" . $item)) {
            $return = auto_select_a_dir($dir . "/" . $item, $file, $return);
        }
    }

    return $return;
}

// require classes
spl_autoload_register(function ($classname) {
    $filename = $classname . '.php';
    $file = "";

    // loop through the root and skip the view dir
    $file = auto_select_a_dir(__DIR__, $filename);
    if (file_exists($file)) {
        require $file;
    }
});