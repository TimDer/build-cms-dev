<?php

class templateLoaderFiles {
    public static $template_dir     = "";
    public static $template_file    = "index.php";

    public static function set_template_file($template = "") {
        if (!empty($template)) {
            self::$template_file = $template . "_template.php";
        }
    }

    public static function set_template_base_dir() {
        if (empty(self::$template_dir)) {
            self::$template_dir = database::select("SELECT `folder_name` FROM `templates` WHERE `active_or_inactive`='active'")[0]["folder_name"];
        }
    }

    public static function base_template_dir($dir) {
        return config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . $dir);
    }

    public static function get_header($header_file = "") {
        if (empty($header_file)) {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/header.php");
        }
        else {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/" . $header_file . "_header.php");
        }
        
    }
    public static function get_content($content_file = "") {
        if (empty($content_file)) {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/content.php");
        }
        else {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/" . $content_file . "_content.php");
        }
    }
    public static function get_footer($footer_file = "") {
        if (empty($footer_file)) {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/footer.php");
        }
        else {
            require config_dir::PLUGINDIR(__DIR__, "/view/templates/" . self::$template_dir . "/" . $footer_file . "_footer.php");
        }
    }
}