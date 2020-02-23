<?php

class files {
    public static function create_file($dir_file) {
        $create = fopen($dir_file, "w");
        fclose($create);
    }

    public static function upload_to_dir($to_dir, $file_array, $fileAlloued_array) {
        $fileName   = $file_array['name'];
        $fileTmpDir = $file_array['tmp_name'];
        $fileError  = $file_array['error'];

        $fileExt            = explode('.', $fileName);
        $fileActualExt      = end($fileExt);
        array_pop($fileExt);
        $fileNameWithoutExt = implode(".", $fileExt);

        if ( in_array($fileActualExt, $fileAlloued_array) ) {
            if ($fileError === 0) {
                move_uploaded_file($fileTmpDir, $to_dir . $fileName);
                return (string)$fileNameWithoutExt;
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