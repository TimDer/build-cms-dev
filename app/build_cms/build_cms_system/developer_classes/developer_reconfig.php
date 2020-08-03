<?php

class developer_reconfig {
    public static $argv_accepted_array = array(
        "https",
        "domainDir",
        "Domain-check",
        "trusted-domain-add",
        "trusted-domain-remove",

        "DB-server",
        "DB-user",
        "DB-pass",
        "DB-db",
        "database_all" => "DB",

        "call-pd",
        "call-pr",

        "dev-mode",
        "cms-version"
    );

    public static function https() {
        $use_https = strtolower(readline("Do you want to use https (Default: No): "));

        $GLOBALS["config"]["useHttps"] = ($use_https === "yes") ? true : false;
    }

    public static function domainDir() {
        $GLOBALS["config"]["domainDir"] = readline("What is the root directory (in the url) to the CMS: ");
    }

    public static function Domain_check() {
        $use_Domain_check = strtolower(readline("Do you want to check if the domain is trusted (Default: yes): "));

        $GLOBALS["config"]["displayUntrustedDomain"] = ($use_Domain_check !== "no") ? true : false;
    }

    public static function trusted_domain_add() {
        $domain = readline("Add a trusted domain (if not leave empty): ");

        if (!empty($domain)) {
            $GLOBALS["config"]["TrustedDomains"][] = $domain;
        }

        $GLOBALS["config"]["TrustedDomains"] = array_values($GLOBALS["config"]["TrustedDomains"]);
    }
    public static function trusted_domain_remove() {
        $domain = readline("Remove a trusted domain (if not leave empty): ");

        if (!empty($domain)) {
            foreach ($GLOBALS["config"]["TrustedDomains"] AS $key => $value) {
                if ($value === $domain) {
                    unset($GLOBALS["config"]["TrustedDomains"][$key]);
                }
            }
        }

        $GLOBALS["config"]["TrustedDomains"] = array_values($GLOBALS["config"]["TrustedDomains"]);
    }
    
    public static function DB_server() {
        $GLOBALS["config"]["DB_servername"] = readline("Set the database server URL: ");
    }
    public static function DB_user() {
        $GLOBALS["config"]["DB_username"] = readline("Set the database username: ");
    }
    public static function DB_pass() {
        $GLOBALS["config"]["DB_password"] = readline("Set the database password: ");
    }
    public static function DB_db() {
        $GLOBALS["config"]["DB_dbname"] = readline("Set the database name: ");
    }
    public static function DB() {
        self::DB_server();
        self::DB_user();
        self::DB_pass();
        self::DB_db();
    }
    
    public static function call_pd() {
        $call_pd = strtolower(readline("Do you want to call the plugin definers (Default: Yes): "));

        $GLOBALS["config"]["call_plugin_definer"] = ($call_pd !== "no") ? true : false;
    }
    
    public static function call_pr() {
        $call_pr = strtolower(readline("Do you want to call the plugin routes (Default: Yes): "));

        $GLOBALS["config"]["call_plugin_routes"] = ($call_pr !== "no") ? true : false;
    }
    
    public static function dev_mode() {
        $call_pr = strtolower(readline("Do you want to developer mode to be on (Default: No): "));

        $GLOBALS["config"]["dev_mode_on"] = ($call_pr === "yes") ? true : false;
    }
    
    public static function cms_version() {
        if ($GLOBALS["config"]["dev_mode_on"] === true) {
            $version = readline("What version of the CMS are you running on (Current version: " . $GLOBALS["config"]["cms_version"] . "): ");

            if (!empty($version)) {
                $GLOBALS["config"]["cms_version"] = $version;
            }
        }
    }
}