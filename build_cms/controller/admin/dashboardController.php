<?php

class dashboardController extends controller {
    public static function get_dashboard() {
        $sql = database::select("SELECT `user`, `id`, `user_icon` FROM `users` WHERE `id`=" . user_session::return_session_value("user_id"))[0];

        dashboardModal::$user       = $sql["user"];
        dashboardModal::$user_id    = $sql["id"];
        dashboardModal::$user_icon  = $sql["user_icon"];

        self::set_head("/admin/dashboard/head.php");
        self::set_footer("/admin/dashboard/footer.php");
        self::getAdminTemplateView("/admin/dashboard/dashboard.php");
    }

    public static function submit_user_profile_dashboard() {
        $post = user_url::$post_var;
        
        $salt = users::create_password_salt();
        $password_salt = hash("sha512", $post["password"] . $salt);
        $user = $post["username"];

        database::query("UPDATE `users` SET `user`='$user', `password`='$password_salt', `password_salt`='$salt' WHERE `id`=" . user_session::return_session_value("user_id"));

        if (database::$conn->error) {
            echo "An error occurred while submitting the form";
        }
        else {
            echo "Success";
        }
    }
}