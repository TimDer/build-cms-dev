<?php

class routes {
    public static $routes = array();

    public static function set($routes_source, $function, $user_session = false, $user_type = false) {
        if (!$routes_source) {
            $routes_source = "build-cms-templates";
        }

        self::$routes[$routes_source]["user_session"]   = $user_session;
        self::$routes[$routes_source]["user_type"]      = $user_type;
        self::$routes[$routes_source]["routes_string"]  = $routes_source;
        self::$routes[$routes_source]["routes_array"]   = explode( "/", trim($routes_source, "/") );
        self::$routes[$routes_source]["function"]       = $function;
    }

    public static function get($user_redirect = "") {
        if (array_key_exists(user_url::uri_string(), self::$routes)) {
            if (self::run_rout_check_login(self::$routes[user_url::uri_string()]["user_session"], self::$routes[user_url::uri_string()]["user_type"])) {
                user_url::$routes_uri = database::escape(user_url::uri());
                self::$routes[user_url::uri_string()]["function"]->__invoke();
            }
            else {
                header("Location: " . config_url::BASE($user_redirect));
            }
        }
        elseif (user_url::uri_string() === "/") {
            if (self::run_rout_check_login(self::$routes["build-cms-templates"]["user_session"], self::$routes["build-cms-templates"]["user_type"])) {
                self::$routes["build-cms-templates"]["function"]->__invoke();
            }
            else {
                header("Location: " . config_url::BASE($user_redirect));
            }
        }
        else {
            foreach (self::$routes AS $routes_source_array_key => $routes_source_array) {
                if (self::validate_uri(user_url::uri(), $routes_source_array["routes_array"])) {
                    $function_invoke = $routes_source_array_key;
                }
            }

            if (isset($function_invoke)) {
                if (self::run_rout_check_login(self::$routes[$function_invoke]["user_session"], self::$routes[$function_invoke]["user_type"])) {
                    self::$routes[$function_invoke]["function"]->__invoke();
                }
                else {
                    header("Location: " . config_url::BASE($user_redirect));
                }
            }
            else {
                if (self::run_rout_check_login(self::$routes["build-cms-templates"]["user_session"], self::$routes["build-cms-templates"]["user_type"])) {
                    user_url::$new_uri = database::escape(user_url::uri());
                    self::$routes["build-cms-templates"]["function"]->__invoke();
                }
                else {
                    header("Location: " . config_url::BASE($user_redirect));
                }
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

        user_url::$new_uri      = database::escape(array_values($uri));
        user_url::$routes_uri   = database::escape($validate);
    }

    private static $return_run_rout_check_login = false;
    private static $user_type_run_rout_check_login;
    private static function run_rout_check_login($user_session, $user_type) {
        if ($user_session === false && $user_type === false) {
            return true;
        }
        elseif ($user_session !== false && $user_type === false) {
            user_session::check_session($user_session, function () {
                self::$return_run_rout_check_login = true;
            });
            return self::$return_run_rout_check_login;
        }
        else {
            self::$user_type_run_rout_check_login      = $user_type;
            user_session::check_session($user_session, function () {
                user_session::check_session_permission(self::$user_type_run_rout_check_login, function () {
                    self::$return_run_rout_check_login = true;
                });
            });
            return self::$return_run_rout_check_login;
        }
    }
}