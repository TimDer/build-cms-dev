<?php

class login {
    public static function user_error() {
        if (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "user_does_not_exist") {
            echo "<p>the user that you are looking for does not exist</p>";
        }
        elseif (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "password_is_incorrect") {
            echo "<p>The password is incorrect</p>";
        }
    }

    public static function user_error_display_username() {
        if (isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "user_does_not_exist" OR isset(user_url::$new_uri[0]) AND user_url::$new_uri[0] === "password_is_incorrect") {
            echo 'value="' . htmlentities(user_url::$new_uri[1]) . '"';
        }
    }
}