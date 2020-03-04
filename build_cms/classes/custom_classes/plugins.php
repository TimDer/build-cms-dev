<?php

class plugins {
    // arrays
    public static $main_menu_items = array(
        array(
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
    public static $main_settings_items  = array(
        array(
            "url" => "",
            "name" => ""
        )
    );
    public static $dashboard_widgets = array(
        array(
            "function" => "A_FUNCTION"
        )
    );


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
            // create view/admin folder
            mkdir($plugin_base_dir . "/view/admin");
            // create www-root folder
            mkdir($plugin_base_dir . "/www-root");
            // create www-root/admin folder
            mkdir($plugin_base_dir . "/www-root/admin");
            /* ============================== /create folders ============================== */

            /* ============================== create files ============================== */
            // create classes/pluginClass_{plugin_dir}.php
            files::create_file($plugin_base_dir . "/classes/pluginClass_" . $plugin_dir . ".php");
            // create controller/{plugin_dir}_pluginController.php
            files::create_file($plugin_base_dir . "/controller/" . $plugin_dir . "_pluginController.php");
            // create modal/{plugin_dir}_pluginModal.php
            files::create_file($plugin_base_dir . "/modal/" . $plugin_dir . "_pluginModal.php");

            // create view/admin/menu.php
            files::create_file($plugin_base_dir . "/menu.php");
            // create view/admin/.dirPlaceholder
            files::create_file($plugin_base_dir . "/view/admin/.dirPlaceholder");
            // create www-root/admin/main.css
            files::create_file($plugin_base_dir . "/www-root/admin/main.css");

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

    public static function call_plugin_routes($true_or_false) {
        if ($true_or_false) {
            self::loop_for_files("routes.php");
        }
    }

    public static function call_plugin_definer($true_or_false) {
        if ($true_or_false) {
            self::$main_menu_items = array();
            self::$main_settings_items = array();
            self::$dashboard_widgets = array();
            self::loop_for_files("define.php");
        }
    }

    private static $set_menu_item_loginCheck = false;
    private static $set_menu_item_user_type;
    public static function set_menu_item($id, $name, $url, $user_type = "user") {
        self::$set_menu_item_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_menu_item_user_type, function () {
                self::$set_menu_item_loginCheck = true;
            });
        }, false);
        if (self::$set_menu_item_loginCheck) {
            self::$main_menu_items[$id] = array(
                "url"           => $url,
                "name"          => $name,
                "id"            => $id,
                "class_event"   => "",
            );
        }
        self::$set_menu_item_loginCheck = false;
    }

    private static $set_submenu_item_loginCheck = false;
    private static $set_submenu_item_user_type = false;
    public static function set_submenu_item($id, $name, $url, $user_type = "user") {
        self::$set_submenu_item_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_submenu_item_user_type, function () {
                self::$set_submenu_item_loginCheck = true;
            });
        }, false);
        if ( isset( self::$main_menu_items[$id] ) && self::$set_submenu_item_loginCheck ) {
            self::$main_menu_items[$id]["sub_menu_items"][] = array(
                "url"       => $url,
                "name"      => $name
            );
            self::$main_menu_items[$id]["url"] = "";
            self::$main_menu_items[$id]["class_event"] = " main-menu-click-event";
        }
        self::$set_submenu_item_loginCheck = false;
    }

    private static $set_settings_item_loginCheck = false;
    private static $set_settings_item_user_type;
    public static function set_settings_item($url, $name, $user_type = "user") {
        self::$set_settings_item_user_type = $user_type;
        user_session::check_session("user_id", function () {
            user_session::check_session_permission(self::$set_settings_item_user_type, function () {
                self::$set_settings_item_loginCheck = true;
            });
        }, false);
        if (self::$set_settings_item_loginCheck) {
            self::$main_settings_items[] = array(
                "url" => $url,
                "name" => $name
            );
        }
        self::$set_settings_item_loginCheck = false;
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
}