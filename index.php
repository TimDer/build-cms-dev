<?php

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require config_dir::ROUTES("/routes.php");


// Export database but not on AJAX request
if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
    $export_database = new TD_dbExport(database::$conn);
    $export_database->export_to_file("build-cms");
}