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
        
        $salt = users::create_password_salt(1000, 10000);
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

    public static function add_edit_user_icon_submit() {
        $user_id = user_session::return_session_value("user_id");
        $fileResult = files::upload_to_dir( config_dir::BASE("/www-root/admin/dashboard/user_icons/" . $user_id . "_"), $_FILES['add_icon'], array('jpg', 'jpeg', 'png', 'gif') );

        if (is_string($fileResult)) {
            // database
            $fileName = mysqli_real_escape_string(database::$conn, $user_id . "_" . $_FILES['add_icon']['name']);
            database::query("UPDATE `users` SET `user_icon`='$fileName' WHERE `id`='$user_id'");
            echo "Success";
        }
        elseif (isset($fileResult["name"])) {
            // error
            echo "Error: " . $fileResult['error'];
        }
        else {
            // files allowed
            $result = "The only file types that are allowed are: " . implode("/", $fileResult);
            echo $result;
        }
    }
}