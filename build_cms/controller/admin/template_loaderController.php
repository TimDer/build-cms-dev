<?php

class template_loaderController extends controller {
    public static function get_template_loader_view() {
        user_session::check_session("user_id", function () {
            self::get_login_view();
        }, function () {
            self::get_template_view();
        });
    }

    public static function get_login_view() {
        self::set_head("/admin/template_loader/head.php");
        self::getAdminTemplateView("/admin/template_loader/root.php");
    }

    public static function get_template_view() {
        echo file_get_contents( config_dir::BASE("/../../demo/demo.html") );
    }
}