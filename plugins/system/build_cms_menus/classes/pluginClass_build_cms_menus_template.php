<?php

class pluginClass_build_cms_menus_template {
    public static function get_menu($menu_name = "", $css_class = array()) {
        $menu_id = database::select("SELECT `id` FROM `menu_name` WHERE `menu_name`='$menu_name'")[0]["id"];
        $menu_array = database::select("SELECT `id`, `the_name`, `the_url`, `type`, `the_order`, `parent_id` FROM `menu_content` WHERE `menu_name_id`='$menu_id' ORDER BY `the_order` ASC");

        $new_menu_array = array();

        foreach ($menu_array AS $menu_row) {
            $new_menu_array[$menu_row["parent_id"]][((int)$menu_row["the_order"] - 1)] = $menu_row;
            $new_menu_array[$menu_row["parent_id"]][((int)$menu_row["the_order"] - 1)]["the_order"] = ((int)$menu_row["the_order"] - 1);
        }

        foreach (self::$custom_functions AS $func) {
            $func_data = $func["custom_function"]->__invoke($new_menu_array, $menu_id);

            if ($func_data !== NULL) {
                $new_menu_array = $func_data;
            }
        }

        self::loop_menu($new_menu_array, $css_class);
    }

    private static $custom_functions = array();
    public static function set_custom_load($name, $function) {
        if (!isset(self::$custom_functions[$name]["custom_function"])) {
            self::$custom_functions[$name]["custom_function"] = $function;
        }
    }

    private static function loop_menu($array, $css_class, $key = 0) {
        $ul_class = (isset($css_class["ul"])) ? $css_class["ul"]: "";
        $li_class = (isset($css_class["li"])) ? $css_class["li"]: "";
        $a_class = (isset($css_class["a"])) ? $css_class["a"]: "";
        echo "<ul class='" . $ul_class . "'>";
        foreach ($array[$key] AS $menu) {
            echo "<li class='" . $li_class . "'>";
            echo    "<a href='" . $menu["the_url"] . "' class='" . $a_class . "'>";
            echo        $menu["the_name"];
            echo    "</a>";
            if (isset($array[ $menu["id"] ])) {
                self::loop_menu($array, $css_class, $menu["id"]);
            }
            echo "</li>";
        }
        echo "</ul>";
    }
}