<?php

class routes {
    public static $routes = array();

    public static function set($routes_source, $name, $function) {
        if (!$routes_source) {
            $routes_source = "TD-CMS-templates";
        }

        self::$routes[$routes_source]["name"] = $name;
        self::$routes[$routes_source]["routes_string"] = $routes_source;
        self::$routes[$routes_source]["routes_array"] = explode( "/", trim($routes_source, "/") );
        self::$routes[$routes_source]["function"] = $function;
    }

    public static function get() {
        if (array_key_exists(user_url::uri_string(), self::$routes)) {
            user_url::$routes_uri = user_url::uri();
            self::$routes[user_url::uri_string()]["function"]->__invoke();
        }
        elseif (user_url::uri_string() === "/") {
            self::$routes["TD-CMS-templates"]["function"]->__invoke();
        }
        else {
            foreach (self::$routes AS $routes_source_array_key => $routes_source_array) {
                if (self::validate_uri(user_url::uri(), $routes_source_array["routes_array"])) {
                    $function_invoke = $routes_source_array_key;
                }
            }

            if (isset($function_invoke)) {
                self::$routes[$function_invoke]["function"]->__invoke();
            }
            else {
                user_url::$new_uri = user_url::uri();
                self::$routes["TD-CMS-templates"]["function"]->__invoke();
            }
        }
    }

    private static function validate_uri($uri = array(), $validate = array()) {
        $return = true;

        $uri_amount         = count($uri) - 1;
        $validate_amount    = count($validate) - 1;

        if ($uri_amount >= $validate_amount) {
            for ($start = 0; $start <= $validate_amount; $start++) {
                if ($uri[$start] === $validate[$start] AND $return === true) {
                    $return = true;
                }
                else {
                    $return = false;
                }

                if ($uri_amount > $validate_amount AND $start === $validate_amount AND $return === true) {
                    //set a new uri
                    self::set_new_uri($uri, $validate);
                }
            }
        }
        else {
            $return = false;
        }
        return $return;
    }

    private static function set_new_uri($uri = array(), $validate = array()) {
        foreach ($validate AS $key => $value) {
            unset($uri[$key]);
        }

        user_url::$new_uri      = array_values($uri);
        user_url::$routes_uri   = $validate;
    }
}