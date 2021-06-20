<?php

class pluginClass_build_cms_menus {
    public static function query_menu_fix($array) {
        $return_array = array();

        if (is_array($array)) {
            foreach ($array AS $value_content) {
                $return_array[$value_content["parent_id"]][] = $value_content;
            }
        }

        return $return_array;
    }
}