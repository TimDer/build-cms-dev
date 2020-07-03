<?php

require __DIR__ . "/build_cms/start.php";

// Export database but not on AJAX request
/*if  (
        !isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        implode("/", user_url::$routes_uri) !== "images" &&
        implode("/", user_url::$routes_uri) !== "view" &&
        implode("/", user_url::$routes_uri) !== "admin_files/plugins"
    )
{*/
if  (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    implode("/", user_url::$routes_uri) !== "images" &&
    implode("/", user_url::$routes_uri) !== "view" &&
    (isset(user_url::$routes_uri[0]) && user_url::$routes_uri[0] !== "admin_files")
)
{
    require __DIR__ . "/TD_dbExport/TD_dbExport.php";
    $export_database = new TD_dbExport(database::$conn);
    /*$export_database = new TD_dbExport(array(
        "servername" => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname" => "build-cms"
    ));*/
    $export_database->export_to_file("../../../build-cms-dev-database/build-cms_" . date("Y-m-d-H"));
    $export_database->export_to_file("build-cms");
}