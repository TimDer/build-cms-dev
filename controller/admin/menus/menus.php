<?php

class menus extends controller {
    public static function get_menus() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("admin", function () {
                self::set_head("/admin/settings/menus/head.php");
                self::set_footer("/admin/settings/menus/footer.php");


                self::getView("/admin/admin_basics/header.php");
                self::getView("/admin/settings/menus/menus.php");
                self::getView("/admin/admin_basics/footer.php");
            });
        });
    }
}