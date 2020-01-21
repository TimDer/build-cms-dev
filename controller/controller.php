<?php

class controller {
    private static $head    = NULL;
    private static $footer  = NULL;

    public static function getView($file = "") {
        if (!empty($file)) {
            require config_dir::VIEW($file);
        }
    }

    // set functions
    public static function set_head($view_head) {
        self::$head = config_dir::VIEW("/" . $view_head);
    }

    public static function set_footer($view_footer) {
        self::$footer = config_dir::VIEW("/" . $view_footer);
    }

    // get functions
    public static function get_head() {
        if (self::$head !== NULL) {
            require self::$head;
        }
    }

    public static function get_footer() {
        if (self::$footer !== NULL) {
            require self::$footer;
        }
    }
}