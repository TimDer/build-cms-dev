<?php

class pluginClass_build_cms_menus_customAreas {
    public static $custom_area = array();

    private static function set_name($name) {
        if (!isset( self::$custom_area[$name]["name"] )) {
            self::$custom_area[$name]["name"] = $name;
        }
    }

    public static function set_custom_area($name, $function) {
        self::set_name($name);

        if (!isset( self::$custom_area[$name]["area"] )) {
            self::$custom_area[$name]["area"] = $function;
        }
    }

    private static function set_header_and_head($name, $file, $location, $head_footer) {
        if (!isset( self::$custom_area[$name][$head_footer] )) {
            self::$custom_area[$name][$head_footer]["file"] = $file;
            self::$custom_area[$name][$head_footer]["location"] = $location;
        }
    }

    public static function set_custom_footer($name, $file, $location) {
        self::set_name($name);
        self::set_header_and_head($name, $file, $location, "footer");
    }

    public static function set_custom_head($name, $file, $location) {
        self::set_name($name);
        self::set_header_and_head($name, $file, $location, "head");
    }
}