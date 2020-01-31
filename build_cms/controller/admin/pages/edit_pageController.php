<?php

class edit_pageController extends controller {
    public static function get_select_page() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                // set head and footer files
                self::set_head("/admin/page/edit/head.php");
                self::set_footer("/admin/page/edit/footer.php");

                // load view
                self::getView("/admin/admin_basics/header.php");
                self::getView("/admin/page/edit/edit-page.php");
                self::getView("/admin/admin_basics/footer.php");
            });
        });
    }
}