<?php

class plugins {
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
}