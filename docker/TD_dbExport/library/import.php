<?php

if (isset($_GET["dir"])) {
    $dir = $_GET["dir"];
}
else {
    $dir = __DIR__ . "/data";
}

if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files AS $key => $value) {
        if ($value === "." OR $value === ".." OR is_file($dir . "/" . $value)) {
            unset($files[$key]);
            continue;
        }
    }
}
else {
    $files = array("error" => "No databasses in this directory");
}

require __DIR__ . "/config.inc.php";
if (isset($_GET["db"]) AND isset($_GET["dir"]) AND isset($_GET["old_dir"]) AND !isset($files["error"]) AND ( $_GET["dir"] === $_GET["old_dir"] )) {
    require __DIR__ . "/TD_dbImport.php";
    $import_database = new TD_dbImport($TD_dbExport_DB);
    $import_database->import_to_database($_GET);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>TD_dbExport - Export page</title>
</head>
<body>
    <form action="./import.php" method="get" class="container">
        <h1 class="warning">Warning this will clear your database</h1>
        <h1>Import a database</h1>
        <input type="text" name="dir" value="<?php echo $dir; ?>">
        <input type="hidden" name="old_dir" value="<?php echo $dir; ?>">
        <select name="db">
            <?php foreach ($files AS $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Submit">
        <h2 class="database_credentials_heading">Your database credentials are:</h2>
        <div class="database_credentials">
            <p>Server:   "<?php echo $TD_dbExport_DB["servername"]; ?>"</p>
            <p>User:     "<?php echo $TD_dbExport_DB["username"]; ?>"</p>
            <p>Password: "<?php echo $TD_dbExport_DB["password"]; ?>"</p>
            <p>Database: "<?php echo $TD_dbExport_DB["dbname"]; ?>"</p>
        </div>
    </form>
</body>
</html>