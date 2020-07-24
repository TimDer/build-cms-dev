<?php

class developer_main {
    public static $argv_accepted_array = array(
        // plugin
        "new-plugin",
        "install-plugin",
        "uninstall-plugin",

        // compilers
        "compile-plugin",

        // config
        "re-config",

        // history
        "reset-history"
    );

    public static function new_plugin($mode = "cli") {
        $plugin_create_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "system" : "plugins";
        
        if ($mode === "cli") {
            $plugin_name        = readline("Plugin name: ");
            $plugin_dir         = readline("Plugin dir (Spaces are NOT allowed): ");
            $plugin_description = readline("Plugin description: ");
            $plugin_version     = readline("Plugin version: ");
        }
        elseif ($mode === "web") {
            $plugin_name        = (isset($GLOBALS["readline"]["name"])) ? $GLOBALS["readline"]["name"] : "";
            $plugin_dir         = (isset($GLOBALS["readline"]["dir"])) ? $GLOBALS["readline"]["dir"] : "";
            $plugin_description = (isset($GLOBALS["readline"]["description"])) ? $GLOBALS["readline"]["description"] : "";
            $plugin_version     = (isset($GLOBALS["readline"]["version"])) ? $GLOBALS["readline"]["version"] : "";
        }

        $plugin_dir = preg_replace("/ /", "_", $plugin_dir);

        if ( (!empty($plugin_name) && !empty($plugin_dir) && !empty($plugin_description)) || (in_array("-s", $GLOBALS["commandToArgv"])) ) {
            plugins::create_plugin_folder($plugin_dir, $plugin_create_dir);
            $json_put_file = config_dir::BASE("/" . $plugin_create_dir . "/" . $plugin_dir . "/plugin_data.json");
            $json_plugin = json_encode(array(
                "name" => $plugin_name,
                "directory_name" => $plugin_dir,
                "description" => $plugin_description,
                "version" => $plugin_version
            ), JSON_PRETTY_PRINT);
            file_put_contents($json_put_file, $json_plugin);
            
            if ($mode === "cli") {
                echo "\nThe plugin has been successfully created\n\n";
            }
            else {
                return true;
            }
        }
        else {
            if ($mode === "cli") {
                echo "\n*** Make sure to enter all fields ***\n\n";
            }
            else {
                return false;
            }
        }
    }

