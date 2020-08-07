<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>TD_dbExport - Export page</title>
</head>
<body>
    <div class="container">
        <h1>Success</h1>
        <p>The database has been successfully exported</p>
    </div>
</body>
</html>
<?php

// Export database but not on AJAX request
if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
    require __DIR__ . "/config.inc.php";
    require __DIR__ . "/TD_dbExport.php";
    $export_database = new TD_dbExport($TD_dbExport_DB);
    $export_database->export_to_file("database");
}