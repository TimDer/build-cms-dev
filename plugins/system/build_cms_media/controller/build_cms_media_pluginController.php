<?php

class build_cms_media_pluginController extends controller {
    /* ============================== Images ============================== */
    public static function load_images() {
        self::set_head("/head_images_downloads.php", __DIR__);
        self::set_footer("/footer_images_downloads.php", __DIR__);

        build_cms_media_pluginModal::$name                  = "images";
        build_cms_media_pluginModal::$display_name          = "Image";
        build_cms_media_pluginModal::$display_name_plural   = "Images";
        
        foreach (user_url::$get_var AS $get_var_key => $get_var) {
            build_cms_media_pluginModal::$get_var[$get_var_key] = explode("/", $get_var);
        }

        if (isset(build_cms_media_pluginModal::$get_var["int_error"])) {
            foreach (build_cms_media_pluginModal::$get_var["int_error"] AS $error_int_key => $error_int_velue) {
                build_cms_media_pluginModal::$get_var["error"][$error_int_key]["error"] = $error_int_velue;
            }
            foreach (build_cms_media_pluginModal::$get_var["data_error"] AS $error_img_key => $error_img_velue) {
                build_cms_media_pluginModal::$get_var["error"][$error_img_key]["data"] = $error_img_velue;
            }
            unset(build_cms_media_pluginModal::$get_var["int_error"]);
            unset(build_cms_media_pluginModal::$get_var["data_error"]);
        }

        if ( isset(user_url::$get_var["int_error"]) || isset(user_url::$get_var["files_allowed"]) ) {
            build_cms_media_pluginModal::$open_error_modal = "open";
        }

        build_cms_media_pluginModal::$data_html = build_cms_media_area_pluginSubController::get_images_html();

        self::getAdminTemplateView("/images_downloads.php", __DIR__);
    }
    /* ============================== /Images ============================== */

    /* ============================== Downloads ============================== */
    public static function load_downloads() {
        self::set_head("/head_images_downloads.php", __DIR__);
        self::set_footer("/footer_images_downloads.php", __DIR__);

        build_cms_media_pluginModal::$name                  = "downloads";
        build_cms_media_pluginModal::$display_name          = "Download";
        build_cms_media_pluginModal::$display_name_plural   = "Downloads";

        foreach (user_url::$get_var AS $get_var_key => $get_var) {
            build_cms_media_pluginModal::$get_var[$get_var_key] = explode("/", $get_var);
        }

        if (isset(build_cms_media_pluginModal::$get_var["int_error"])) {
            foreach (build_cms_media_pluginModal::$get_var["int_error"] AS $error_int_key => $error_int_velue) {
                build_cms_media_pluginModal::$get_var["error"][$error_int_key]["error"] = $error_int_velue;
            }
            foreach (build_cms_media_pluginModal::$get_var["data_error"] AS $error_img_key => $error_img_velue) {
                build_cms_media_pluginModal::$get_var["error"][$error_img_key]["data"] = $error_img_velue;
            }
            unset(build_cms_media_pluginModal::$get_var["int_error"]);
            unset(build_cms_media_pluginModal::$get_var["data_error"]);
        }

        if ( isset(user_url::$get_var["int_error"]) ) {
            build_cms_media_pluginModal::$open_error_modal = "open";
        }

        build_cms_media_pluginModal::$data_html = build_cms_media_area_pluginSubController::get_downloads_html();

        self::getAdminTemplateView("/images_downloads.php", __DIR__);
    }
    /* ============================== /Downloads ============================== */

    /* ============================== data ============================== */
    public static function upload_data($upload_type) {
        if (isset( $_FILES["files"]["name"][0] )) {
            $result = files::upload_multiple_files_to_dir(
                config_dir::PLUGINDIR(__DIR__, "/www-root/" . $upload_type . "s"),
                $_FILES["files"],
                (($upload_type === "image") ? array("jpg", "jpeg", "png", "gif", "svg", "tiff") : "all")
            );
            
            $insert = array();
            $error_array = array();
            $error_files_allowed = "";
            foreach ($result AS $fileResult) {
                if (is_string($fileResult)) {
                    // database
                    $insert[] = "('" . mysqli_real_escape_string(database::$conn, $fileResult) . "', '$upload_type')";
                }
                elseif (isset($fileResult["name"])) {
                    // error
                    $error_array[] = $fileResult;
                }
                else {
                    // Allowed files
                    $error_files_allowed = implode("/", $fileResult);
                }
            }

            $return_error_int   = array();
            $return_error_img   = array();
            foreach ($error_array AS $error) {
                $return_error_int[] = (string)$error["error"];
                $return_error_img[] = $error["name"];
            }
            // upload error return
            $error_return_string = (!empty($error_array)) ? "?data_error=" . implode("/", $return_error_img) . "&int_error=" . implode("/", $return_error_int) : "";

            // Files allowed return error
            $error_return_string .= (!empty($error_files_allowed)) ? ((!empty($error_return_string)) ? "&" : "?") . "files_allowed=" . $error_files_allowed : "";

            if (!empty($insert)) {
                database::query( "INSERT INTO `media` (`the_file_name`, `media_type`) VALUES " . implode(",", $insert) );
            }
            header("Location: " . config_url::BASE("/admin/media/" . $upload_type . "s" . $error_return_string));
        }
        else {
            header("Location: " . config_url::BASE("/admin/media/" . $upload_type . "s"));
        }
    }

    public static function delete_data($delete_type) {
        $id = user_url::$new_uri[0];

        $sql_get = database::select("SELECT `the_file_name` AS `file` FROM `media` WHERE `id`='$id' AND `media_type`='$delete_type'")[0]["file"];

        if ($sql_get !== "") {
            database::query("DELETE FROM `media` WHERE `id`='$id' AND `media_type`='$delete_type'");

            unlink( config_dir::PLUGINDIR(__DIR__, "/www-root/" . $delete_type . "s/" . $sql_get) );
        }

        header( "Location: " . config_url::BASE("/admin/media/" . $delete_type . "s") );
    }
    /* ============================== /data ============================== */
}