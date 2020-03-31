<?php

/*
    DO NOT CHANGE LINES IN THIS FILE IF THE CMS IS NOT YET INSTALLED
    OR IF YOUR PLANNING TO REINSTALL THE CMS
*/

class config {
    // set basic url(s)
    public static $useHttps                 = true;
    public static $domainDir                = "/build-cms-dev";
    public static $displayUntrustedDomain   = true;
    public static $TrustedDomains           = array( "localhost" );

    // database connection
    public static $servername   = "localhost";
    public static $username     = "root";
    public static $password     = "root";
    public static $dbname       = "build-cms";

    // plugins
    public static $call_plugin_definer  = true;
    public static $call_plugin_routes   = true;

    // autoloader directories to skip
    public static $autoloaderSkipDir = array( "view", "www-root", "data" );
}