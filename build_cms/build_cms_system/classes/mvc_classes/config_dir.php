<?php

class config_dir {
    // delete directories
    public static function deleteDirectory($dir) {
        if (!is_callable("rmDirectory")) {
            function rmDirectory($dir) {
                if (!file_exists($dir)) {
                    return true;
                }
            
                if (!is_dir($dir)) {
                    return unlink($dir);
                }
                
                foreach (scandir($dir) as $item) {
                    if ($item == '.' || $item == '..') {
                        continue;
                    }
            
                    if (!rmDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                        return false;
                    }
            
                }
    
                return rmdir($dir);
            }
        }
        
        rmDirectory(self::BASE($dir));
    }

    // directories
    public static function BASE($dir = "") {
        return realpath($GLOBALS["dir_to_build_cms"]) . $dir;
    }
    public static function BUILD_CMS_SYSTEM($dir = "") {
        return self::BASE(DIRECTORY_SEPARATOR . "build_cms_system" . $dir);
    }
    public static function ROUTES($dir = "") {
        return self::BUILD_CMS_SYSTEM(DIRECTORY_SEPARATOR . "routes") . $dir;
    }
    public static function ROOT_DIR($dir = "") {
        return realpath($GLOBALS["index_root_dir"]) . $dir;
    }

    private static function escape_dir($dir) {
        return preg_replace(array("/\\\\/", "/\//", "/:/"), array("\\\\\\", "\/", "\\:"), $dir);
    }
    public static function PLUGINDIR($location, $dir = "", $type = "fullPath") {
        // sys and plugin folder
        $BASE_plugins_dir   = self::BASE(DIRECTORY_SEPARATOR . "plugins");
        $SYS_plugin_dir     = self::BUILD_CMS_SYSTEM(DIRECTORY_SEPARATOR . "system");

        // location to array
        $location_array = explode(DIRECTORY_SEPARATOR, $location);

        // plugin folder check
        if (preg_match("/^" . self::escape_dir($SYS_plugin_dir) . "/", $location)) {
            $instalation_dir = "build_cms_system/system";
            $plugins_dir = count( explode(DIRECTORY_SEPARATOR, $SYS_plugin_dir) );
        }
        else {
            $instalation_dir = "plugins";
            $plugins_dir = count( explode(DIRECTORY_SEPARATOR, $BASE_plugins_dir) );
        }
        
        // get plugin dir name
        $return = "";
        foreach ($location_array AS $key => $value) {
            if ((int)$key === $plugins_dir) {
                $return = $value;
            }
        }

        // return dir
        if ($type === "fullPath") {
            return self::BASE(DIRECTORY_SEPARATOR . $instalation_dir . DIRECTORY_SEPARATOR . $return . $dir);
        }
        elseif ($type === "ltrim") {
            return DIRECTORY_SEPARATOR . $instalation_dir . DIRECTORY_SEPARATOR . $return . $dir;
        }
    }

    /* ============================== view ============================== */
        public static function VIEW($dir = "", $location = false) {
            if ($location === false) {
                return self::BUILD_CMS_SYSTEM("/view") . $dir;
            }
            else {
                return self::PLUGINDIR($location, "/view" . $dir);
            }
        }
    /* ============================== /view ============================== */
}