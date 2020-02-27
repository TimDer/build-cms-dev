<?php

class usersController extends controller {
    public static function get_all_users() {
        usersModal::$allUsers = database::select("SELECT `id`, `user`, `password_salt`, `user_type`, `user_icon` FROM `users` WHERE id!=" . user_session::return_session_value("user_id"));

        self::set_footer("/admin/settings/users/all_users_footer.php");
        self::set_head("/admin/settings/users/all_users_head.php");
        self::getAdminTemplateView("/admin/settings/users/all_users.php");
    }

    public static function edit_a_user() {
        if ( isset( user_url::$new_uri[0] ) ) {
            $sql = database::select("SELECT `user`, `user_type` FROM `users` WHERE id=" . user_url::$new_uri[0]);

            usersModal::$allUsers = $sql;
    
            if ($sql[0]["user_type"] === "admin") {
                usersModal::$htmlAdminOption = "selected";
            }
            elseif ($sql[0]["user_type"] === "author") {
                usersModal::$htmlAuthorOption = "selected";
            }
            elseif ($sql[0]["user_type"] === "user") {
                usersModal::$htmlUserOption = "selected";
            }
    
            self::set_head("/admin/settings/users/all_users_head.php");
            self::getAdminTemplateView("/admin/settings/users/editUser.php");
        }
        else {
            header( "Location: " . config_url::BASE( "/admin/settings/users" ) );
            self::getAdminTemplateView();
        }
    }

    public static function add_a_new_user() {
        $sql = database::select("SELECT `new_user_default_role` AS `user_type` FROM `settings`")[0];

        if ($sql["user_type"] === "admin") {
            usersModal::$htmlAdminOption = "selected";
        }
        elseif ($sql["user_type"] === "author") {
            usersModal::$htmlAuthorOption = "selected";
        }
        elseif ($sql["user_type"] === "user") {
            usersModal::$htmlUserOption = "selected";
        }

        self::set_head("/admin/settings/users/all_users_head.php");
        self::getAdminTemplateView("/admin/settings/users/addUser.php");
    }

    public static function submit_user_edit() {
        // post data
        $post               = user_url::$post_var;
        $userId             = $post["id"];
        $userName           = $post["username"];
        $password           = $post["password"];
        $passwordConfirm    = $post["passwordConfirm"];
        $salt               = users::create_password_salt(1000, 10000);
        $password_salt      = hash("sha512", $password . $salt);
        $user_type          = $post["user_type"];
        
        // file data
        $user_icon_array            = $_FILES["user-icon"];
        $user_icon_filename         = $user_icon_array["name"];
        $user_icon_customFilename   = $userId . "_user_icon";
        
        // submit
        if ( $password === $passwordConfirm ) {

            // add new user if it does not exist
            if ($userId === "new") {
                database::query("INSERT INTO `users` (`user`) VALUES ('$userName')");
                $newUserId                  = database::$conn->insert_id;
                $user_icon_customFilename   = $newUserId . "_user_icon";
                $userId                     = $newUserId;
            }

            if ( empty( $user_icon_filename ) ) {
                // submit without a file
                if ( empty( $password ) ) {
                    database::query("UPDATE `users` SET `user`='$userName', `user_type`='$user_type' WHERE id='$userId'");
                }
                else {
                    database::query("UPDATE `users` SET `user`='$userName', `password`='$password_salt', `password_salt`='$salt', `user_type`='$user_type' WHERE id='$userId'");
                }
                echo "Success";
            }
            else {
                // submit with a file
                $fileResult = files::upload_to_dir(
                    config_dir::BASE("/www-root/admin/dashboard/user_icons"),
                    $user_icon_array,
                    array('jpg', 'jpeg', 'png', 'gif'),
                    $user_icon_customFilename
                );

                if (is_string($fileResult)) {
                    // database
                    $fileName = mysqli_real_escape_string(database::$conn, $fileResult);
                    if ( empty( $password ) ) {
                        database::query("UPDATE `users` SET `user`='$userName', `user_type`='$user_type', `user_icon`='$fileName' WHERE id='$userId'");
                    }
                    else {
                        database::query("UPDATE `users` SET `user`='$userName', `password`='$password_salt', `password_salt`='$salt', `user_type`='$user_type', `user_icon`='$fileName' WHERE id='$userId'");
                    }
                    echo "Success file";
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
        else {
            echo "The passwords do not match up";
        }
    }

    public static function submit_delete_a_user() {
        $user_icon = database::select("SELECT `user_icon` FROM `users` WHERE `id`=" . user_url::$new_uri[0])[0]["user_icon"];
        database::query("DELETE FROM `users` WHERE `id`=" . user_url::$new_uri[0]);
        if ( !empty( $user_icon ) && file_exists( config_dir::BASE( "/www-root/admin/dashboard/user_icons/" . $user_icon ) ) ) {
            unlink( config_dir::BASE( "/www-root/admin/dashboard/user_icons/" . $user_icon ) );
        }
    }
}