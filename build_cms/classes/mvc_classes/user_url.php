<?php

class user_url {
    public static $new_uri      = array();
    public static $routes_uri   = array();
    public static $get_var      = array();
    public static $post_var     = array();

    private static function GET_VAR_ESCAPE() {
        if (!empty($_GET)) {
            database::reset();
            self::$get_var = database::escape($_GET);
            database::reset();
        }
        if (!empty($_POST)) {
            database::reset();
            self::$post_var = database::escape($_POST);
            database::reset();
        }
    }    

    public static function uri_string() {
        $without_get_var = explode(
            "?",
            $_SERVER['REQUEST_URI']
        );

        self::GET_VAR_ESCAPE();

        $string_to_array = explode(
            "/",
            $without_get_var[0]
        );

        if (empty($string_to_array[0])) {
            unset($string_to_array[0]);
        }

        if (empty(end($string_to_array))) {
            array_pop($string_to_array);
        }

        if (config_url::url_dir() === "") {
            $request_uri = "/" . implode("/", $string_to_array);
            return $request_uri;
        }
        else {
            $config_url_url_dir_to_array = explode("/", config_url::url_dir());

            if (empty($config_url_url_dir_to_array[0])) {
                unset($config_url_url_dir_to_array[0]);
            }
    
            if (empty(end($config_url_url_dir_to_array))) {
                array_pop($config_url_url_dir_to_array);
            }

            foreach ($config_url_url_dir_to_array as $key => $value) {
                unset($string_to_array[$key]);
            }

            //array_values
            $string_to_array_new = array_values( $string_to_array );
            
            return "/" . implode(
                "/",
                $string_to_array_new
            );
        }
    }

    public static function uri() {
        $uri_array = explode( "/", trim(self::uri_string(), "/") );

        return $uri_array;
    }

    public static function number_or_keys() {
        foreach (self::uri() AS $key => $value) {
            $number = $key;
        }

        return $number;
    }
}