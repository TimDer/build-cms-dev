<?php

class pluginClass_build_cms_menus_deleteMenu {
    public static $delete_menu = array();

    public static function menu_item_delete_menu($name, $function) {
        if (!isset($delete_menu[$name]["delete_menu"])) {
            $delete_menu[$name]["delete_menu"] = $function;
        }
    }
}