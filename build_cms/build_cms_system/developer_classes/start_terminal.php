<?php

class start_terminal {
    private static $terminal_running    = true;

    public static function main() {
        global $argv;
        if (isset( $argv ) && count( $argv ) > 1) {
            array_shift($argv);
            self::to_json( implode(" ", $argv) );
            self::run_command($argv);
            echo "\n";
        }
        else {
            self::open_terminal();
            self::run_terminal();
        }
    }

    public static function web_terminal($argv_string, $readline = array()) {
        $GLOBALS["readline"] = $readline;

        $argv_array = explode(" ", $argv_string . " -y");

        foreach ($argv_array AS $argv_key => $argv_velue) {
            if (empty($argv_velue)) {
                unset($argv_array[$argv_key]);
            }
        }

        if (in_array($argv_array[0], developer_main::$argv_accepted_array)) {
            $GLOBALS["commandToArgv"] = $argv_array;
            return call_user_func("developer_main::" . preg_replace("/-/", "_", $argv_array[0]), "web");
        }
        else {
            return "undefined-command";
        }
    }

    private static function to_json($string) {
        $file_dir = config_dir::BUILD_CMS_SYSTEM("/data/developer/developer_history.json");
        $json_array = (file_exists($file_dir)) ? json_decode(file_get_contents($file_dir), true) : array();
        
        if (is_string($string) && $string !== "" && $string !== end($json_array)) {
            $json_array[] = $string;
        }

        readline_clear_history();
        foreach ($json_array AS $history) {
            readline_add_history($history);
        }

        file_put_contents($file_dir, json_encode($json_array, JSON_PRETTY_PRINT));
    }

    private static function get_json() {
        $file_dir = config_dir::BUILD_CMS_SYSTEM("/data/developer/developer_history.json");
        $get_json = (file_exists($file_dir)) ? json_decode(file_get_contents($file_dir), true) : array();

        if (!empty($get_json)) {
            foreach ($get_json AS $history) {
                readline_add_history($history);
            }
        }
    }

    private static function run_command($commandToArgv = array()) {
        $GLOBALS["commandToArgv"] = $commandToArgv;
        
        if (in_array("-s", $commandToArgv) && !users::is_developer()) {
            echo "\n*** You have to enable developer mode in order to use \"-s\" ***\n\n";
        }
        elseif (in_array("--help", $commandToArgv) || in_array("help", $commandToArgv) || in_array("-h", $commandToArgv)) {
            developer_main::usage();
        }
        elseif (in_array($commandToArgv[0], developer_main::$argv_accepted_array)) {
            call_user_func("developer_main::" . preg_replace("/-/", "_", $commandToArgv[0]));
        }
        else {
            echo "*** Command not found ***\n";
        }
    }

    private static function open_terminal() {
        echo "\n\n";
        echo '   |=====|      |       |     ||     ||                 |            |========     |\    /|     ========' . "\n";
        echo '   |      \     |       |            ||                 |            |             | \  / |     |       ' . "\n";
        echo '   |      /     |       |     ||     ||            _____|            |             |  \/  |     |       ' . "\n";
        echo '   |=====|      |       |     ||     ||           /     |  ========  |             |      |     ========' . "\n";
        echo '   |      \     |       |     ||     ||           |     |            |             |      |            |' . "\n";
        echo '   |      /     |       |     ||     ||           |     |            |             |      |            |' . "\n";
        echo '   |=====|      |=======|     ||     ||======     \_____|            |========     |      |     ========' . "\n\n\n";
        
        echo '   =========     |========     |========     |\    /|     ||     |========|           /\           |        ' . "\n";
        echo '       |         |             |             | \  / |            |        |          /  \          |        ' . "\n";
        echo '       |         |             |             |  \/  |     ||     |        |         /    \         |        ' . "\n";
        echo '       |         |========     |             |      |     ||     |        |        /      \        |        ' . "\n";
        echo '       |         |             |             |      |     ||     |        |       /========\       |        ' . "\n";
        echo '       |         |             |             |      |     ||     |        |      /          \      |        ' . "\n";
        echo '       |         |========     |             |      |     ||     |        |     /            \     |________' . "\n\n";
    }

    private static function run_terminal() {
        self::get_json();
        while (self::$terminal_running) {
            echo "\n";
            $command = readline("Developer command > ");
            
            if (preg_match("/exit/", $command)) {
                self::$terminal_running = false;
            }
            else {
                self::run_command(explode(" ", $command));
                self::to_json((string)$command);
            }
        }
    }
}