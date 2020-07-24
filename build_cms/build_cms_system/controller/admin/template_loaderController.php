<?php

class template_loaderController extends controller {
    public static function get_login_view() {
        self::set_head("/admin/template_loader/head.php");
        self::getAdminTemplateView("/admin/template_loader/root.php");
    }
    
    public static function get_template_view() {
        $get_template_loader = database::select(
            "SELECT `plugins`.`directory_name` FROM `plugins`
            INNER JOIN `settings` ON `plugins`.pluginID = `settings`.`tamplateLoaderID`
            WHERE `plugins`.`pluginID` = `settings`.`tamplateLoaderID`"
        )[0];
        if (!empty($get_template_loader["directory_name"])) {
            require config_dir::BASE("/plugins/" . $get_template_loader["directory_name"] . "/index.php");
        }
        else {
            buildCmsTemplateLoaderController::get_template();
        }
    }
}