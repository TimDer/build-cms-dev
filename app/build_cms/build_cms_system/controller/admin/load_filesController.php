<?php

class load_filesController extends controller {
    public static function load_file($dir, $message_404, $php = "run") {
        $uri = user_url::$new_uri;
        
        if (!empty($uri)) {
            foreach ($uri AS $key => $value) {
                if ($value === ".." OR $value === ".") {
                    unset($uri[$key]);
                }
            }
    
            $file_path = $dir . "/" . implode("/", $uri);
            if ( !is_dir( config_dir::BASE($file_path) ) && file_exists( config_dir::BASE($file_path) ) ) {
                // get file extention
                $file_to_array = explode("/", $file_path);
                $the_file_name = end($file_to_array);
                $file_array = explode(".", $the_file_name);
                $file_extension = end($file_array);

                if ($file_extension === "php") {
                    if ($php === "run") {
                        require config_dir::BASE($file_path);
                    }
                    elseif ($php === "echo") {
                        $file = file_get_contents( config_dir::BASE($file_path) );
                        header("Content-Type: text/plain");
                        echo $file;
                    }
                    elseif ($php === "block") {
                        echo $message_404;
                    }
                }
                else {
                    $file = file_get_contents( config_dir::BASE($file_path) );
                    header("Content-Type: " . self::get_content_type( config_dir::BASE($file_path), $file_extension) );
                    echo $file;
                }
            }
            else {
                echo $message_404;
            }
        }
        else {
            echo $message_404;
        }
    }

    private static function get_content_type($file, $file_extension) {
        if ($file_extension === "css") {
            return "text/css";
        }
        elseif ($file_extension === "js") {
            return "application/javascript";
        }
        else {
            $finfo = new finfo();
            return $finfo->file($file, FILEINFO_MIME_TYPE);
        }
    }
}