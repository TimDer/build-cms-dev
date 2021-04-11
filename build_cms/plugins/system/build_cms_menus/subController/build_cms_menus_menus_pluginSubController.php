<?php

class build_cms_menus_menus_pluginSubController extends controller {
    public static function get_menu_items($array, $key) {
        if (isset($array[$key])) {
            foreach ($array[$key] AS $menu_item) {
                build_cms_menus_subPluginModal::$parent_id  = $menu_item["parent_id"];
                build_cms_menus_subPluginModal::$the_id     = $menu_item["id"];
                build_cms_menus_subPluginModal::$the_name   = $menu_item["the_name"];
                build_cms_menus_subPluginModal::$the_url    = $menu_item["the_url"];
                build_cms_menus_subPluginModal::$type       = $menu_item["type"];

                build_cms_menus_subPluginModal::$the_array = $array;
                build_cms_menus_subPluginModal::$the_array_key = (int)$menu_item["id"];

                self::getView("/menu_items.php", __DIR__);
            }
        }
    }
}