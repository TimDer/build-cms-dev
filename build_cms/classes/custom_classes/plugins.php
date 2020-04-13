<?php

class plugins {
    // arrays
    public static $main_menu_items = array();
    /*
    Example: main_menu_items
    array(
        "id" => array(
            "url"           => "",
            "name"          => "",
            "id"            => "",
            "class_event"   => "",
            "sub_menu_items" => array(
                array(
                    "url"       => "",
                    "name"      => ""
                )
            )
        )
    );
    */
    public static $dashboard_widgets = array();
    /*
    Example: dashboard_widgets
    array(
        array(
            "function" => function() {}
        )
    );
    */
    public static $building_blocks_area = array();
    /*
    Example: building_blocks_area
    array(
        "id" => array(
            "id" => "value",
            "name" => "value",
            "display_name" => "value"
        )
    )
    */


    public static function create_plugin_folder($plugin_dir) {
        if ( !is_dir( config_dir::BASE("/plugins/" . $plugin_dir) ) ) {
            $plugin_base_dir = config_dir::BASE("/plugins/" . $plugin_dir);

            // create plugin dir
            mkdir($plugin_base_dir);

            /* ============================== create folders ============================== */
            // create classes folder
            mkdir($plugin_base_dir . "/classes");
            // create controller folder
            mkdir($plugin_base_dir . "/controller");
            // create modal folder
            mkdir($plugin_base_dir . "/modal");
            // create view folder
            mkdir($plugin_base_dir . "/view");
            // create www-root folder
            mkdir($plugin_base_dir . "/www-root");
            /* ============================== /create folders ============================== */

            /* ============================== create files ============================== */
            // create classes/pluginClass_{plugin_dir}.php
            files::create_file($plugin_base_dir . "/classes/pluginClass_" . $plugin_dir . ".php");
            // create controller/{plugin_dir}_pluginController.php
            files::create_file($plugin_base_dir . "/controller/" . $plugin_dir . "_pluginController.php");
            // create modal/{plugin_dir}_pluginModal.php
            files::create_file($plugin_base_dir . "/modal/" . $plugin_dir . "_pluginModal.php");

            // create view/admin/.dirPlaceholder
            files::create_file($plugin_base_dir . "/view/.dirPlaceholder");
            // create www-root/admin/main.css
            files::create_file($plugin_base_dir . "/www-root/main.css");

            // create routes.php
            files::create_file($plugin_base_dir . "/routes.php");
            /* ============================== /create files ============================== */
        }
    }

    private static function loop_for_files($file) {
        $plugin_dir_array = scandir( config_dir::BASE( "/plugins" ) );
        foreach ($plugin_dir_array AS $value) {
            if ($value === "." || $value === "..") {
                continue;
            }
            $dir_to_file = config_dir::BASE( "/plugins/" . $value . "/" . $file );
            if ( file_exists( $dir_to_file ) ) {
                require $dir_to_file;
            }
        }
    }

    private static function call_plugin_routes($true_or_false) {
        if ($true_or_false) {
            self::loop_for_files("routes.php");
        }
    }

    private static function call_plugin_definer($true_or_false) {
        if ($true_or_false) {
            self::loop_for_files("define.php");
        }
    }

    public static function call_plugins() {
        self::call_plugin_definer(config::$call_plugin_definer);
        self::call_plugin_routes(config::$call_plugin_routes);
    }

    private static $set_menu_item_loginCheck = false;
    private static $set_menu_item_user_type;
    public static function set_menu_item($id, $display_name, $url, $user_type = "user") {
        self::$set_menu_item_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_menu_item_user_type, function () {
                self::$set_menu_item_loginCheck = true;
            });
        }, false);
        if (self::$set_menu_item_loginCheck) {
            self::$main_menu_items[$id] = array(
                "url"           => $url,
                "name"          => $display_name,
                "id"            => $id,
                "class_event"   => "",
            );
        }
        self::$set_menu_item_loginCheck = false;
    }

    private static $set_submenu_item_loginCheck = false;
    private static $set_submenu_item_user_type = false;
    public static function set_submenu_item($id, $display_name, $url, $user_type = "user") {
        self::$set_submenu_item_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_submenu_item_user_type, function () {
                self::$set_submenu_item_loginCheck = true;
            });
        }, false);
        if ( isset( self::$main_menu_items[$id] ) && self::$set_submenu_item_loginCheck ) {
            self::$main_menu_items[$id]["sub_menu_items"][] = array(
                "url"       => $url,
                "name"      => $display_name
            );
            self::$main_menu_items[$id]["url"] = "";
            self::$main_menu_items[$id]["class_event"] = " main-menu-click-event";
        }
        self::$set_submenu_item_loginCheck = false;
    }

    private static $set_dashboard_widget_loginCheck = false;
    private static $set_dashboard_widget_user_type;
    public static function set_dashboard_widget($user_type, $id, $function) {
        self::$set_dashboard_widget_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_dashboard_widget_user_type, function () {
                self::$set_dashboard_widget_loginCheck = true;
            });
        }, false);
        if (self::$set_dashboard_widget_loginCheck) {
            self::$dashboard_widgets[] = array(
                "function" => $function,
                "id" => $id
            );
        }
        self::$set_dashboard_widget_loginCheck = false;
    }

    private static $set_building_blocks_area_loginCheck = false;
    public static function set_building_blocks_area($id, $name, $display_name, $css_display = "none") {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                self::$set_building_blocks_area_loginCheck = true;
            });
        }, false);

        if (self::$set_building_blocks_area_loginCheck) {
            self::$building_blocks_area[$id] = array(
                "id" => $id,
                "name" => $name,
                "display_name" => $display_name,
                "css_display" => $css_display
            );
        }
        self::$set_building_blocks_area_loginCheck = false;
    }
}