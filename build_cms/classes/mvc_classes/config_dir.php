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
        return realpath(__DIR__ . "/../..") . $dir;
        //return __DIR__ . "/../.." . $dir;
    }
    public static function ROUTES($dir = "") {
        return self::BASE("/routes") . $dir;
    }

    public static function PLUGINDIR($location, $dir = "") {
        $location_array = explode(DIRECTORY_SEPARATOR, $location);
        $plugins_dir = count( explode(DIRECTORY_SEPARATOR, self::BASE(DIRECTORY_SEPARATOR . "plugins")) );
        
        $return = "";
        foreach ($location_array AS $key => $value) {
            if ((int)$key === $plugins_dir) {
                $return = $value;
            }
        }

        return self::BASE(DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . $return . $dir);
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