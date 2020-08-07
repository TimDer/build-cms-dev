<?php

class TD_dbImport {
    private $conn;

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

    private function array_query($query_array) {
        $return_array = array();
        foreach ($query_array AS $query) {
            // continue if not a query
            if ($query === "") {
                continue;
            }
            // query
            $return_array[] = mysqli_query($this->conn, $query);
        }
        return $return_array;
    }

    private function clear_database($dir, $dbName) {
        $tables_array = $this->get_all_tables("SHOW TABLES");

        if ($tables_array) {
            foreach ($tables_array AS $table) {
                mysqli_query($this->conn, "DROP TABLE `$table`");
            }
        }
    }

    private function import_sql($dir, $dbName) {
        $query_array = explode(";", file_get_contents($dir . "/" . $dbName . ".sql"));
        
        $this->array_query($query_array);
    }

    private function csv_to_array($csv_file) {
        $array = array();
        while ($data = fgetcsv($csv_file)) {
            $array[] = $data;
        }
        return $array;
    }

    private function import_csv_file($dir, $dbName, $file) {
        // get table name
        $file_to_table_array = explode(".", $file);
        array_pop($file_to_table_array);
        $file_to_table = implode(".", $file_to_table_array);

        // open csv file
        $open_csv_file = fopen($dir . "/" . $dbName . "/" . $file, "r");
        $open_csv_array = $this->csv_to_array($open_csv_file);
        fclose($open_csv_file);

        // header and data
        $csv_header = $open_csv_array[0];
        unset($open_csv_array[0]);
        $open_csv_array = array_values($open_csv_array);

        // setup query string
        //                         Headers                            data                      data
        // INSERT INTO table_name (column1, column2, column3) VALUES (value1, value2, value3), (value1, value2, value3);
        $query = "INSERT INTO " . "`" . $file_to_table . "` (";
        // headers
        foreach ($csv_header AS $column_key => $column_name) {
            if ((count($csv_header) - 1) === $column_key) {
                $query .= $column_name . ") VALUES ";
            }
            else {
                $query .= $column_name . ", ";
            }
        }
        // data
        foreach ($open_csv_array AS $data_array_key => $data_array) {
            $query .= "(";
            foreach ($data_array AS $key_data => $data) {
                if ((count($data_array) - 1) === $key_data) {
                    $query .= "'$data'";
                }
                else {
                    $query .= "'$data', ";
                }
            }
            if ((count($open_csv_array) - 1) === $data_array_key) {
                $query .= ")";
            }
            else {
                $query .= "), ";
            }
        }

        // query data
        mysqli_query($this->conn, $query);
    }

    private function import_csv_scanDir($dir, $dbName) {
        $db_data_files = scandir($dir . "/" . $dbName);

        foreach ($db_data_files AS $file) {
            if ($file === "." OR $file === "..") {
                continue;
            }
            $this->import_csv_file($dir, $dbName, $file);
        }
    }

    // main function
    public function import_to_database($GET_var) {
        $dbName = $GET_var["db"];
        $dir    = $GET_var["dir"];
        
        if (is_object($this->conn)) {
            $this->clear_database($dir, $dbName);
            $this->import_sql($dir, $dbName);
            $this->import_csv_scanDir($dir, $dbName);
        }
    }
}