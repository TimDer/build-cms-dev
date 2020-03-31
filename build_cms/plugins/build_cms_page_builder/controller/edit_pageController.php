<?php

class edit_pageController extends controller {
    public static function get_select_page() {
        // set head and footer files
        self::set_head("/edit/head.php", __DIR__);
        self::set_footer("/edit/footer.php", __DIR__);

        // load view
        self::getAdminTemplateView("/edit/edit-page.php", __DIR__);
        //self::getView("/admin/admin_basics/header.php");
        //self::getView("/admin/page/edit/edit-page.php");
        //self::getView("/admin/admin_basics/footer.php");
    }
}