<?php

class users {
    public static function create_password_salt($min, $max) {
        $randomString   = "abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ_0123456789=!@#$%^&*()+:><.,";
        $salt = "";

        $randomLength = rand($min, $max);

        for ($x = 1; $x <= $randomLength; $x++) {
            $salt .= $randomString[rand(0, strlen($randomString)-1)];
        }
        
        return $salt;
    }

    public static function is_developer($function = false, $else = false) {
        if (config::get_config()["dev_mode_on"] === true) {
            return (is_callable($function)) ? $function() : true;
        }
        else {
            return (is_callable($else)) ? $else() : false;
        }
    }
}