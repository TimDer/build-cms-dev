<?php

require "/TD_dbExport/library/TD_dbExport.php";

while (true) {
    sleep(10);
    $export_database = new TD_dbExport(array(
        "servername" => "build_cms_database",
        "username" => "root",
        "password" => "root",
        "dbname" => "build-cms"
    ));
    
    $export_database->set_database_dir("/TD_dbExport/data");
    $export_database->export_to_file("build-cms");
}