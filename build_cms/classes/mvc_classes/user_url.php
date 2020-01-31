<?php

class user_url {
    public static $new_uri      = array();
    public static $routes_uri   = array();
    public static $get_var      = array();
    public static $post_var     = array();

    // escape post_var and get_var
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

    // get new uri string
    public static function uri_string() {
        // remove get var from uri
        $without_get_var = explode(
            "?",
            $_SERVER['REQUEST_URI']
        );

        // escape post_var and get_var
        self::GET_VAR_ESCAPE();

        // uri to array
        $string_to_array = explode(
            "/",
            $without_get_var[0]
        );

        // remove empty value at the beginning of the uri array
        if (empty($string_to_array[0])) {
            unset($string_to_array[0]);
        }

        // remove empty value at the end of the uri array
        if (empty(end($string_to_array))) {
            array_pop($string_to_array);
        }

        // if (base url is at root)
        if (config_url::url_dir() === "") {
            $request_uri = "/" . implode("/", $string_to_array);
            return $request_uri;
        }
        // remove base_url from uri
        else {
            // base url to array
            $config_url_url_dir_to_array = explode("/", config_url::url_dir());

            // remove empty value at the beginning of the base_url array
            if (empty($config_url_url_dir_to_array[0])) {
                unset($config_url_url_dir_to_array[0]);
            }
    
            // remove empty value at the end of the base_url array
            if (empty(end($config_url_url_dir_to_array))) {
                array_pop($config_url_url_dir_to_array);
            }

            // remove base_url from uri
            foreach ($config_url_url_dir_to_array as $key => $value) {
                unset($string_to_array[$key]);
            }

            // reset uri array keys
            $string_to_array_new = array_values( $string_to_array );
            
            // return ( new uri to string )
            return "/" . implode(
                "/",
                $string_to_array_new
            );
        }
    }

    // get new uri array
    public static function uri() {
        $uri_array = explode( "/", trim(self::uri_string(), "/") );

        return $uri_array;
    }
}