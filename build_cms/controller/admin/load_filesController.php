<?php

class load_filesController extends controller {
    public static function load_file($dir, $message_404) {
        $uri = user_url::$new_uri;
        
        if (!empty($uri)) {
            foreach ($uri AS $key => $value) {
                if ($value === ".." OR $value === ".") {
                    unset($uri[$key]);
                }
            }
    
            $file_path = $dir . "/" . implode("/", $uri);
            if (file_exists( config_dir::BUILD_CMS_DIR($file_path) )) {
                $file = file_get_contents(
                    config_dir::BUILD_CMS_DIR(
                        $file_path
                    )
                );

                header("Content-Type: " . self::get_content_type(config_dir::BUILD_CMS_DIR($file_path)));
        
                echo $file;
            }
            else {
                echo $message_404;
            }
        }
        else {
            echo $message_404;
        }
    }

    private static function get_content_type($file) {
        $file_to_array = explode("/", $file);
        $the_file_name = end($file_to_array);
        $file_array = explode(".", $the_file_name);
        $file_extension = end($file_array);
        
        if ($file_extension === "css") {
            return "text/css";
        }
        if ($file_extension === "js") {
            return "application/javascript";
        }
        else {
            $finfo = new finfo();
            return $finfo->file($file, FILEINFO_MIME_TYPE);
        }
    }
}