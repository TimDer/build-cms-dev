<?php

class menusController extends controller {
    public static function get_menus() {
        self::set_head("/admin/settings/menus/head.php");
        self::set_footer("/admin/settings/menus/footer.php");

        self::getView("/admin/admin_basics/header.php");
        self::getView("/admin/settings/menus/menus.php");
        self::getView("/admin/admin_basics/footer.php");
    }
}