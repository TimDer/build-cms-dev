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

    private function clear($dbName) {
        if (file_exists($this->database_dir . "/" . $dbName . ".json")) {
            unlink($this->database_dir . "/" . $dbName . ".json");
        }
    }

    private function remove_spaces(string $string) {
        $new_string = preg_replace("/  /", " ", $string);

        if ($string === $new_string) {
            return $new_string;
        }
        else {
            return $this->remove_spaces($new_string);
        }
    }

    private function create_sql_array($dbName, $tables_array) {
        $return_array = array();

        // create sql file
        foreach ($tables_array AS $value) {
            $sql_code_table         = $this->select("SHOW CREATE TABLE `$value`")[0];
            $return_array[$value]   = $this->remove_spaces(preg_replace("/\\n/", "", $sql_code_table["Create Table"]));
        }

        return $return_array;
    }

    private function create_tables_data($dbName, $tables_array) {
        $return_array = array();

        // create the data array
        foreach ($tables_array AS $value) {
            // get the data from the database
            $data_header = $this->get_all_columns("SHOW COLUMNS FROM `$value`");
            $data_result = $this->select("SELECT * FROM `$value`");

            $return_array[$value]["keyNames"]   = $data_header;
            $return_array[$value]["data"]       = $data_result;
        }

        return $return_array;
    }

    // main function
    public function export_to_file($dbName) {
        // create json array
        $array = array();

        // info about the exported file
        $array["_comment"] = array(
            "Author" => "Table dump with TD_dbExport by Tim Derksen",
            "Download-url" => "https://www.github.com/TimDer/TD_dbExport"
        );

        // all tables in the database (array)
        $array["tableNames"] = $this->get_all_tables("SHOW TABLES");
        // clear data dir
        //$this->clear($dbName);

        if ($array["tableNames"]) {
            // create sql file
            $array["tablesSql"] = $this->create_sql_array($dbName, $array["tableNames"]);

            // create data.csv files
            $array["tablesData"] = $this->create_tables_data($dbName, $array["tableNames"]);

            // turn the array into json
            $json = json_encode($array, JSON_PRETTY_PRINT);

            // json to file
            file_put_contents($this->database_dir . "/" . $dbName . ".json", $json);
        }
    }
}
