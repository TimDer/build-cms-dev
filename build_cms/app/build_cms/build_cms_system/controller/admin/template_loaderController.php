<?php

class template_loaderController extends controller {
    public static function get_login_view() {
        self::set_head("/admin/template_loader/head.php");
        self::getAdminTemplateView("/admin/template_loader/root.php");
    }
    
    public static function get_template_view() {
        $get_template_loader = database::select(
            "SELECT `tamplateLoaderID` FROM `settings`"
        );

        $get_template_loader = ($get_template_loader !== false) ?  $get_template_loader[0]: false;

        if (!empty($get_template_loader["tamplateLoaderID"])) {
            require config_dir::BASE($get_template_loader["tamplateLoaderID"]);
        }
        else {
            buildCmsTemplateLoaderController::get_template();
        }
    }
}