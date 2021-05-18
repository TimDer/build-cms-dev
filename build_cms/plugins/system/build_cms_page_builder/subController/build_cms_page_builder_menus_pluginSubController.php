<?php

class build_cms_page_builder_menus_pluginSubController {
    public static function set_custom_item_name($id) {
        return database::select("SELECT `pagename` FROM `page` WHERE `id`='$id'")[0]["pagename"];
    }
}