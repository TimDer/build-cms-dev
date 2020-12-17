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

    private function clear_database() {
        $tables_array = $this->get_all_tables("SHOW TABLES");

        if ($tables_array) {
            foreach ($tables_array AS $table) {
                mysqli_query($this->conn, "DROP TABLE `$table`");
            }
        }
    }

    private function import_sql(array $data) {
        foreach ($data AS $query) {
            if ($query === "") {
                continue;
            }
            mysqli_query($this->conn, $query);
        }
    }

    private function import_data(array $data) {
        foreach ($data AS $table_key => $table_value) {
            if ($table_value["data"] !== false) {
                // create begin of the query
                $query = "INSERT INTO `$table_key` (";
                
                // create header query
                foreach ($table_value["keyNames"] AS $header_key => $header_value) {
                    if ((count($table_value["keyNames"]) - 1) === $header_key) {
                        $query .= "`$header_value`";
                    }
                    else {
                        $query .= "`$header_value`,";
                    }
                }
                $query .= ") VALUES ";

                // create data query (loop through data array)
                foreach ($table_value["data"] AS $table_data_key => $table_data_value) {
                    // loop through the row
                    foreach ($table_data_value AS $row_key => $row_data) {
                        if (end($table_value["keyNames"]) === $row_key) {
                            if ( (count($table_value["data"]) - 1) ===  $table_data_key) {
                                $query .= ",'$row_data')";
                            }
                            else {
                                $query .= ",'$row_data'),";
                            }
                        }
                        elseif ($table_value["keyNames"][0] === $row_key) {
                            $query .= "('$row_data'";
                        }
                        else {
                            $query .= ",'$row_data'";
                        }
                    }
                }
                
                // query data
                mysqli_query($this->conn, $query);
            }
        }
    }

    // main function
    public function import_to_database($GET_var) {
        $dbName = $GET_var["db"];
        $dir    = $GET_var["dir"];
        
        if (is_object($this->conn)) {
            $array = json_decode(file_get_contents($dir . "/" . $dbName . ".json"), true);

            $this->clear_database();
            $this->import_sql($array["tablesSql"]);
            $this->import_data($array["tablesData"]);
        }
    }
}