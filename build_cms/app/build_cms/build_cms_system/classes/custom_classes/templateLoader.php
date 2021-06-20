<?php

class templateLoader {
    public static $template_dir     = "";
    public static $template_file    = "index.php";

    public static function call_template_definer() {
        $dir_to_file = config_dir::BASE("/templates/" . self::$template_dir . "/define.php");
        if (file_exists($dir_to_file)) {
            require $dir_to_file;
        }
    }

    public static function set_template_file($template = "") {
        self::set_template_base_dir();
        if (!empty($template) && file_exists( config_dir::BASE("/templates/" . self::$template_dir . "/" . $template . "_template.php") )) {
            self::$template_file = $template . "_template.php";
        }
    }

    public static function set_template_base_dir() {
        if (empty(self::$template_dir)) {
            $result = database::select("SELECT `active_template` FROM `templates`");

            $result = ($result !== false) ? $result[0]["active_template"]: array();

            if (empty($result)) {
                self::$template_dir = users::create_password_salt(300, 400);
            }
            else {
                self::$template_dir = $result;
            }
        }
    }

    public static function base_template_dir($dir) {
        return config_dir::BASE("/templates/" . self::$template_dir . $dir);
    }

    public static function get_header($header_file = "") {
        if (empty($header_file)) {
            require config_dir::BASE("/templates/" . self::$template_dir . "/header.php");
        }
        else {
            require config_dir::BASE("/templates/" . self::$template_dir . "/" . $header_file . "_header.php");
        }
        
    }
    public static function get_content($content_file = "") {
        if (empty($content_file)) {
            require config_dir::BASE("/templates/" . self::$template_dir . "/content.php");
        }
        else {
            require config_dir::BASE("/templates/" . self::$template_dir . "/" . $content_file . "_content.php");
        }
    }
    public static function get_footer($footer_file = "") {
        if (empty($footer_file)) {
            require config_dir::BASE("/templates/" . self::$template_dir . "/footer.php");
        }
        else {
            require config_dir::BASE("/templates/" . self::$template_dir . "/" . $footer_file . "_footer.php");
        }
    }

    private static $set_default_head = array();
    public static function set_default_head($function) {
        self::$set_default_head[] = $function;
    }

    public static function load_default_head($charset, $array_to_function = array()) {
        $return = "";

        $return .= "<meta charset='" . $charset . "'>";
        $return .= "<base href='" . config_url::BASE("/") . "'>";

        foreach (self::$set_default_head AS $head) {
            if (is_callable($head)) {
                $return .= $head($array_to_function);
            }
        }

        return $return;
    }
}