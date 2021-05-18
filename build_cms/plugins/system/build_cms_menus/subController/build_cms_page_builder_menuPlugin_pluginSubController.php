<?php

class build_cms_page_builder_menuPlugin_pluginSubController extends controller {
    public static function page_menu_item($id, $name, $url) {

        build_cms_menus_item_subPluginModal::$id = $id;
        build_cms_menus_item_subPluginModal::$name = $name;
        build_cms_menus_item_subPluginModal::$url = $url;

        self::getView("/item.php", __DIR__);
    }
}