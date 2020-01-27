<?php

class login_submit {
    public static function submit_login() {
        $user_name = user_url::$post_var['username'];

        database::query("SELECT * FROM users WHERE user='$user_name'");
        
        database::query_num_rows(function () {
            database::fetch_all();
            $user_array     = database::fetch_result()[0];
            $user_password  = hash("sha512", user_url::$post_var['password']);

            if ($user_array["password"] === $user_password) {
                user_session::set_session("user_id", $user_array['id']);
                header("Location: " . config_url::BASE("/admin"));
            }
            else {
                header("Location: " . config_url::BASE("/admin/login/password_is_incorrect/" . htmlentities($_POST['username'])));
            }
        }, "/admin/login/user_does_not_exist/" . htmlentities($_POST['username']));
    }
}