<?php

/*
    DO NOT CHANGE LINES IN THIS FILE IF THE CMS IS NOT YET INSTALLED
    OR IF YOUR PLANNING TO REINSTALL THE CMS
*/

class config {
    // Set basic url(s)
    public static $useHttps                 = true;
    public static $domainDir                = "/build-cms-dev";
    public static $displayUntrustedDomain   = true;
    public static $TrustedDomains           = array( "localhost", "10.1.1.1" );

    // Database connection
    public static $servername   = "localhost";
    public static $username     = "root";
    public static $password     = "root";
    public static $dbname       = "build-cms";

    // Plugins
    public static $call_plugin_definer  = true;
    public static $call_plugin_routes   = true;

    // For developers
    public static $dev_mode_on = true;

    // Directories to skip in the autoloader
    public static $autoloaderSkipDir = array(
        "view",
        "www-root",
        "data",
        "backup",
        "classes_noAutoloader",
        "functions",
        "routes",
        "scripts"
    );
}