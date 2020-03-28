<?php

class buildCmsTLAdmin_pluginController extends controller {
    public static function templateManager() {
        $templates_dir_array = scandir( config_dir::PLUGINDIR( __DIR__, "/view/templates" ) );

        $id_incrementer = 1;
        $config_data = array();
        foreach ($templates_dir_array AS $template_dir) {
            if ( $template_dir !== "." && $template_dir !== ".." ) {
                $template_infoDir = config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/template_info");
                $config_file = $template_infoDir . "/general.csv";

                // id
                $config_data[$template_dir]["id"] = (string)$id_incrementer;
                $id_incrementer = $id_incrementer + 1;

                // get license
                if (file_exists($template_infoDir . "/license.txt")) {
                    $config_data[$template_dir]["license"] = file_get_contents($template_infoDir . "/license.txt");
                }
                else {
                    $config_data[$template_dir]["license"] = 'Create a "license.txt" file';
                }

                // get info
                if (file_exists($template_infoDir . "/info.txt")) {
                    $config_data[$template_dir]["info"] = file_get_contents($template_infoDir . "/info.txt");
                }
                else {
                    $config_data[$template_dir]["info"] = 'Create an "info.txt" file';
                }
                
                // get data from csv
                $config_data[$template_dir]["config"]["folder_name"]  = $template_dir;
                if ( file_exists($config_file) ) {
                    $open_config = fopen($config_file, "r");
                    while ($config_raw = fgetcsv($open_config)) {
                        if ($config_raw[0] !== "folder_name") {
                            $config_data[$template_dir]["config"][$config_raw[0]] = $config_raw[1];
                        }
                    }
                }
                // or if the csv does not exist
                else {
                    $config_data[$template_dir]["config"]["tem_name"]     = "Unnamed";
                    $config_data[$template_dir]["config"]["author"]       = "No author";
                    $config_data[$template_dir]["config"]["author_url"]   = "No author url";
                }
            }
        }

        build_cms_template_loader_pluginModal::$all_templates = $config_data;

        self::set_head("/admin/head.php", __DIR__);
        self::set_footer("/admin/footer.php", __DIR__);
        self::getAdminTemplateView("/admin/main.php", __DIR__);
    }

