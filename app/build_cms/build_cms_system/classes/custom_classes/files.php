<?php

class files {
    public static $file_error_list = array(
        0 => "There is no error, the file uploaded with success.",
        1 => "The uploaded file exceeds the \"upload_max_filesize\" directive in php.ini.",
        2 => "The uploaded file exceeds the \"MAX_FILE_SIZE\" directive that was specified in the HTML form.",
        3 => "The uploaded file was only partially uploaded.",
        4 => "No file was uploaded.",
        6 => "Missing a temporary folder. Introduced in PHP 5.0.3.",
        7 => "Failed to write file to disk. Introduced in PHP 5.1.0.",
        8 => "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with \"phpinfo()\" may help. Introduced in PHP 5.2.0.",
    );

    public static function create_file($dir_file) {
        $create = fopen($dir_file, "w");
        fclose($create);
    }

    private static function prepare_files_array($files_array) {
        $fix_array = array();

        foreach ($files_array AS $root_key => $root_value) {
            foreach ($root_value AS $theFile_key => $theFile_value) {
                $fix_array[$theFile_key][$root_key] = $theFile_value;
            }
        }

        return $fix_array;
    }

    public static function upload_multiple_files_to_dir($to_dir, $file_array, $fileAlloued_array, $customFileName = false) {
        $fix_file_array = self::prepare_files_array($file_array);
        
        $return = array();
        foreach ($fix_file_array AS $file) {
            $return[] = self::upload_to_dir($to_dir, $file, $fileAlloued_array, $customFileName);
        }

        return $return;
    }

    public static function upload_to_dir($to_dir, $file_array, $fileAlloued_array, $customFileName = false) {
        $fileName   = $file_array['name'];
        $fileTmpDir = $file_array['tmp_name'];
        $fileError  = $file_array['error'];

        foreach ($fileAlloued_array AS $ext_key => $ext) {
            $fileAlloued_array[$ext_key] = strtolower((string)$ext);
        }

        $fileExt            = explode('.', $fileName);
        $fileActualExt      = end($fileExt);

        if ( in_array(strtolower($fileActualExt), $fileAlloued_array) OR $fileAlloued_array === "all" ) {
            if ($fileError === 0) {
                if (is_string($customFileName)) {
                    move_uploaded_file($fileTmpDir, $to_dir . "/" . $customFileName . "." . $fileActualExt);
                    return (string)$customFileName . "." . $fileActualExt;
                }
                else {
                    move_uploaded_file($fileTmpDir, $to_dir . "/" . $fileName);
                    return (string)$fileName;
                }
            }
            else {
                return $file_array;
            };
        }
        else {
            return $fileAlloued_array;
        }
    }

    private static $findFiles_toSingleArray_ARRAY = array();
    private static function loop_findFiles_toSingleArray($dir_array, $in_dir) {
        foreach ($dir_array AS $item_key => $item) {
            if (is_numeric($item_key)) {
                if (is_numeric($item_key) && isset( $dir_array[$item] )) {
                    // is a directory
                    if ($dir_array[$item] !== "empty_folder") {
                        self::loop_findFiles_toSingleArray($dir_array[$item], ( (!empty($in_dir)) ? $in_dir . DIRECTORY_SEPARATOR . $item : $item ));
                    }
                }
                else {
                    // is a file
                    self::$findFiles_toSingleArray_ARRAY[] = (!empty($in_dir)) ? $in_dir . DIRECTORY_SEPARATOR . $item : $item;
                }
            }
        }
    }
    public static function findFiles_toSingleArray($dir_array) {
        self::loop_findFiles_toSingleArray($dir_array, $in_dir = "");
        return self::$findFiles_toSingleArray_ARRAY;
    }
    public static function findFiles($dir) {
        $return = array();

        foreach (scandir($dir) AS $item) {
            if ( $item !== "." && $item !== ".." ) {
                $return[] = $item;
            }
            
            if ( is_dir($dir . DIRECTORY_SEPARATOR . $item) && $item !== "." && $item !== ".." ) {
                if (count(scandir($dir . DIRECTORY_SEPARATOR . $item)) > 2) {
                    $return[$item] = self::findFiles($dir . DIRECTORY_SEPARATOR . $item);
                }
                else {
                    $return[$item] = "empty_folder";
                }
            }
        }

        return $return;
    }

    private static function createZipFile_loop($zipLibrary, $dir, $array, $zip_dir = "") {
        foreach ($array AS $key => $item) {
            if (is_numeric($key)) {
                // put the files in a folder
                if (isset($array[$item])) {
                    // folder
                    $zipLibrary->addEmptyDir($zip_dir . $item);
                    if ( is_array($array[$item]) ) {
                        self::createZipFile_loop($zipLibrary, $dir . "/" . $item, $array[$item], $zip_dir . $item . "/");
                    }
                }
                else {
                    // file
                    $zipLibrary->addFile($dir . "/" . $item, $zip_dir . $item);
                }
            }
        }
    }
    public static function createZipFile($dir, $array, $zipName, $destination, $zipLibrary) {
        if ( $zipLibrary->open($destination . "/" . $zipName, ZipArchive::CREATE) === true ) {
            self::createZipFile_loop($zipLibrary, $dir, $array);
            $zipLibrary->close();
        }
    }

    public static function unzip($zipLibrary, $zip_file, $destination) {
        if ($zipLibrary->open($zip_file)) {
            $zipLibrary->extractTo($destination);
            $zipLibrary->close();
            return true;
        }
        else {
            return false;
        }
    }

    public static function copy_dir_contents($dir, $destination, $array) {
        foreach ($array AS $key => $item) {
            if (is_numeric($key)) {
                if (isset($array[$item])) {
                    // loop through the dir
                    mkdir($destination . "/" . $item, 775);
                    if (is_array($array[$item])) {
                        self::copy_dir_contents($dir . "/" . $item, $destination . "/" . $item, $array[$item]);
                    }
                }
                else {
                    // copy to destination
                    copy(
                        $dir . "/" . $item,
                        $destination . "/" . $item
                    );
                }
            }
        }
    }
}