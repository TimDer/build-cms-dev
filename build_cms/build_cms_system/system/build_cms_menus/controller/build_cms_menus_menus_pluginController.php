<?php

class build_cms_menus_menus_pluginController extends controller {
    public static function get_menus() {
        self::set_head("/head.php", __DIR__);
        self::set_footer("/footer.php", __DIR__);

        self::getAdminTemplateView("/menus.php", __DIR__);
    }
}