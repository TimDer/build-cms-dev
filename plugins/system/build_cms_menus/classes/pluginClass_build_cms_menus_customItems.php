<?php

class pluginClass_build_cms_menus_customItems {
    public static array $custom_item;
    
    public static function set_custom_item_load($name, $function) {
        if (!isset( self::$custom_item[$name]["function"] )) {
            self::$custom_item[$name]["function"] = $function;
        }
    }

    public static function set_custom_item_name($name, $function) {
        if (!isset( self::$custom_item[$name]["function_name"] )) {
            self::$custom_item[$name]["function_name"] = $function;
        }
    }

    public static function set_custom_item_save($name, $function) {
        if (!isset( self::$custom_item[$name]["function_save"] )) {
            self::$custom_item[$name]["function_save"] = $function;
        }
    }

    public static function set_custom_item_remove($name, $function) {
        if (!isset( self::$custom_item[$name]["function_remove"] )) {
            self::$custom_item[$name]["function_remove"] = $function;
        }
    }
}