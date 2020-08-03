<?php

class buildCmsTLAdminController extends controller {
    public static function templateManager() {
        $templates_dir_array = scandir( config_dir::BASE("/templates" ) );

        $id_incrementer = 1;
        $config_data = array();
        foreach ($templates_dir_array AS $template_dir) {
            if ( $template_dir !== "." && $template_dir !== ".." ) {
                $template_infoDir = config_dir::BASE("/templates/" . $template_dir . "/template_info");
                //$config_file = json_decode(file_get_contents($template_infoDir . "/general.json"));
                $config_file = $template_infoDir . "/general.json";

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
                    $config_data[$template_dir]["config"] = json_decode(file_get_contents($config_file), true);
                }
                // or if the csv does not exist
                else {
                    $config_data[$template_dir]["config"]["tem_name"]     = "Unnamed";
                    $config_data[$template_dir]["config"]["author"]       = "No author";
                    $config_data[$template_dir]["config"]["author_url"]   = "No author url";
                }
            }
        }

        build_cms_template_loaderModal::$all_templates = $config_data;

        self::set_head("/admin/template_loader/head_templates.php");
        self::set_footer("/admin/template_loader/footer_templates.php");
        self::getAdminTemplateView("/admin/template_loader/main.php");
    }

    public static function upload_template() {
        if (!is_dir(config_dir::BUILD_CMS_SYSTEM("/data"))) {
            mkdir(config_dir::BUILD_CMS_SYSTEM("/data"), 775);
        }
        if (!is_dir(config_dir::BUILD_CMS_SYSTEM("/data/install_template"))) {
            mkdir(config_dir::BUILD_CMS_SYSTEM("/data/install_template"), 775);
        }
        $zip_template = files::upload_to_dir(
            config_dir::BUILD_CMS_SYSTEM("/data/install_template"),
            $_FILES["new_template"],
            array("zip")
        );

        $zip_name_array = explode(".", $zip_template);
        array_pop($zip_name_array);
        $zip_name = implode(".", $zip_name_array);

        if (is_string($zip_template)) {
            mkdir(config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip"), 775);
            // unzip the file
            $unziped = files::unzip(
                new ZipArchive(),
                config_dir::BUILD_CMS_SYSTEM("/data/install_template/" . $zip_template),
                config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip")
            );

            if ($unziped) {
                $index_unziped_dir = files::findFiles(config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip"));
                if (file_exists(config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip/template_info/general.json"))) {
                    $folder_name = json_decode(file_get_contents(config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip/template_info/general.json")), true)["folder_name"];
                }
                else {
                    $folder_name = $zip_name;
                }
                while (is_dir(config_dir::BASE("/templates/" . $folder_name))) {
                    $randomString = users::create_password_salt(5, 5);
                    if (!is_dir($folder_name . "_" . $randomString)) {
                        $folder_name = $folder_name . "_" . $randomString;
                    }
                }
                mkdir(config_dir::BASE("/templates/" . $folder_name), 775);
                files::copy_dir_contents(
                    config_dir::BUILD_CMS_SYSTEM("/data/install_template/unzip"),
                    config_dir::BASE("/templates/" . $folder_name),
                    $index_unziped_dir
                );
                header("Location: " . config_url::BASE("/admin_submit/template_loader/delete_unzip_folder"));
            }
            else {
                echo "something went terribly wrong";
            }
            unlink(config_dir::BUILD_CMS_SYSTEM("/data/install_template/" . $zip_template));
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
        config_dir::deleteDirectory("/build_cms_system/data/install_template/unzip");
        header("Location: " . config_url::BASE("/admin/settings/template_loader"));
    }

    public static function activate_template() {
        $dir = user_url::$post_var["dir"];

        database::query("DELETE FROM `templates`");
        database::query("INSERT INTO `templates` (`id`, `active_template`) VALUES ('1', '$dir')");

        echo "Success";
    }

    public static function download_template_zip() {
        if ( extension_loaded("zip") ) {
            if (!is_dir(config_dir::BUILD_CMS_SYSTEM("/data"))) {
                mkdir(config_dir::BUILD_CMS_SYSTEM("/data"), 775);
            }
            if (!is_dir(config_dir::BUILD_CMS_SYSTEM("/data/download_zip"))) {
                mkdir(config_dir::BUILD_CMS_SYSTEM("/data/download_zip"), 775);
            }

            $zipName        = user_url::$new_uri[1];
            $folderName     = user_url::$new_uri[0];
            $templatePath   = config_dir::BASE("/templates/" . $folderName);
            $destination    = config_dir::BUILD_CMS_SYSTEM("/data/download_zip");
            
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
        while (is_dir(config_dir::BASE("/templates/" . $template_dir))) {
            $randomString = users::create_password_salt(5, 5);
            if (!is_dir(config_dir::BASE("/templates/" . $template_dir . "_" . $randomString))) {
                $template_dir = $template_dir . "_" . $randomString;
            }
        }
        $Description    = $post["Description"];
        $license        = $post["license"];

        $json_array = json_encode(array(
            "tem_name"      => $post["template_name"],
            "folder_name"   => $template_dir,
            "Author"        => $post["Author"],
            "Author_url"    => $post["Author_url"]
        ), JSON_PRETTY_PRINT);

        // create template folder
        mkdir(config_dir::BASE("/templates/" . $template_dir), 775);
        // create info folder
        mkdir(config_dir::BASE("/templates/" . $template_dir . "/template_info"), 775);

        // create general.json
        file_put_contents(config_dir::BASE("/templates/" . $template_dir . "/template_info/general.json"), $json_array);

        // create info.txt
        $info_file = fopen(config_dir::BASE("/templates/" . $template_dir . "/template_info/info.txt"), "w");
        fwrite($info_file, $Description);
        fclose($info_file);

        // create license.txt
        $license_file = fopen(config_dir::BASE("/templates/" . $template_dir . "/template_info/license.txt"), "w");
        fwrite($license_file, $license);
        fclose($license_file);

        // create index.php, header.php, footer.php, content.php and functions.php
        files::create_file(config_dir::BASE("/templates/" . $template_dir . "/index.php"));
        files::create_file(config_dir::BASE("/templates/" . $template_dir . "/header.php"));
        files::create_file(config_dir::BASE("/templates/" . $template_dir . "/footer.php"));
        files::create_file(config_dir::BASE("/templates/" . $template_dir . "/content.php"));
        files::create_file(config_dir::BASE("/templates/" . $template_dir . "/functions.php"));

        // create www-root dir
        mkdir(config_dir::BASE("/templates/" . $template_dir . "/www-root"), 775);

        // Activate template
        if (isset($post["activate"])) {
            database::query("DELETE FROM `templates`");
            database::query("INSERT INTO `templates` (`id`, `active_template`) VALUES ('1', '$template_dir')");
        }

        header("Location: " . config_url::BASE("/admin/settings/template_loader"));
    }

    public static function delete_template() {
        $active_template_folder = database::select("SELECT `active_template` FROM `templates` WHERE id='1'")[0]["active_template"];

        if ($active_template_folder === user_url::$new_uri[0]) {
            echo "cannot";
        }
        else {
            config_dir::deleteDirectory( "/templates/" . user_url::$new_uri[0] );
            echo "deleted";
        }
    }
}