<?php

class admin_basics {
    private static function private_main_menu_load_js($url) {
        return "<script src='" . config_url::VIEW('/admin/admin_basics/js/' . $url . '.js') . "'></script>";
    }

    private static function private_main_menu_load_css($url) {
        return '<link rel="stylesheet" href="' . config_url::VIEW("/admin/admin_basics/css/" . $url . ".css") . '">';
    }

    public static function main_menu_load_css() {
        // load admin
        user_session::check_session_permission("admin-only", function () {
            echo self::private_main_menu_load_css("main-menu-admin") . PHP_EOL;
        });
        // load author
        user_session::check_session_permission("author-only", function () {
            echo self::private_main_menu_load_css("main-menu-author") . PHP_EOL;
        });
        // load user
        /*user_session::check_session_permission("user", function () {
            echo self::private_main_menu_load_css("main-menu-user") . PHP_EOL;
        });*/
    }

    public static function main_menu_load_js() {
        // load author
        user_session::check_session_permission("author-only", function () {
            echo self::private_main_menu_load_js("main-menu-author") . PHP_EOL;
        });
        // load user
        user_session::check_session_permission("user-only", function () {
            echo self::private_main_menu_load_js("main-menu-user") . PHP_EOL;
        });
    }
}