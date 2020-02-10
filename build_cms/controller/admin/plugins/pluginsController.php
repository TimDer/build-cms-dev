<?php

class pluginsController extends controller {
    public static function get_plugins_view() {
        self::set_head("/admin/plugins/head.php");
        self::getAdminTemplateView("/admin/plugins/plugins.php");
    }
}