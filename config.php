<?php

/*
    DO NOT CHANGE LINES IN THIS FILE IF THE CMS IS NOT YET INSTALLED
    OR IF YOUR PLANNING TO REINSTALL THE CMS
*/

// set the base url
config_url::set_url_dir("/td-cms");

// connect to the database
database::connect(
    array(
        "servername" => "localhost",
        "username"   => "root",
        "password"   => "root",
        "dbname"     => "td-cms"
    )
);