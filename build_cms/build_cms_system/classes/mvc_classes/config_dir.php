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
        return self::BUILD_CMS_SYSTEM("/routes") . $dir;
    }
    public static function ROOT_DIR($dir = "") {
        return realpath($GLOBALS["index_root_dir"]) . $dir;
    }

    public static function PLUGINDIR($location, $dir = "", $type = "fullPath") {
        $location_array = explode(DIRECTORY_SEPARATOR, $location);
        $plugins_dir = count( explode(DIRECTORY_SEPARATOR, self::BASE(DIRECTORY_SEPARATOR . "plugins")) );
        
        $return = "";
        foreach ($location_array AS $key => $value) {
            if ((int)$key === $plugins_dir) {
                $return = $value;
            }
        }

        if ($type === "fullPath") {
            return self::BASE(DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . $return . $dir);
        }
        elseif ($type === "ltrim") {
            return DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . $return . $dir;
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