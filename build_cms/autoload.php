<?php

// select a file to require
function auto_select_a_dir($dir, $file, $return = false) {
    if (file_exists($dir . "/" . $file)) {
        return $dir . "/" . $file;
    }

    foreach (scandir($dir) as $item) {
        // (skip the specified folders) or (skip everything if the file has bin found)
        if ( $return || $item == '.' || $item == '..' || ( in_array($item, config::$autoloaderSkipDir) && is_dir($dir . "/" . $item) ) ) {
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