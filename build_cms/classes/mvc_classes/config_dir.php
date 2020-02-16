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
        return __DIR__ . "/../.." . $dir;
    }
    public static function ROUTES($dir = "") {
        return self::BASE("/routes") . $dir;
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