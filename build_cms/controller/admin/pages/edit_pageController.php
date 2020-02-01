<?php

class edit_pageController extends controller {
    public static function get_select_page() {
        // set head and footer files
        self::set_head("/admin/page/edit/head.php");
        self::set_footer("/admin/page/edit/footer.php");

        // load view
        self::getView("/admin/admin_basics/header.php");
        self::getView("/admin/page/edit/edit-page.php");
        self::getView("/admin/admin_basics/footer.php");
    }
}