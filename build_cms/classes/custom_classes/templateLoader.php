<?php

class templateLoader {
    public static $template_dir     = "";
    public static $template_file    = "index.php";

    public static function call_template_definer() {
        $dir_to_file = config_dir::BASE("/view/templates/" . self::$template_dir . "/define.php");
        if (file_exists($dir_to_file)) {
            require $dir_to_file;
        }
        /*$plugin_dir_array = scandir( config_dir::BASE( "/plugins" ) );
        foreach ($plugin_dir_array AS $value) {
            if ($value === "." || $value === "..") {
                continue;
            }
            $dir_to_file = config_dir::BASE( "/plugins/" . $value . "/" . $file );
            if ( file_exists( $dir_to_file ) ) {
                require $dir_to_file;
            }
        }*/
    }

    public static function set_template_file($template = "") {
        if (!empty($template)) {
            self::$template_file = $template . "_template.php";
        }
    }

    public static function set_template_base_dir() {
        if (empty(self::$template_dir)) {
            $result = database::select("SELECT `active_template` FROM `templates`")[0]["active_template"];
            if (empty($result)) {
                self::$template_dir = users::create_password_salt(300, 400);
            }
            else {
                self::$template_dir = $result;
            }
        }
    }

    public static function base_template_dir($dir) {
        return config_dir::BASE("/view/templates/" . self::$template_dir . $dir);
    }

    public static function get_header($header_file = "") {
        if (empty($header_file)) {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/header.php");
        }
        else {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/" . $header_file . "_header.php");
        }
        
    }
    public static function get_content($content_file = "") {
        if (empty($content_file)) {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/content.php");
        }
        else {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/" . $content_file . "_content.php");
        }
    }
    public static function get_footer($footer_file = "") {
        if (empty($footer_file)) {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/footer.php");
        }
        else {
            require config_dir::BASE("/view/templates/" . self::$template_dir . "/" . $footer_file . "_footer.php");
        }
    }

    public static function set_building_blocks_area($id, $name, $display_name, $css_display = "none") {
        plugins::set_building_blocks_area($id, $name, $display_name, $css_display);
    }
}