<?php

class build_cms_menus_menus_pluginController extends controller {
    public static function get_menus() {
        self::set_head("/head.php", __DIR__);
        self::set_footer("/footer.php", __DIR__);

        if (is_array(pluginClass_build_cms_menus_customAreas::$custom_area) && !empty(pluginClass_build_cms_menus_customAreas::$custom_area)) {
            foreach (pluginClass_build_cms_menus_customAreas::$custom_area AS $value) {
                if (isset($value["footer"])) {
                    self::set_footer($value["footer"]["file"], $value["footer"]["location"]);
                }
                if (isset($value["head"])) {
                    self::set_head($value["head"]["file"], $value["head"]["location"]);
                }
            }
        }

        build_cms_menus_pluginModal::$menus_names_array = database::select("SELECT `id`, `menu_name` FROM `menu_name`");

        if (isset(user_url::$get_var["editMenuId"])) {
            $id = user_url::$get_var["editMenuId"];
            build_cms_menus_pluginModal::$menus_data_array = pluginClass_build_cms_menus::query_menu_fix(
                database::select("SELECT `id`, `the_name`, `the_url`, `type`, `parent_id` FROM `menu_content` WHERE `menu_name_id`='$id' ORDER BY `the_order` ASC")
            );
        }

        self::getAdminTemplateView("/menus.php", __DIR__);
    }

    public static function save_menu($menu) {
        $menu_name = $menu["menu_name"];
        $menu_id = $menu["menu_id"];

        if ($menu_name !== "") {
            database::query("UPDATE `menu_name` SET `menu_name`='$menu_name' WHERE `id`='$menu_id'");
        }

        foreach ($menu["data"] AS $menu_value) {

            $id = $menu_value["id"];
            $parent_id = $menu_value["parent_id"];
            $the_order = $menu_value["the_order"];

            database::query("UPDATE `menu_content` SET `parent_id`='$parent_id', `the_order`='$the_order' WHERE `id`='$id'");
            
            if (isset( pluginClass_build_cms_menus_customItems::$custom_item[$menu_value["type"]]["function_save"] )) {
                pluginClass_build_cms_menus_customItems::$custom_item[$menu_value["type"]]["function_save"]->__invoke($menu_value);
            }
        }

        echo json_encode(array(
            "status" => "ok",
            "menu_id" => $menu_id,
            "menu_name" => ($menu_name !== "") ? $menu_name : false
        ), JSON_PRETTY_PRINT);
    }

    public static function save_menu_custom($array) {
        $id     = $array["id"];
        $name   = $array["data"]["name"];
        $url    = $array["data"]["url"];

        database::query("UPDATE `menu_content` SET `the_name`='$name', `the_url`='$url' WHERE `id`='$id'");
    }
}