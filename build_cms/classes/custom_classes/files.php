<?php

class files {
    public static function create_file($dir_file) {
        $create = fopen($dir_file, "w");
        fclose($create);
    }

    public static function upload_to_dir($to_dir, $file_array, $fileAlloued_array, $customFileName = false) {
        $fileName   = $file_array['name'];
        $fileTmpDir = $file_array['tmp_name'];
        $fileError  = $file_array['error'];

        $fileExt            = explode('.', $fileName);
        $fileActualExt      = end($fileExt);

        if ( in_array($fileActualExt, $fileAlloued_array) ) {
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
                        self::createZipFile_loop($zipLibrary, $dir . "/" . $item, $array[$item], $item . "/");
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