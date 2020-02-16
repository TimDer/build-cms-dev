<?php

class pluginsController extends controller {
    public static function get_plugins_view() {
        pluginsModal::$plugins_array = database::select("SELECT * FROM `plugins` ORDER BY `name`");

        self::set_head("/admin/plugins/head.php");
        self::set_footer("/admin/plugins/footer.php");
        self::getAdminTemplateView("/admin/plugins/plugins.php");
    }

    public static function delete_plugin() {
        $id = user_url::$new_uri[0];
        
        $sql = database::select("SELECT `directory_name` FROM `plugins` WHERE `pluginID`='$id'");
        database::query("DELETE FROM `plugins` WHERE `pluginID`='$id'");
        config_dir::deleteDirectory("/plugins/" . $sql[0]["directory_name"]);
    }
}