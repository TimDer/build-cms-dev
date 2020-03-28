<?php

class template_loaderController extends controller {
    public static function get_login_view() {
        self::set_head("/admin/template_loader/head.php");
        self::getAdminTemplateView("/admin/template_loader/root.php");
    }

    private static $get_template_view_check_login = false;
    public static function get_template_view() {
        user_session::check_session("user_id", function () {
            self::$get_template_view_check_login = true;
        }, false);
        $get_template_loader = database::select(
            "SELECT `plugins`.`directory_name` FROM `plugins`
            INNER JOIN `settings` ON `plugins`.pluginID = `settings`.`tamplateLoaderID`
            WHERE `plugins`.`pluginID` = `settings`.`tamplateLoaderID`"
        )[0];
        if (!empty($get_template_loader["directory_name"])) {
            require config_dir::BASE("/plugins/" . $get_template_loader["directory_name"] . "/index.php");
        }
        else {
            if (self::$get_template_view_check_login === true) {
                echo "Select a template loader";
            }
            else {
                header("Location: " . config_url::BASE("/admin/login"));
            }
        }
    }
}