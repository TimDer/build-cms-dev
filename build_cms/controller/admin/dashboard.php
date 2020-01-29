<?php

class dashboard extends controller {
    public static function get_dashboard() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("user", function () {
                self::set_head("/admin/dashboard/head.php");
                self::set_footer("/admin/dashboard/footer.php");

                self::getView("/admin/admin_basics/header.php");
                self::getView("/admin/dashboard/dashboard.php");
                self::getView("/admin/admin_basics/footer.php");
            });
        });
    }
}