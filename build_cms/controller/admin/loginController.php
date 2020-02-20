<?php

class loginController extends controller {
    public static function get_login_view() {
        user_session::check_session("user_id", function () {
            header("Location: " . config_url::BASE("/admin"));
        }, function () {
            // get login error
            loginModal::$user_error = self::user_error();
            loginModal::$user_error_display_username = self::user_error_display_username();

            self::getView("/admin/login/login.php");
        });
    }

    public static function user_error() {
        if (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "user_does_not_exist") {
            return "<p>the user that you are looking for does not exist</p>";
        }
        elseif (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "password_is_incorrect") {
            return "<p>The password is incorrect</p>";
        }
    }

    public static function user_error_display_username() {
        if (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "user_does_not_exist" OR isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "password_is_incorrect") {
            return htmlentities(user_url::$new_uri[1]);
        }
    }

    public static function submit_login() {
        $user_name = user_url::$post_var['username'];

        database::query("SELECT * FROM users WHERE user='$user_name'");
        
        database::query_num_rows(function () {
            database::fetch_all();
            $user_array     = database::fetch_result()[0];
            $user_password  = hash("sha512", user_url::$post_var['password'] . $user_array["password_salt"]);

            if ($user_array["password"] === $user_password) {
                user_session::set_session("user_id", $user_array['id']);
                header("Location: " . config_url::BASE("/admin"));
            }
            else {
                header("Location: " . config_url::BASE("/admin/login/password_is_incorrect/" . htmlentities(user_url::$post_var['username'])));
            }
        }, "/admin/login/user_does_not_exist/" . htmlentities(user_url::$post_var['username']));
    }
}