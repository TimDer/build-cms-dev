<?php

class developer_main {
    public static $argv_accepted_array = array(
        // plugin
        "new-plugin",
        "install-plugin",
        "uninstall-plugin",
        "compile-plugin",
        "list-plugin",
        "move-plugin-sys",
        "move-plugin",

        // config
        "re-config",
        "re-config-sys",

        // history
        "reset-history"
    );

    // ============================== plugin ==============================
    public static function new_plugin($mode = "cli") {
        $plugin_create_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "build_cms_system" . DIRECTORY_SEPARATOR . "system" : "plugins";
        
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

        $plugin_exists = is_dir(config_dir::BASE(DIRECTORY_SEPARATOR . $plugin_create_dir . DIRECTORY_SEPARATOR . $plugin_dir));

        if ( (!empty($plugin_name) && !empty($plugin_dir) && !empty($plugin_description)) && !empty($plugin_version) && !($plugin_exists) ) {
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
        elseif (!empty($plugin_dir) && $plugin_exists) {
            if ($mode === "cli") {
                echo "\n*** A plugin with that directory name already exists ***\n\n";
            }
            else {
                return false;
            }
        }
        else {
            if ($mode === "cli") {
                echo "\n*** Make sure to enter all fields ***\n\n";
            }
        }
    }

    public static function install_plugin($mode = "cli") {
        if (isset($GLOBALS["commandToArgv"][1]) && file_exists($GLOBALS["commandToArgv"][1]) && preg_match("/.bcpi\$/", $GLOBALS["commandToArgv"][1])) {
            $bcpi_file = $GLOBALS["commandToArgv"][1];

            // Create unzip dir
            $unzip_dir = config_dir::BUILD_CMS_SYSTEM("/data/plugin_unzip");
            mkdir( $unzip_dir, 775 );
            $unzip = files::unzip(
                new ZipArchive(),
                $bcpi_file,
                $unzip_dir
            );

            if ($unzip) {
                $install_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "build_cms_system" . DIRECTORY_SEPARATOR . "system" : "plugins";
                $get_json = json_decode( file_get_contents($unzip_dir . "/plugin_data.json"), true );

                if (!is_dir( config_dir::BUILD_CMS_SYSTEM("/system/" . $get_json["directory_name"]) ) && !is_dir(config_dir::BASE("/plugins/" . $get_json["directory_name"]))) {
                    mkdir( config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"]), 775 );
                    files::copy_dir_contents(
                        $unzip_dir,
                        config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"]),
                        files::findFiles( $unzip_dir )
                    );

                    // plugin installer
                    $install_file = realpath(config_dir::BASE("/" . $install_dir . "/" . $get_json["directory_name"] . "/scripts/install.php"));
                    if (file_exists($install_file)) {
                        require $install_file;
                    }

                    config_dir::deleteDirectory("/build_cms_system/data/plugin_unzip");
                    if ($mode === "cli") {
                        echo "\nThe plugin has been installed successfully\n\n";
                    }
                    else {
                        return array(
                            "error_handler" => true,
                            "json" => $get_json
                        );
                    }
                }
                else {
                    config_dir::deleteDirectory("/build_cms_system/data/plugin_unzip");
                    if ($mode === "cli") {
                        echo "\nThe plugin has already been installed\n\n";
                    }
                    else {
                        return array(
                            "error_handler" => false,
                            "json" => $get_json
                        );
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
                $delete_from_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "build_cms_system" . DIRECTORY_SEPARATOR . "system" : "plugins";

                if (is_dir(config_dir::BASE("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1]))) {
                    require config_dir::BASE("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1] . "/scripts/delete.php");
                    config_dir::deleteDirectory("/$delete_from_dir/" . $GLOBALS["commandToArgv"][1]);
                    if (in_array("-s", $GLOBALS["commandToArgv"])) {
                        $config = json_decode(file_get_contents(config_dir::BUILD_CMS_SYSTEM("/data/load_system_plugins.json")), true);

                        foreach ($config AS $rm_key => $rm_value) {
                            if ($rm_value["sys_plugin_dir_name"] === $GLOBALS["commandToArgv"][1]) {
                                unset($config[$rm_key]);
                            }
                        }

                        file_put_contents(config_dir::BUILD_CMS_SYSTEM("/data/load_system_plugins.json"), json_encode($config, (in_array("-r", $GLOBALS["commandToArgv"])) ? JSON_PRETTY_PRINT : 0 ));
                    }
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

    public static function compile_plugin($mode = "cli") {
        if (isset($GLOBALS["commandToArgv"][1])) {
            $dir_name = $GLOBALS["commandToArgv"][1];
            $file_number = 1;
            $installation_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "build_cms_system" . DIRECTORY_SEPARATOR . "system" : "plugins";

            $installation_path = config_dir::BASE("/$installation_dir/" . $dir_name);
            $destination = config_dir::BUILD_CMS_SYSTEM("/data/developer/compile_data");

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
                    echo "\nThe plugin has been successfully compiled to an installer in \"./build_cms_system/data/developer/compile_data/$dir_name.$file_number.bcpi\"\n\n";
                }
                elseif ($mode === "web") {
                    return array(
                        "error_handler" => true,
                        "fileName" => $dir_name. "." . $file_number . ".bcpi"
                    );
                }
            }
            else {
                if ($mode === "cli") {
                    echo "\n*** Plugin not found ***\n\n";
                }
                elseif ($mode === "web") {
                    return array(
                        "error_handler" => false
                    );
                }
            }
        }
    }

    public static function list_plugin($mode = "cli") {
        // set base dir
        $plugin_installation_dir = (in_array("-s", $GLOBALS["commandToArgv"])) ? "build_cms_system" . DIRECTORY_SEPARATOR . "system" : "plugins";
        $base_dir = config_dir::BASE(DIRECTORY_SEPARATOR . $plugin_installation_dir);

        // remove ".", ".." and ".dirPlaceholder"
        $plugins_dir_array = scandir($base_dir);
        foreach ($plugins_dir_array AS $plugin_key => $plugin_value) {
            if ($plugin_value === "." || $plugin_value === ".." || $plugin_value === ".dirPlaceholder") {
                unset($plugins_dir_array[$plugin_key]);
            }
        }
        $plugins_dir_array = array_values($plugins_dir_array);

        if ($mode === "cli") {
            echo "\n";
            foreach ($plugins_dir_array AS $plugin) {
                echo "$plugin\n";
            }
        }
        elseif ($mode === "web") {
            $return_array = array();

            foreach ($plugins_dir_array AS $return_value) {
                $plugin_dir = $base_dir . DIRECTORY_SEPARATOR . $return_value . DIRECTORY_SEPARATOR . "plugin_data.json";

                if (file_exists($plugin_dir)) {
                    $return_array[$return_value] = array(
                        "current_dir_name" => $return_value,
                        "json_file" => json_decode(file_get_contents($plugin_dir), true)
                    );
                }
            }

            return $return_array;
        }
    }

    public static function move_plugin_sys($mode = "cli") {
        if ($mode === "cli" && users::is_developer() && isset($GLOBALS["commandToArgv"][1])) {
            if (in_array("-y", $GLOBALS["commandToArgv"])) {
                $are_you_sure = true;
            }
            else {
                $yes_no = readline("Are you sure you wish to move the plugin to the system (default: no): ");
                $are_you_sure = (strtolower($yes_no) !== "yes") ? false : true;
            }

            $dir_source = config_dir::BASE("/plugins/" . $GLOBALS["commandToArgv"][1]);
            $dir_destination = config_dir::BUILD_CMS_SYSTEM("/system/" . $GLOBALS["commandToArgv"][1]);
            if ($are_you_sure && !is_dir($dir_destination)) {
                mkdir($dir_destination);
            }
            
            if ($are_you_sure) {
                files::copy_dir_contents(
                    $dir_source,
                    $dir_destination,
                    files::findFiles($dir_source)
                );
                config_dir::deleteDirectory("/plugins/" . $GLOBALS["commandToArgv"][1]);
            }
        }
        elseif ($mode === "cli" && !users::is_developer()) {
            echo "\n*** You have to enable developer mode in order to use this command ***\n\n";
        }
        elseif ($mode === "cli" && !isset($GLOBALS["commandToArgv"][1])) {
            self::usage();
        }
    }

    public static function move_plugin($mode = "cli") {
        if ($mode === "cli" && users::is_developer() && isset($GLOBALS["commandToArgv"][1])) {
            if (in_array("-y", $GLOBALS["commandToArgv"])) {
                $are_you_sure = true;
            }
            else {
                $yes_no = readline("Are you sure you wish to move the system-plugin to the plugins folder (default: no): ");
                $are_you_sure = (strtolower($yes_no) !== "yes") ? false : true;
            }

            $dir_source = config_dir::BUILD_CMS_SYSTEM("/system/" . $GLOBALS["commandToArgv"][1]);
            $dir_destination = config_dir::BASE("/plugins/" . $GLOBALS["commandToArgv"][1]);
            if ($are_you_sure && !is_dir($dir_destination)) {
                mkdir($dir_destination);
            }
            
            if ($are_you_sure) {
                files::copy_dir_contents(
                    $dir_source,
                    $dir_destination,
                    files::findFiles($dir_source)
                );
                config_dir::deleteDirectory("/build_cms_system/system/" . $GLOBALS["commandToArgv"][1]);
            }
        }
        elseif ($mode === "cli" && !users::is_developer()) {
            echo "\n*** You have to enable developer mode in order to use this command ***\n\n";
        }
        elseif ($mode === "cli" && !isset($GLOBALS["commandToArgv"][1])) {
            self::usage();
        }
    }
    // ============================== /plugin ==============================

    // ============================== Other ==============================
    public static function re_config($mode = "cli") {
        if ($mode === "cli") {
            if (file_exists(config_dir::BUILD_CMS_SYSTEM("/data/config.json"))) {
                $GLOBALS["config"] = json_decode(file_get_contents(config_dir::BUILD_CMS_SYSTEM("/data/config.json")), true);
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

            file_put_contents(config_dir::BUILD_CMS_SYSTEM("/data/config.json"), json_encode($GLOBALS["config"], (in_array("-r", $GLOBALS["commandToArgv"])) ? JSON_PRETTY_PRINT : 0 ));

            config::reload_config();
        }
    }

    public static function re_config_sys($mode = "cli") {
        if ($mode === "cli") {
            users::is_developer(function () {
                $system_dir = scandir(config_dir::BUILD_CMS_SYSTEM("/system"));

                // remove ".", ".." and ".dirPlaceholder"
                foreach ($system_dir AS $remove_key => $remove_value) {
                    if ($remove_value === "." || $remove_value === ".." || $remove_value === ".dirPlaceholder") {
                        unset($system_dir[$remove_key]);
                    }
                }
                $system_dir = array_values($system_dir);

                // configure system-plugins
                $higher_number  = count($system_dir) * 7;
                $array_amount   = (count($system_dir) - 1);
                $used_number    = array();
                $load_system_plugins = array();
                foreach ($system_dir AS $configure_value) {
                    echo "\n";
                    while ($higher_number > $array_amount) {
                        $number = readline("Select a number for [" . $configure_value . "]: ");

                        if (is_numeric($number)) {
                            if (!in_array($number, $used_number)) {
                                if ((int)$number <= $array_amount && (int)$number >= 0) {
                                    $load_define = (readline('do you want to load the defender of "' . $configure_value . '" (default: yes): ') !== "no") ? true : false;
                                    $load_routes = (readline('do you want to load the routes of "' . $configure_value . '" (default: yes): ') !== "no") ? true : false;
                                    $load_system_plugins[(int)$number] = array(
                                        "sys_plugin_dir_name" => $configure_value,
                                        "load_define" => $load_define,
                                        "load_routes" => $load_routes
                                    );
                                    $used_number[] = $number;
                                    $higher_number = 0;
                                }
                                else {
                                    echo "\nYour number has to be equal or greater than 0 and lower or equal to: " . $array_amount . "\n\n";
                                }
                            }
                            else {
                                echo "You have already used that number\n";
                            }
                        }
                        else {
                            echo "Numbers only\n";
                        }
                    }
                    $higher_number = count($system_dir) * 7;
                }
                
                // Array to correct order
                $return_array = array();
                for ($array_key_return = 0; $array_key_return <= $array_amount; $array_key_return++) { 
                    $return_array[$array_key_return] = $load_system_plugins[$array_key_return];
                }

                file_put_contents(config_dir::BUILD_CMS_SYSTEM("/data/load_system_plugins.json"), json_encode($return_array, (in_array("-r", $GLOBALS["commandToArgv"])) ? JSON_PRETTY_PRINT : 0 ));
            }, function () {
                echo "\n*** You have to enable developer mode in order to configure the system-plugins ***\n\n";
            });
        }
    }

    public static function reset_history() {
        if (isset($GLOBALS["commandToArgv"])) {
            $are_you_sure = (!in_array("-y", $GLOBALS["commandToArgv"])) ? strtolower(readline("Are you sure you want to clear the terminal history? (Default; No): ")) : "yes";

            if ($are_you_sure === "yes") {
                readline_clear_history();
                unlink(config_dir::BUILD_CMS_SYSTEM("/data/developer/developer_history.json"));
            }
        }
    }
    // ============================== /Other ==============================

    // ============================== help ==============================
    public static function usage() {
        // commands
        echo "commands:\n";
        echo "   help ---------------------------------> Manual to the developer tool\n";
        echo "   new-plugin ---------------------------> Creates a new plugin\n";
        echo "   install-plugin </path/to/file.bcpi> --> Installs a plugin from a bcpi file\n";
        echo "   uninstall-plugin <dir_name> ----------> Used to uninstall a plugin\n";
        echo "   compile-plugin <dir_name> ------------> Used to compile a plugin\n";
        echo "   list-plugin --------------------------> Creates a list of all installed plugins\n";
        echo "   move-plugin-sys <dir_name> -----------> Moves a plugin from the plugin folder to the system\n";
        echo "   move-plugin <dir_name> ---------------> Moves a system-plugin from the system to the plugin folder\n";
        echo "   re-config ----------------------------> Reconfiguare your installation\n";
        echo "             <https>                 <domainDir>\n";
        echo "             <Domain-check>          <trusted-domain-add>\n";
        echo "             <trusted-domain-remove> <DB-server>\n";
        echo "             <DB-user>               <DB-pass>\n";
        echo "             <DB-db>                 <DB>\n";
        echo "             <call-pd>               <call-pr>\n";
        echo "             <dev-mode>              <cms-version>\n";
        echo "   re-config-sys ------------------------> Reconfiguares system-plugins\n";
        echo "   reset-history ------------------------> Reset the command history of this terminal\n";

        // middel line
        echo "-----------------------------------------------------------------------------------------------------\n";

        // arguments
        echo "arguments:\n";
        echo "   -r ------------> 'readable' Makes json files readable\n";
        echo "   -s ------------> 'system'   Used to make changes to the system\n";
        echo "   -y ------------> 'yes'      Used to bypass 'are you sure' messages\n";
        echo "   -h & --help ---> 'help'     This is the same as the help command\n";
    }
}