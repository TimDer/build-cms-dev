<?php

class build_cms_page_builder_menus_pluginSubController extends controller{
    public static function set_custom_item_name($id) {
        return database::select("SELECT `pagename` FROM `page` WHERE `id`='$id'")[0]["pagename"];
    }

    public static function set_custom_area() {
        build_cms_page_builder_menus_pluginSubModal::$pages_array = database::select("SELECT `id`, `pagename` FROM `page`");

        self::getView("/build_cms_menus/area.php", __DIR__);
    }

    public static function update_menu_array($array) {
        $page_ids = array();
        $page_where = array();

        foreach ($array AS $parent) {
            foreach ($parent AS $child) {
                if ($child["type"] === "page") {
                    $page_ids[] = $child["the_url"];
                    $page_where[$child["the_url"]] = array(
                        "parent_id" => $child["parent_id"],
                        "the_order" => $child["the_order"]
                    );
                }
            }
        }

        $page_where_query = "`id`='" . implode("' OR `id`='", $page_ids) . "'";
        
        $pages = database::select("SELECT `id`, `pagename`, `url` FROM `page` WHERE $page_where_query ORDER BY `id` ASC");

        foreach ($pages AS $page) {
            $parent_id = $page_where[$page["id"]]["parent_id"];
            $the_order = $page_where[$page["id"]]["the_order"];

            $array[$parent_id][$the_order]["the_name"] = $page["pagename"];
            $array[$parent_id][$the_order]["the_url"] = config_url::BASE("/" . $page["url"]);
        }

        return $array;
    }
}