<?php

class build_cms_page_builder_menus_pluginSubController extends controller{
    public static function set_custom_item_name($id) {
        return database::select("SELECT `pagename` FROM `page` WHERE `id`='$id'")[0]["pagename"];
    }

    public static function set_custom_area() {
        build_cms_page_builder_menus_pluginSubModal::$pages_array = database::select("SELECT `id`, `pagename` FROM `page`");

        self::getView("/build_cms_menus/area.php", __DIR__);
    }
}