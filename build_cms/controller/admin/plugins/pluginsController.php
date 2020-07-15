<?php

class pluginsController extends controller {
    public static function get_plugins_view() {
        pluginsModal::$plugins_array = database::select("SELECT * FROM `plugins` ORDER BY `name`");

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
        $upload_destination     = config_dir::BASE("/data/plugin_upload");
        $install_destination    = config_dir::BASE("/plugins");

        // Data dir check
        if (!is_dir( config_dir::BASE("/data") )) {
            mkdir( config_dir::BASE("/data") );
        }
        if (!is_dir( $upload_destination )) {
            mkdir( $upload_destination );
        }

        $fileResult = files::upload_to_dir(
            $upload_destination,
            $_FILES['file'],
            array('bcpi')
        );

        if (is_string($fileResult)) {
            // Create unzip dir
            $unzip_dir = config_dir::BASE("/data/plugin_unzip");
            mkdir( $unzip_dir, 775 );
            $unzip = files::unzip(
                new ZipArchive(),
                $upload_destination . "/" . $fileResult,
                $unzip_dir
            );

            if ($unzip) {
                $index_new_plugin_folder = files::findFiles( $unzip_dir );

                $get_json = json_decode( file_get_contents($unzip_dir . "/plugin_data.json"), true );

                if (!is_dir( config_dir::BASE("/plugins/" . $get_json["directory_name"]) )) {
                    mkdir( config_dir::BASE("/plugins/" . $get_json["directory_name"]), 775 );
                    files::copy_dir_contents(
                        $unzip_dir,
                        $install_destination . "/" . $get_json["directory_name"],
                        $index_new_plugin_folder
                    );

                    $plugin_name        = $get_json["name"];
                    $plugin_dir         = $get_json["directory_name"];
                    $plugin_description = $get_json["description"];

                    database::query("INSERT INTO `plugins` (`name`, `directory_name`, `description`) VALUES ('$plugin_name', '$plugin_dir', '$plugin_description')");
                    unlink( $install_destination . "/" . $plugin_dir . "/plugin_data.json" );
                    $install_file = $install_destination . "/" . $plugin_dir . "/scripts/install.php";
                    if ($install_file) {
                        require $install_file;
                    }
                }
                else {
                    config_dir::deleteDirectory("/data/plugin_unzip");
                    unlink( $upload_destination . "/" . $fileResult );
                    header("Location: " . config_url::BASE("/admin/plugins?is_installed=" . $get_json["name"]));
                    die();
                }
            }

            config_dir::deleteDirectory("/data/plugin_unzip");
            unlink( $upload_destination . "/" . $fileResult );
            $get_var = (empty($plugin_name)) ? "" : "?installed=" . $plugin_name;
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
        $id = user_url::$new_uri[0];
        
        $sql = database::select("SELECT `directory_name` FROM `plugins` WHERE `pluginID`='$id'");
        database::query("DELETE FROM `plugins` WHERE `pluginID`='$id'");

        // run plugin Uninstaller
        $delete_script = config_dir::BASE("/plugins/" . $sql[0]["directory_name"] . "/scripts/delete.php");
        if (file_exists($delete_script)) {
            require $delete_script;
        }

        config_dir::deleteDirectory("/plugins/" . $sql[0]["directory_name"]);
    }

    public static function download_plugin() {
        // Get the file name
        $file_name = user_url::$new_uri[0];
        
        // Zip file to dir name
        $file_with_ext_array = explode(".", $file_name);
        array_pop($file_with_ext_array);
        $dir_name = mysqli_real_escape_string( database::$conn, implode(".", $file_with_ext_array) );

        // Dirs
        $filePath = config_dir::BASE("/plugins/" . $dir_name);
        $destination = config_dir::BASE("/data/plugin_download");

        if (is_dir( $filePath )) {
            // Data dir check
            if (!is_dir( config_dir::BASE("/data") )) {
                mkdir( config_dir::BASE("/data") );
            }
            if (!is_dir( $destination )) {
                mkdir( $destination );
            }

            // get json data
            $plugin_database = database::select("SELECT `name`, `directory_name`, `description` FROM `plugins` WHERE `directory_name`='$dir_name'")[0];
            $json_plugin = json_encode($plugin_database, JSON_PRETTY_PRINT);

            // json to file
            $json_put_file = config_dir::BASE("/plugins/" . $dir_name . "/plugin_data.json");
            file_put_contents($json_put_file, $json_plugin);

            // Create zip file
            files::createZipFile(
                $filePath,
                files::findFiles( $filePath ),
                $file_name,
                $destination,
                new ZipArchive()
            );

            // Delete json file
            unlink( $json_put_file );

            // echo zip file
            header("Content-Type: application/zip");
            echo file_get_contents( $destination . DIRECTORY_SEPARATOR . $file_name );
            unlink( $destination . DIRECTORY_SEPARATOR . $file_name );
        }
    }
}