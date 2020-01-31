<?php

require __DIR__ . "/build_cms/start.php";

// Export database but not on AJAX request
if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) && implode("/", user_url::$routes_uri) !== "images" && implode("/", user_url::$routes_uri) !== "get_data" ) {
    require __DIR__ . "/TD_dbExport/TD_dbExport.php";
    $export_database = new TD_dbExport(database::$conn);
    $export_database->export_to_file("build-cms");
}