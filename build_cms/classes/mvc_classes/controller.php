<?php

class controller {
    private static $head    = array();
    private static $footer  = array();

    public static function getView($file = "", $location = false) {
        if (!is_callable("html_compress")) {
            function html_compress($buf){
                return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buf));
            }
        }

        if (!empty($file)) {
            ob_start("html_compress");
            if ($location === false) {
                require config_dir::VIEW($file);
            }
            else {
                require config_dir::PLUGINDIR($location, DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR . $file);
            }
            ob_end_flush();
        }
    }

    // get view with template
    public static function getAdminTemplateView($file = "", $location = false) {
        self::getAdminHeader();
        self::getView($file, $location);
        self::getAdminFooter();
    }
    // get the header
    public static function getAdminHeader() {
        admin_basicsModal::$version = database::select("SELECT `cms_version` FROM `settings`")[0]["cms_version"];
        self::getView("/admin/admin_basics/header.php");
    }
    // get the footer
    public static function getAdminFooter() {
        self::getView("/admin/admin_basics/footer.php");
    }

    // set functions
    public static function set_head($view_head, $location = false) {
        self::$head[] = config_dir::VIEW($view_head, $location);
    }

    public static function set_footer($view_footer, $location = false) {
        self::$footer[] = config_dir::VIEW($view_footer, $location);
    }

    // get functions
    public static function get_head() {
        foreach (self::$head AS $file) {
            require $file;
        }
    }

    public static function get_footer() {
        foreach (self::$footer AS $file) {
            require $file;
        }
    }
}