    public static function install_plugin($mode = "cli") {
        if (isset($GLOBALS["commandToArgv"][1]) && file_exists($GLOBALS["commandToArgv"][1]) && preg_match("/.bcpi\$/", $GLOBALS["commandToArgv"][1])) {
            $bcpi_file = $GLOBALS["commandToArgv"][1];

            // Create unzip dir
            $unzip_dir = config_dir::BASE("/data/plugin_unzip");
            mkdir( $unzip_dir, 775 );
            $unzip = files::unzip(
                new ZipArchive(),
                $bcpi_file,
                $unzip_dir
            );

            if ($unzip) {
                $install_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "system" : "plugins";
                $get_json = json_decode( file_get_contents($unzip_dir . "/plugin_data.json"), true );

                if (!is_dir( config_dir::BASE("/system/" . $get_json["directory_name"]) ) && !is_dir(config_dir::BASE("/plugins/" . $get_json["directory_name"]))) {
                    mkdir( config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"]), 775 );
                    files::copy_dir_contents(
                        $unzip_dir,
                        config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"]),
                        files::findFiles( $unzip_dir )
                    );

                    // plugin installer
                    $install_file = realpath(config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"] . "/scripts/install.php"));
                    if ($install_file) {
                        require $install_file;
                    }

                    config_dir::deleteDirectory("/data/plugin_unzip");
                    if ($mode === "cli") {
                        echo "\nThe plugin has been installed successfully\n\n";
                    }
                    else {
                        return true;
                    }
                }
                else {
                    config_dir::deleteDirectory("/data/plugin_unzip");
                    if ($mode === "cli") {
                        echo "\nThe plugin has already been installed\n\n";
                    }
                    else {
                        return false;
                    }
                }
            }
        }
        elseif (isset($GLOBALS["commandToArgv"][1]) && !preg_match("/.bcpi\$/", $GLOBALS["commandToArgv"][1]) && $mode === "cli") {
            echo "\n*** You can only install plugins with the extension \".bcpi\" ***\n\n";
        }
        elseif ($mode === "cli") {
            echo "\n*** The installer you are looking for does not exist ***\n\n";
        }
    }

    public static function re_config($mode = "cli") {
        if ($mode === "cli") {
            if (file_exists(config_dir::BASE("/config.json"))) {
                $GLOBALS["config"] = json_decode(file_get_contents(config_dir::BASE("/config.json")), true);
            }
            else {
                $GLOBALS["config"] = array(
                    "useHttps"                  => false,
                    "domainDir"                 => "",
                    "displayUntrustedDomain"    => true,
                    "TrustedDomains"            => array(),
                    "DB_servername"             => "",
                    "DB_username"               => "",
                    "DB_password"               => "",
                    "DB_dbname"                 => "",
                    "call_plugin_definer"       => true,
                    "call_plugin_routes"        => true,
                    "dev_mode_on"               => false,
                    "cms_version"               => ""
                );
            }

            $argument1 = (count($GLOBALS["commandToArgv"]) > 1 && !in_array("-r", $GLOBALS["commandToArgv"]));
            $argument2 = (count($GLOBALS["commandToArgv"]) > 2 &&  in_array("-r", $GLOBALS["commandToArgv"]));
            if ( $argument1 || $argument2 ) {
                $argv_new = $GLOBALS["commandToArgv"];
                array_shift($argv_new);
                
                foreach ($argv_new AS $command) {
                    if (in_array($command, developer_reconfig::$argv_accepted_array)) {
                        call_user_func("developer_reconfig::" . preg_replace("/-/", "_", $command));
                    }
                }
            }
            else {
                $loop_array = developer_reconfig::$argv_accepted_array;
                unset($loop_array["database_all"]);
                foreach ($loop_array AS $command) {
                    call_user_func("developer_reconfig::" . preg_replace("/-/", "_", $command));
                }
            }

            file_put_contents(config_dir::BASE("/config.json"), json_encode($GLOBALS["config"], (in_array("-r", $GLOBALS["commandToArgv"])) ? JSON_PRETTY_PRINT : 0 ));

            config::reload_config();
        }
    }

    public static function compile_plugin($mode = "cli") {
        if (isset($GLOBALS["commandToArgv"][1])) {
            $dir_name = $GLOBALS["commandToArgv"][1];
            $file_number = 1;
            $installation_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "system" : "plugins";

            $installation_path = config_dir::BASE("/$installation_dir/" . $dir_name);
            $destination = config_dir::BASE("/data/developer/compile_data");

            if (is_dir( $installation_path )) {
                while (file_exists($destination . "/" . $dir_name . "." . (string)$file_number . ".bcpi")) {
                    $file_number = $file_number + 1;
                }

                // Create zip file
                files::createZipFile(
                    $installation_path,
                    files::findFiles( $installation_path ),
                    $dir_name . "." . (string)$file_number . ".bcpi",
                    $destination,
                    new ZipArchive()
                );

                if ($mode === "cli") {
                    echo "\nThe plugin has been successfully compiled to an installer in \"./data/developer/compile_data/$dir_name.$file_number.bcpi\"\n\n";
                }
                elseif ($mode === "web") {
                    return array(
                        true,
                        "fileName" => $dir_name. "." . $file_number . ".bcpi"
                    );
                }
            }
            else {
                if ($mode === "cli") {
                    echo "\n*** Plugin not found ***\n\n";
                }
                elseif ($mode === "web") {
                    return false;
                }
            }
        }
    }

    public static function uninstall_plugin($mode = "cli") {
        if (!in_array("-y", $GLOBALS["commandToArgv"]) && isset($GLOBALS["commandToArgv"][1])) {
            $pathToFileArray = explode("/", $GLOBALS["commandToArgv"][1]);
            $file = end($pathToFileArray);
            $are_you_sure = strtolower(readline('Are you sure you want to delete "' . $file . '" (Default: No): '));
        }
        elseif (in_array("-y", $GLOBALS["commandToArgv"]) && isset($GLOBALS["commandToArgv"][1])) {
            $are_you_sure = "yes";
        }
        else {
            $are_you_sure = "no";
        }

        if ($are_you_sure === "yes") {
            if (isset($GLOBALS["commandToArgv"][1])) {
                $delete_from_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "system" : "plugins";

                if (is_dir(config_dir::BASE("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1]))) {
                    require config_dir::BASE("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1] . "/scripts/delete.php");
                    config_dir::deleteDirectory("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1]);
                    if ($mode === "cli") {
                        echo "\nThe plugin has been successfully deleted\n\n";
                    }
                    elseif ($mode === "web") {
                        return true;
                    }
                }
                else {
                    if ($mode === "cli") {
                        echo "\n*** Plugin not found ***\n\n";
                    }
                    elseif ($mode === "web") {
                        return false;
                    }
                }
            }
        }
    }

    public static function reset_history() {
        if (isset($GLOBALS["commandToArgv"])) {
            $are_you_sure = (!in_array("-y", $GLOBALS["commandToArgv"])) ? strtolower(readline("Are you sure you want to clear the terminal history? (Default; No): ")) : "yes";

            if ($are_you_sure === "yes") {
                readline_clear_history();
                unlink(config_dir::BASE("/developer_history.json"));
            }
        }
    }

    // ============================== help ==============================
    public static function usage() {
        // commands
        echo "commands:\n\n";
        echo "   help ---------------------------------> Manual to the developer tool\n\n";
        echo "   new-plugin ---------------------------> Creates a new plugin\n\n";
        echo "   install-plugin </path/to/file.bcpi> --> Installs a plugin from a bcpi file\n\n";
        echo "   uninstall-plugin <dir_name> ----------> Used to uninstall a plugin\n\n";
        echo "   compile-plugin <dir_name> ------------> Used to compile a plugin\n\n";
        echo "   re-config ----------------------------> Reconfiguare your installation\n";
        echo "             <https>                 <domainDir>\n";
        echo "             <Domain-check>          <trusted-domain-add>\n";
        echo "             <trusted-domain-remove> <DB-server>\n";
        echo "             <DB-user>               <DB-pass>\n";
        echo "             <DB-db>                 <DB>\n";
        echo "             <call-pd>               <call-pr>\n";
        echo "             <dev-mode>              <cms-version>\n\n";
        echo "   reset-history ------------------------> Reset the command history of this terminal\n\n";

        // middel line
        echo "----------------------------------------------------------\n";

        // arguments
        echo "arguments:\n\n";
        echo "   -r ------------> 'readable' Makes json files readable\n\n";
        echo "   -s ------------> 'system'   Used to make changes to the system\n\n";
        echo "   -y ------------> 'yes'      Used to bypass 'are you sure' messages\n\n";
        echo "   -h & --help ---> 'help'     This is the same as the help command\n";
    }
}