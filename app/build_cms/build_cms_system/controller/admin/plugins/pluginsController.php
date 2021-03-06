<?php

class pluginsController extends controller {
    public static function get_plugins_view() {
        pluginsModal::$plugins_array = start_terminal::web_terminal("list-plugin");

        $get_var = user_url::$get_var;
        if (isset($get_var["install_error"])) {
            pluginsModal::$message_class    = "error";
            pluginsModal::$display_message  = files::$file_error_list[(int)$get_var["install_error"]];
        }
        elseif (isset($get_var["file_allowed"])) {
            pluginsModal::$message_class    = "error";
            pluginsModal::$display_message  = "The only allowed file extension is: ." . $get_var["file_allowed"];
        }
        elseif (isset($get_var["installed"])) {
            pluginsModal::$message_class    = "success";
            pluginsModal::$display_message  = 'The instalation of "' . $get_var["installed"] . '" was successful';
        }
        elseif (isset($get_var["is_installed"])) {
            pluginsModal::$message_class    = "success";
            pluginsModal::$display_message  = 'The plugin "' . $get_var["is_installed"] . '" is already installed';
        }

        self::set_head("/admin/plugins/head.php");
        self::set_footer("/admin/plugins/footer.php");
        self::getAdminTemplateView("/admin/plugins/plugins.php");
    }

    public static function install_plugin() {
        $upload_destination     = config_dir::BUILD_CMS_SYSTEM("/data/plugin_upload");

        // Data dir check
        if (!is_dir( config_dir::BUILD_CMS_SYSTEM("/data") )) {
            mkdir( config_dir::BUILD_CMS_SYSTEM("/data") );
        }
        if (!is_dir( $upload_destination )) {
            mkdir( $upload_destination );
        }

        $fileResult = files::upload_to_dir(
            $upload_destination,
            $_FILES['file'],
            array('bcpi'),
            "install"
        );

        if (is_string($fileResult)) {
            $install_plugin = start_terminal::web_terminal("install-plugin " . realpath($upload_destination . DIRECTORY_SEPARATOR . $fileResult));

            unlink( $upload_destination . "/" . $fileResult );

            if ($install_plugin["error_handler"]) {
                $get_var = (empty($plugin_name)) ? "" : "?installed=" . $install_plugin["name"];
            }
            else {
                $get_var = "?is_installed=" . $install_plugin["name"];
            }

            config_dir::deleteDirectory("/build_cms_system/data/plugin_upload");
            header("Location: " . config_url::BASE("/admin/plugins" . $get_var));
        }
        elseif (isset($fileResult["name"])) {
            // error
            header("Location: " . config_url::BASE("/admin/plugins?install_error=" . $fileResult['error']));
        }
        else {
            // files allowed
            header("Location: " . config_url::BASE("/admin/plugins?file_allowed=" . $fileResult[0]));
        }
    }

    public static function delete_plugin() {
        $dir_name = user_url::$new_uri[0];
        
        start_terminal::web_terminal("uninstall-plugin " . $dir_name);
    }

    public static function download_plugin() {
        // Get the file name
        $file_name = user_url::$new_uri[0];
        
        // Zip file to dir name
        $file_with_ext_array = explode(".", $file_name);
        array_pop($file_with_ext_array);
        $dir_name = mysqli_real_escape_string( database::$conn, implode(".", $file_with_ext_array) );

        // Dirs
        $destination = realpath(config_dir::BUILD_CMS_SYSTEM("/data/developer/compile_data"));
        $command_data = start_terminal::web_terminal("compile-plugin $dir_name");

        if ($command_data["error_handler"]) {
            // echo zip file
            header("Content-Type: application/zip");
            echo file_get_contents( $destination . DIRECTORY_SEPARATOR . $command_data["fileName"] );
            unlink( $destination . DIRECTORY_SEPARATOR . $command_data["fileName"] );
        }
        else {
            header("Location: " . config_url::BASE("/admin/plugins"));
        }
    }
}