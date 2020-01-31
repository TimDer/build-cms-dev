<?php

class config_url {
    // url variables
    private static $uri_dir;
    private static $trusted_domains = array();
    private static $trusted_protocol = "";

    // set url variables
    public static function set_url_dir($dir = "") {
        self::$uri_dir = $dir;
    }
    public static function setTrustedDomain($domain = "") {
        self::$trusted_domains[] = $domain;
    }
    public static function useHttps($protocol = false) {
        //"https://"
        if ($protocol) {
            self::$trusted_protocol = "https://";
        }
        else {
            self::$trusted_protocol = "http://";
        }
    }
    public static function displayUntrustedDomain($display = false) {
        if ($display) {
            $result = false;
            $trusted = false;
            foreach (self::$trusted_domains AS $value_domain) {
                if ( (self::$trusted_protocol !== self::protocol() OR $value_domain !== self::domain()) AND self::$trusted_protocol === "https://" ) {
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
                if (count(self::$trusted_domains) === 1) {
                    header("Location: " . self::$trusted_protocol . self::$trusted_domains[0] . $_SERVER["REQUEST_URI"]);
                }

                echo "Your URL: " . self::protocol() . self::domain() . $_SERVER["REQUEST_URI"] . "<br><br>";

                echo "This domain or protocol is not trusted please use the following links<br><br>";

                $url = "";
                foreach (self::$trusted_domains AS $value) {
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

    /* ============================== view ============================== */
        public static function VIEW_TEMP($url = "") {
            return self::BASE("/build_cms/view/template" . $url);
        }
        public static function VIEW($url = "") {
            return self::BASE("/get_data" . $url);
        }
    /* ============================== /view ============================== */
}