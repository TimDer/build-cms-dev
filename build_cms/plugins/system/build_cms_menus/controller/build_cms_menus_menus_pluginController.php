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
        $menu_name = (isset($menu["menu_name"])) ? $menu["menu_name"] : "";
        $menu_id = (isset($menu["menu_id"])) ? $menu["menu_id"] : 0;

        if ($menu_name !== "") {
            database::query("UPDATE `menu_name` SET `menu_name`='$menu_name' WHERE `id`='$menu_id'");
        }

        $return_data = array();
        if (!empty($menu["data"])) {
            foreach ($menu["data"] AS $menu_key => $menu_value) {

                $id = $menu_value["id"];
                $parent_id = $menu_value["parent_id"];
                $the_order = $menu_value["the_order"];
                $type = $menu_value["type"];
                $name = $menu_value["name"];
                $url = $menu_value["url"];
    
                if ($id === "new") {
                    database::query("INSERT INTO `menu_content` (`the_name`,
                                                                    `the_url`,
                                                                    `type`,
                                                                    `the_order`,
                                                                    `parent_id`,
                                                                    `menu_name_id`)
                                                            VALUES ('$name',
                                                                    '$url',
                                                                    '$type',
                                                                    '$the_order',
                                                                    '$parent_id',
                                                                    '$menu_id')");
                    $menu["data"][$menu_key]["id"] = database::$conn->insert_id;
                    $menu_value["id"] = database::$conn->insert_id;
                    $menu_value["db_status"] = "new";
                }
                else {
                    database::query("UPDATE `menu_content` SET `parent_id`='$parent_id', `the_order`='$the_order' WHERE `id`='$id'");
                    $menu_value["db_status"] = "update";
                }

                $return_data[$parent_id][$the_order] = $menu_value;
                
                if (isset( pluginClass_build_cms_menus_customItems::$custom_item[$type]["function_save"] )) {
                    pluginClass_build_cms_menus_customItems::$custom_item[$menu_value["type"]]["function_save"]->__invoke($menu_value);
                }
            }
        }

        if (!empty($menu["remove"])) {
            foreach ($menu["remove"] AS $menu_remove) {
                $id = $menu_remove["id"];
                $type = $menu_value["type"];

                database::query("DELETE FROM `menu_content` WHERE `id`='$id' AND `menu_name_id`='$menu_id'");

                if (isset( pluginClass_build_cms_menus_customItems::$custom_item[$type]["function_remove"] )) {
                    pluginClass_build_cms_menus_customItems::$custom_item[$type]["function_remove"]->__invoke();
                }
            }
        }

        echo json_encode(array(
            "status" => "ok",
            "menu_id" => $menu_id,
            "menu_name" => ($menu_name !== "") ? $menu_name : false,
            "data" => $return_data
        ), JSON_PRETTY_PRINT);
    }

    public static function save_menu_custom($array) {
        if ($array["db_status"] === "update") {
            $id     = $array["id"];
            $name   = $array["data"]["name"];
            $url    = $array["data"]["url"];
    
            database::query("UPDATE `menu_content` SET `the_name`='$name', `the_url`='$url' WHERE `id`='$id'");
        }
    }

    public static function add_menu($post) {
        $name = $post["menu_name"];
        $id = false;
        $alert = "The menu has been added";

        if ($name !== "") {
            database::query("INSERT INTO `menu_name` (`menu_name`) VALUES ('$name')");

            if (database::query_result()) {
                $id = database::$conn->insert_id;
            }
            else {
                $alert = "Something went wrong";
            }
        }
        else {
            $alert = "Something went wrong";
        }

        echo json_encode(array(
            "alert" => $alert,
            "id" => $id,
            "name" => $name
        ));
    }

    public static function delete_menu($post) {
        $menu_id = $post["menu_id"];

        database::query("DELETE FROM `menu_name` WHERE `id`='$menu_id'");

        if (database::query_result()) {
            database::reset();
            database::query("DELETE FROM `menu_content` WHERE `menu_name_id`='$menu_id'");

            if (database::query_result()) {
                database::reset();
                foreach (pluginClass_build_cms_menus_deleteMenu::$delete_menu AS $func) {
                    if (is_callable($func["delete_menu"])) {
                        $func["delete_menu"]->__invoke();
                    }
                }
            }
        }

        header("Location: " . config_url::BASE("/admin/settings/menus"));
    }
}