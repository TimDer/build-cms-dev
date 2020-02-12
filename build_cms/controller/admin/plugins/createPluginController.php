<?php

class createPluginController extends controller {
    public static function get_create_plugins_view() {
        pluginsModal::$plugins_array = database::select("SELECT `description`, `name` FROM `plugins`");

        self::set_head("/admin/createPlugin/head.php");
        self::getAdminTemplateView("/admin/createPlugin/create.php");
    }
}