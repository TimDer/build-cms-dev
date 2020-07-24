<?php

class createPluginController extends controller {
    public static function get_view() {
        pluginsModal::$plugins_array = database::select("SELECT `description`, `name` FROM `plugins`");

        self::set_head("/admin/createPlugin/head.php");
        self::set_footer("/admin/createPlugin/footer.php");
        self::getAdminTemplateView("/admin/createPlugin/create.php");
    }

    public static function submit() {
        if ( isset(user_url::$post_var["plugin_name"]) AND isset(user_url::$post_var["directory_name"]) and isset(user_url::$post_var["description"]) ) {
            $plugin_name    = user_url::$post_var["plugin_name"];
            $directory_name = user_url::$post_var["directory_name"];
            $description    = user_url::$post_var["description"];

            if ( is_dir( config_dir::BASE("/plugins/" . $directory_name) ) ) {
                echo "Plugin already exists";
            }
            else {
                // -------------------------------------------
                // Plugin does not exist ( create the plugin )
                // -------------------------------------------
                plugins::create_plugin_folder($directory_name);
                database::query("INSERT INTO `plugins` (`name`,
                                                        `directory_name`,
                                                        `description`)
                                                VALUES ('$plugin_name',
                                                        '$directory_name',
                                                        '$description')");
                echo "The plugin has been created";
            }
        }
    }
}