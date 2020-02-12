<?php

class pluginsController extends controller {
    public static function get_plugins_view() {
        pluginsModal::$plugins_array = database::select("SELECT `description`, `name` FROM `plugins`");

        self::set_head("/admin/plugins/head.php");
        self::getAdminTemplateView("/admin/plugins/plugins.php");
    }
}