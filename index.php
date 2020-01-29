<?php

require __DIR__ . "/build_cms/autoload.php";
require __DIR__ . "/build_cms/config.php";
require config_dir::ROUTES("/routes.php");


// Export database but not on AJAX request
if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
    $export_database = new TD_dbExport(database::$conn);
    $export_database->export_to_file("build-cms");
}