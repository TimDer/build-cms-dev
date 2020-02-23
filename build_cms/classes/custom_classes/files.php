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
}