<?php

class user_session {
    // vars
    private static $username = NULL;

    // create a new session
    public static function set_session($session_key = "", $session_value = "") {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($session_key !== "" AND $session_value !== "") {
            $_SESSION[$session_key] = $session_value;
        }
    }

    public static function unset_all_sessions($header_location) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        session_unset();

        header("Location: " . config_url::BASE($header_location));
    }

    public static function return_session_value($key_name) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION[$key_name];
    }

    public static function return_user_name($key_name) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user_id = $_SESSION[$key_name];

        database::select("SELECT user FROM users WHERE id=$user_id", function ($data) {
            self::$username = $data["fetch_all"][0]["user"];
        });

        return self::$username;
    }

    public static function check_session_permission($permission_name, $function, $else = null) {
        $check_user_id = self::return_session_value("user_id");
        
        database::select("SELECT id, user_type FROM users WHERE id=$check_user_id", function ($to_function) {
            // load on admin
            if ($to_function["permission_name"] === "admin") {
                if ($to_function["fetch_all"][0]["user_type"] === "admin") {
                    $to_function["permission_function"]->__invoke();
                }
            }
            // load on author
            elseif ($to_function["permission_name"] === "author") {
                if ($to_function["fetch_all"][0]["user_type"] === "admin") {
                    $to_function["permission_function"]->__invoke();
                }
                elseif ($to_function["fetch_all"][0]["user_type"] === "author") {
                    $to_function["permission_function"]->__invoke();
                }
            }
            // load on user
            elseif ($to_function["permission_name"] === "user") {
                if ($to_function["fetch_all"][0]["user_type"] === "admin") {
                    $to_function["permission_function"]->__invoke();
                }
                elseif ($to_function["fetch_all"][0]["user_type"] === "author") {
                    $to_function["permission_function"]->__invoke();
                }
                elseif ($to_function["fetch_all"][0]["user_type"] === "user") {
                    $to_function["permission_function"]->__invoke();
                }
            }
            // load on admin-only
            elseif ($to_function["permission_name"] === "admin-only") {
                if ($to_function["fetch_all"][0]["user_type"] === "admin") {
                    $to_function["permission_function"]->__invoke();
                }
            }
            // load on author-only
            elseif ($to_function["permission_name"] === "author-only") {
                if ($to_function["fetch_all"][0]["user_type"] === "author") {
                    $to_function["permission_function"]->__invoke();
                }
            }
            // load on user-only
            elseif ($to_function["permission_name"] === "user-only") {
                if ($to_function["fetch_all"][0]["user_type"] === "user") {
                    $to_function["permission_function"]->__invoke();
                }
            }
        }, array(
            "permission_function"   => $function,
            "permission_name"       => $permission_name,
            "else"                  => $else
        ));
    }

    public static function check_session($check, $function, $else = "") {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION[$check])) {
            $function->__invoke();
        }
        elseif (is_string($else)) {
            if (empty($else)) {
                header("Location: " . config_url::BASE("/admin/login"));
            }
            else {
                header("Location: " . config_url::BASE($else));
            }
        }
        else {
            $else->__invoke();
        }
    }

    // keep user loggedin
    public static function keep_user_loggedin() {
        self::check_session("user_id", function () {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $new_array = array();
    
            function keep_user_loggedin_user_session_loop($value) {
                if (!is_array($value)) {
                    return $value;
                }
    
                foreach ($value as $item_key => $item) {
                    if (is_array($item)) {
                        $return[$item_key] = keep_user_loggedin_user_session_loop($item);
                    }
                    else {
                        $return[$item_key] = $item;
                    }
                }
    
                return $return;
            }
    
            // run
            $new_array = keep_user_loggedin_user_session_loop($_SESSION);
            $_SESSION = array();
            $_SESSION = $new_array;
        });
    }
}