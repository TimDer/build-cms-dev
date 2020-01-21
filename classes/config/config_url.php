<?php

class config_url {
    // url variables
    private static $uri_dir;
    private static $admin_uri;

    // set url variables
    public static function set_url_dir($dir = "") {
        self::$uri_dir = $dir;
    }
    public static function set_admin_uri($dir = "") {
        self::$admin_uri = $dir;
    }

    // set the protocol of the url
    public static function protocol() {
        if (isset($_SERVER['HTTPS'])) {
            $PROTOCOL = 'https://';
        } else {
            $PROTOCOL = 'http://';
        }
        return $PROTOCOL;
    }
    // set the domain name
    public static function domain() {
        return $_SERVER['HTTP_HOST'];
    }
    public static function url_dir() {
        return self::$uri_dir;
    }

    // urls
    public static function BASE($url = "") {
        return self::protocol() . self::domain() . self::url_dir() . $url;
    }

    /* ============================== view ============================== */
        public static function VIEW_TEMP($url = "") {
            return self::BASE("/view/template" . $url);
        }
        public static function VIEW($url = "") {
            return self::BASE("/view" . $url);
        }
    /* ============================== /view ============================== */
}