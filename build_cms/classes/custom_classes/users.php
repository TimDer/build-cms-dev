<?php

class users {
    public static function create_password_salt() {
        $randomString   = "abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ_0123456789=!@#$%^&*()+:><.,";
        $salt = "";

        $randomLength = rand(1000, 10000);

        for ($x = 1; $x <= $randomLength; $x++) {
            $salt .= $randomString[rand(0, strlen($randomString)-1)];
        }
        
        return $salt;
    }
}