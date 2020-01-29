<?php

class load_files extends controller {
    public static function load_file($dir, $message_404) {
        $uri = user_url::$new_uri;
        
        if (!empty($uri)) {
            foreach ($uri AS $key => $value) {
                if ($value === ".." OR $value === ".") {
                    unset($uri[$key]);
                }
            }
    
            $file_path = $dir . implode("/", $uri);
            if (file_exists( config_dir::BASE($file_path) )) {
                $file = file_get_contents(
                    config_dir::BASE(
                        $file_path
                    )
                );
        
                header("Content-Type: " . self::get_content_type($file));
        
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
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($file);;
    }
}