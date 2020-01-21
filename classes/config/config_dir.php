<?php

class config_dir {
    // directories
    public static function BASE($dir = "") {
        return __DIR__ . "/../.." . $dir;
    }
    public static function ROUTES($dir = "") {
        return self::BASE("/routes") . $dir;
    }
    public static function CONTROLLER($dir = "") {
        return self::BASE("/controller") . $dir;
    }
    public static function CLASSES($dir = "") {
        return self::BASE("/classes") . $dir;
    }

    /* ============================== view ============================== */
        public static function VIEW_TEMP($dir = "") {
            return self::BASE("/view/template") . $dir;
        }
        public static function VIEW($dir = "") {
            return self::BASE("/view") . $dir;
        }
    /* ============================== /view ============================== */
}