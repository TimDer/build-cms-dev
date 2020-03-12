<?php

class buildCmsTLAdmin_pluginController extends controller {
    public static function templateManager() {
        self::set_head("/admin/head.php", __DIR__);
        self::getAdminTemplateView("/admin/main.php", __DIR__);
    }
}