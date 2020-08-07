<?php

class createPluginController extends controller {
    public static function get_view() {
        self::set_head("/admin/createPlugin/head.php");
        self::set_footer("/admin/createPlugin/footer.php");
        self::getAdminTemplateView("/admin/createPlugin/create.php");
    }

    public static function submit() {
        if ( isset(user_url::$post_var["plugin_name"]) AND isset(user_url::$post_var["directory_name"]) and isset(user_url::$post_var["description"]) ) {
            $plugin_name    = user_url::$post_var["plugin_name"];
            $directory_name = user_url::$post_var["directory_name"];
            $description    = user_url::$post_var["description"];

            $command_data = start_terminal::web_terminal("new-plugin", array(
                "name" => $plugin_name,
                "dir" => $directory_name,
                "description" => $description,
                "version" => "1.0"
            ));

            if ( $command_data ) {
                echo "The plugin has been created";
            }
            else {
                echo "Plugin already exists";
            }
        }
    }
}