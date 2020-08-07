<?php

class TD_dbExport {
    private $conn;
    private $database_dir = __DIR__ . "/data";

    // set database connection
    function __construct($DB) {
        if (is_array($DB) AND isset($DB["servername"]) AND isset($DB["username"]) AND isset($DB["password"]) AND isset($DB["dbname"])) {
            $this->conn = mysqli_connect(
                $DB["servername"],
                $DB["username"],
                $DB["password"],
                $DB["dbname"]
            );
        }
        else {
            $this->conn = $DB;
        }
    }

    // set a directory to store the database
    public function set_database_dir($dir) {
        $this->database_dir = $dir;
    }

    // database query
    private function select($query) {
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $return_array = array();
            while($row = mysqli_fetch_assoc($result)) {
                $return_array[] = $row;
            }
            return $return_array;
        } else {
            return false;
        }
    }

    // database query for get all tables (SHOW TABLES)
    private function get_all_tables($query) {
        $result = $this->select($query);
        $return_array = array();

        if ($result) {
            foreach ($result AS $key => $value) {
                foreach ($value AS $value_table_name) {
                    $return_array[] = $value_table_name;
                }
            }
    
            return $return_array;
        }
        else {
            return false;
        }
    }

    // database query for get all columns (SHOW COLUMNS)
    private function get_all_columns($query) {
        $result = $this->select($query);
        $return_array = array();

        foreach ($result AS $key => $value) {
            $return_array[] = $value["Field"];
        }

        return $return_array;
    }

    private function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
    }

    private function clear_dir($dbName) {
        if (file_exists($this->database_dir . "/" . $dbName . ".sql")) {
            unlink($this->database_dir . "/" . $dbName . ".sql");
        }
        if (is_dir($this->database_dir . "/" . $dbName)) {
            $this->deleteDirectory($this->database_dir . "/" . $dbName);
        }
    }

    private function create_sql_file($dbName, $tables_array) {
        // alter table array
        $alter_table_array = array();

        // open the sql file
        $sql_file_path = $this->database_dir . "/" . $dbName . ".sql";
        $open_sql_file = fopen($sql_file_path, "w");
        fwrite($open_sql_file, "-- table dump with TD_dbExport by Tim Derksen\n");
        fwrite($open_sql_file, "-- Download url: https://www.github.com/TimDer/TD_dbExport");

        // create sql file
        foreach ($tables_array AS $value) {
            $sql_code_table     = $this->select("SHOW CREATE TABLE `$value`")[0];
            $sql_primary_key    = $this->select("SHOW INDEX FROM `$value` WHERE Key_name = 'PRIMARY'")[0]["Column_name"];

            fwrite($open_sql_file, "\n\n-- " . $sql_code_table["Table"] . "\n");
            fwrite($open_sql_file, $sql_code_table["Create Table"] . ";\n");
            if ($sql_primary_key) {
                fwrite($open_sql_file, "ALTER TABLE `$value` ADD PRIMARY KEY (`$sql_primary_key`);");
            }
        }
    }

    private function create_csv_files($dbName, $tables_array) {
        // create data.csv files
        foreach ($tables_array AS $value) {
            // get the data from the database
            $data_header = $this->get_all_columns("SHOW COLUMNS FROM `$value`");
            $data_result = $this->select("SELECT * FROM `$value`");

            // open file
            if ($data_result !== false) {
                if (!is_dir($this->database_dir . "/" . $dbName)) {
                    mkdir($this->database_dir . "/" . $dbName, 775);
                }

                $csv_file_path = $this->database_dir . "/" . $dbName . "/" . $value . ".csv";
                $open_csv_file = fopen($csv_file_path, "w");

                // store in file
                fputcsv($open_csv_file, $data_header);
                foreach ($data_result AS $data_value) {
                    fputcsv($open_csv_file, $data_value);
                }

                // close file
                fclose($open_csv_file);
            }
        }
    }

    // main function
    public function export_to_file($dbName) {
        // all tables in the database (array)
        $tables_array = $this->get_all_tables("SHOW TABLES");
        // clear data dir
        $this->clear_dir($dbName);

        if ($tables_array) {
            // create sql file
            $this->create_sql_file($dbName, $tables_array);

            // create data.csv files
            $this->create_csv_files($dbName, $tables_array);
        }
    }
}