    public static function upload_template() {
        $zip_template = files::upload_to_dir(
            config_dir::PLUGINDIR(__DIR__, "/data/install_template"),
            $_FILES["new_template"],
            array("zip")
        );

        $zip_name_array = explode(".", $zip_template);
        array_pop($zip_name_array);
        $zip_name = implode(".", $zip_name_array);

        if (is_string($zip_template)) {
            mkdir(config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip"), 775);
            // unzip the file
            $unziped = files::unzip(
                new ZipArchive(),
                config_dir::PLUGINDIR(__DIR__, "/data/install_template/" . $zip_template),
                config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip")
            );

            if ($unziped) {
                $index_unziped_dir = files::findFiles(config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip"));
                if (file_exists(config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip/template_info/general.csv"))) {
                    $generalCSV = fopen(config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip/template_info/general.csv"), "r");
                    while ($config_raw = fgetcsv($generalCSV)) {
                        if ($config_raw[0] === "folder_name") {
                            $folder_name = $config_raw[1];
                        }
                    }
                }
                else {
                    $folder_name = $zip_name;
                }
                while (is_dir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $folder_name))) {
                    $randomString = users::create_password_salt(5, 5);
                    if (!is_dir($folder_name . "_" . $randomString)) {
                        $folder_name = $folder_name . "_" . $randomString;
                    }
                }
                mkdir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $folder_name), 775);
                files::copy_dir_contents(
                    config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip"),
                    config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $folder_name),
                    $index_unziped_dir
                );
                header("Location: " . config_url::BASE("/admin_submit/template_loader/delete_unzip_folder"));
            }
            else {
                echo "something went terribly wrong";
            }
            unlink(config_dir::PLUGINDIR(__DIR__, "/data/install_template/" . $zip_template));
        }
        elseif (isset($zip_template["name"])) {
            // something went terribly wrong
            echo "something went terribly wrong (Error: " . $zip_template['error'] . ")";
        }
        else {
            // the only file that is allowed is a zip file
            echo "the only file type that is allowed is a zip file";
        }
    }
    public static function delete_unzip_dir() {
        config_dir::deleteDirectory(config_dir::PLUGINDIR(__DIR__, "/data/install_template/unzip", "ltrim"));
        header("Location: " . config_url::BASE("/admin/settings/td_template_loader"));
    }

    public static function activate_template() {
        $dir = user_url::$post_var["dir"];

        database::query("DELETE FROM `templates`");
        database::query("INSERT INTO `templates` (`id`, `active_template`) VALUES ('1', '$dir')");

        echo "Success";
    }

    public static function download_template_zip() {
        if ( extension_loaded("zip") ) {
            $zipName        = user_url::$new_uri[1];
            $folderName     = user_url::$new_uri[0];
            $templatePath   = config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $folderName);
            $destination    = config_dir::PLUGINDIR(__DIR__, "/data/download_zip");
            
            files::createZipFile(
                $templatePath,
                files::findFiles( $templatePath ),
                $zipName,
                $destination,
                new ZipArchive()
            );

            header("Content-Type: application/zip");
            echo file_get_contents( $destination . DIRECTORY_SEPARATOR . $zipName );
            unlink( $destination . DIRECTORY_SEPARATOR . $zipName );
        }
    }

    public static function create_new_template() {
        $post = user_url::$post_var;

        $template_dir   = preg_replace("/ /", "_", $post["template_dir"]);
        while (is_dir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir))) {
            $randomString = users::create_password_salt(5, 5);
            if (!is_dir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "_" . $randomString))) {
                $template_dir = $template_dir . "_" . $randomString;
            }
        }
        $Description    = $post["Description"];
        $license        = $post["license"];

        $csv_array = array(
            "tem_name" => array(
                "tem_name", $post["template_name"]
            ),
            "folder_name" => array(
                "folder_name", $template_dir
            ),
            "Author" => array(
                "author", $post["Author"]
            ),
            "Author_url" => array(
                "author_url", $post["Author_url"]
            )
        );

        // create template folder
        mkdir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir), 775);
        // create info folder
        mkdir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/template_info"), 775);

        // create general.csv
        $config_file = fopen(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/template_info/general.csv"), "w");
        fputcsv($config_file, $csv_array["tem_name"]);
        fputcsv($config_file, $csv_array["folder_name"]);
        fputcsv($config_file, $csv_array["Author"]);
        fputcsv($config_file, $csv_array["Author_url"]);
        fclose($config_file);

        // create info.txt
        $info_file = fopen(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/template_info/info.txt"), "w");
        fwrite($info_file, $Description);
        fclose($info_file);

        // create license.txt
        $license_file = fopen(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/template_info/license.txt"), "w");
        fwrite($license_file, $license);
        fclose($license_file);

        // create index.php, header.php, footer.php, content.php and functions.php
        files::create_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/index.php"));
        files::create_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/header.php"));
        files::create_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/footer.php"));
        files::create_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/content.php"));
        files::create_file(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/functions.php"));

        // create www-root dir
        mkdir(config_dir::PLUGINDIR(__DIR__, "/view/templates/" . $template_dir . "/www-root"), 775);

        // Activate template
        if (isset($post["activate"])) {
            database::query("DELETE FROM `templates`");
            database::query("INSERT INTO `templates` (`id`, `active_template`) VALUES ('1', '$template_dir')");
        }

        header("Location: " . config_url::BASE("/admin/settings/td_template_loader"));
    }

    public static function delete_template() {
        $active_template_folder = database::select("SELECT `active_template` FROM `templates` WHERE id='1'")[0]["active_template"];

        if ($active_template_folder === user_url::$new_uri[0]) {
            echo "cannot";
        }
        else {
            config_dir::deleteDirectory( config_dir::PLUGINDIR(__DIR__, "/view/templates/" . user_url::$new_uri[0], "ltrim") );
            echo "deleted";
        }
    }
}