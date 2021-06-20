<?php

class developer_install {
    public static function install_plugin($install_dir, $get_json) {
        $installer_dir = config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"] . "/scripts/install");
        self::install($installer_dir, $get_json);
    }

    public static function install_cms($migration_name) {
        $installer_dir = config_dir::BUILD_CMS_SYSTEM("/scripts/install");
        $get_json["directory_name"] = $migration_name;
        self::install($installer_dir, $get_json);
    }

    private static function install($installer_dir, $get_json) {
        $installer_array = files::findFiles_toSingleArray(files::findFiles(
            $installer_dir
        ));
        if (!empty($installer_array)) {
            $get_installer_migrations = database::select("SELECT `version` FROM `installer_migrations` WHERE `name`='" . $get_json["directory_name"] . "'");

            $installer_migrations = array();
            if ($get_installer_migrations !== false) {
                foreach ($get_installer_migrations AS $installer_migration) {
                    $installer_migrations[] = $installer_migration;
                }
            }

            foreach ($installer_array AS $installer) {
                $migration = files::findFiles_getFileName($installer)["name"];

                if (!in_array($migration, $installer_migrations)) {
                    require $installer_dir . "/" . $installer;
                    database::query("INSERT INTO `installer_migrations` (`name`, `version`) VALUES ('" . $get_json["directory_name"] . "', '$migration')");
                }
            }
        }
    }
}