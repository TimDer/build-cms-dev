<?php

class config_dir {
    // directories
    public static function BASE($dir = "") {
        return __DIR__ . "/../../.." . $dir;
    }
    public static function ROUTES($dir = "") {
        return self::BASE("/build_cms/routes") . $dir;
    }
    public static function BUILD_CMS_DIR($dir = "") {
        return __DIR__ . "/../.." . $dir;
    }

    /* ============================== view ============================== */
        public static function VIEW_TEMP($dir = "") {
            return self::BASE("/build_cms/view/template") . $dir;
        }
        public static function VIEW($dir = "") {
            return self::BASE("/build_cms/view") . $dir;
        }
    /* ============================== /view ============================== */
}