<?php

class config_url {
    // url variables
    private static $uri_dir;
    private static $trusted_protocol = "";

    // set url variables
    private static function set_url_dir($dir = "") {
        self::$uri_dir = $dir;
    }
    private static function useHttps($protocol = false) {
        //"https://"
        if ($protocol) {
            self::$trusted_protocol = "https://";
        }
        else {
            self::$trusted_protocol = "http://";
        }
    }
    public static function displayUntrustedDomain() {
        self::set_url_dir(config::get_config()["domainDir"]);
        self::useHttps(config::get_config()["useHttps"]);
        if (config::get_config()["displayUntrustedDomain"]) {
            $result = false;
            $trusted = false;
            foreach (config::get_config()["TrustedDomains"] AS $value_domain) {
                if ( (self::$trusted_protocol !== self::protocol() AND self::$trusted_protocol === "https://") OR ($value_domain !== self::domain()) ) {
                    if (!$trusted) {
                        $result = true;
                    }
                }
                else {
                    $result = false;
                    $trusted = true;
                }
            }
            
            if ($result) {
                if (count(config::get_config()["TrustedDomains"]) === 1) {
                    header("Location: " . self::$trusted_protocol . config::get_config()["TrustedDomains"][0] . $_SERVER["REQUEST_URI"]);
                }

                echo "Your URL: " . self::protocol() . self::domain() . $_SERVER["REQUEST_URI"] . "<br><br>";

                echo "This domain or protocol is not trusted please use the following links<br><br>";

                $url = "";
                foreach (config::get_config()["TrustedDomains"] AS $value) {
                    $url = self::$trusted_protocol . $value . $_SERVER["REQUEST_URI"];
                    echo '<a href="' . $url . '">' . $url . '</a>' . '<br>';
                }
                die();
            }
        }
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

    public static function TEMPLATE($url = "") {
        return self::BASE("/template" . $url);
    }

    /* ============================== view ============================== */
        public static function VIEW($url = "") {
            return self::BASE("/view" . $url);
        }
    /* ============================== /view ============================== */
}