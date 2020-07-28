<?php

class config {
    private static $json_config = array();

    public static function get_config() {
        self::set_config();
        return self::$json_config;
    }

    public static function reload_config() {
        self::set_config(true);
    }

    private static function set_config($reload = false) {
        if (empty(self::$json_config) || $reload) {
            self::$json_config = self::string_to_int(
                json_decode(
                    file_get_contents(
                        config_dir::BUILD_CMS_SYSTEM("/data/config.json")
                    ),
                    true
                )
            );
        }
    }

    private static function string_to_int($array) {
        $return = array();

        foreach ($array AS $key => $value) {
            $new_key            = (is_numeric($key)) ? (int)$key : $key;
            $return[$new_key]   = (is_array($value)) ? self::string_to_int($value) : $value;
        }

        return $return;
    }

    public static function start_cms() {
        // set the base url
        config_url::displayUntrustedDomain();

        // connect to the database
        database::connect();

        // Create dashboard menu
        plugins::set_menu_item("system-dashboard", "Dashboard", "/admin/dashboard", "user");

        // Create settings menu
        plugins::set_menu_item("system-settings", "Settings", "", "author");
        plugins::set_submenu_item("system-settings", "General", "/admin/settings/general", "admin");

        // query the template folder name from the database
        templateLoader::set_template_base_dir();

        // call plugin definer and routes
        plugins::call_plugins();

        // call template definer
        templateLoader::call_template_definer();

        // set template loader link in settings menu
        plugins::set_submenu_item("system-settings", "Templates", "/admin/settings/template_loader", "admin");

        // Create plugins menu
        users::is_developer(function () {
            plugins::set_menu_item("system-plugins", "Plugins", "", "admin");
            plugins::set_submenu_item("system-plugins", "Create a new plugin", "/admin/plugins/create", "admin");
            plugins::set_submenu_item("system-plugins", "Plugins", "/admin/plugins", "admin");
        },
        function () {
            plugins::set_menu_item("system-plugins", "Plugins", "/admin/plugins", "admin");
        });

        // set settings to the end of the array
        if (isset(plugins::$main_menu_items["system-settings"])) {
            $settings = plugins::$main_menu_items["system-settings"];
            unset(plugins::$main_menu_items["system-settings"]);
            plugins::$main_menu_items["system-settings"] = $settings;
        }

        // set users to the end of the array
        plugins::set_submenu_item("system-settings", "Users", "/admin/settings/users", "admin");
    }
}