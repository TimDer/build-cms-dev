<?php

class pluginClass_build_cms_menus_customItems {
    public static $custom_item = array();
    
    public static function set_custom_item($name, $function) {
        if (!isset( self::$custom_item[$name]["function"] )) {
            self::$custom_item[$name]["function"] = $function;
        }
    }

    public static function set_custom_item_name($name, $function) {
        if (!isset( self::$custom_item[$name]["function_name"] )) {
            self::$custom_item[$name]["function_name"] = $function;
        }
    }
}