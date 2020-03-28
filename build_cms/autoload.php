<?php

// select a file to require
function auto_select_a_dir($dir, $file, $return = false) {
    if (file_exists($dir . "/" . $file)) {
        return $dir . "/" . $file;
    }

    foreach (scandir($dir) as $item) {
        // (skip the '.', '..', 'view' or the www-root folder) or (skip everything if the file has bin found)
        $view_folder    = ( $item === "view" && is_dir($dir . "/" . $item) );
        $wwwRoot_folder = ( $item === "www-root" && is_dir($dir . "/" . $item) );
        $data_folder    = ( $item === "data" && is_dir($dir . "/" . $item) );
        if ( $return || $item == '.' || $item == '..' || $view_folder || $wwwRoot_folder || $data_folder ) {
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