<?php

class plugins {
    private static function create_file($dir_file) {
        $create = fopen($dir_file, "w");
        fclose($create);
    }

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
            self::create_file($plugin_base_dir . "/classes/pluginClass_" . $plugin_dir . ".php");
            // create controller/{plugin_dir}_pluginController.php
            self::create_file($plugin_base_dir . "/controller/" . $plugin_dir . "_pluginController.php");
            // create modal/{plugin_dir}_pluginModal.php
            self::create_file($plugin_base_dir . "/modal/" . $plugin_dir . "_pluginModal.php");

            // create view/admin/menu.php
            self::create_file($plugin_base_dir . "/view/admin/menu.php");
            // create www-root/admin/main.css
            self::create_file($plugin_base_dir . "/www-root/admin/main.css");

            // create routes.php
            self::create_file($plugin_base_dir . "/routes.php");
            /* ============================== /create files ============================== */
        }
    }
}