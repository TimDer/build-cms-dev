<?php

class database {
    // set basic vars
    public static $conn;
    public static $query;
    public static $fetch = array();

    // connect to the database
    public static function connect() {
        // connect to the sql server
        self::$conn = @mysqli_connect(
            config::get_config()["DB_servername"],
            config::get_config()["DB_username"],
            config::get_config()["DB_password"],
            config::get_config()["DB_dbname"]
        ) or die("\n*** Database Connection failed: " . mysqli_connect_error() . " ***\n\n");
    }

    // escape string
    public static function escape($array = array()) {
        // check if the loop function is defined
        if (!function_exists("loop")) {
            // loop function
            function loop($value, $conn) {
                $return = array();
                foreach ($value as $item_key => $item) {
                    // if item is an array loop through the array
                    if (is_array($item)) {
                        $return[$item_key] = loop($item, $conn);
                    }
                    // if item is a not an array escape it
                    else {
                        $return[$item_key] = mysqli_real_escape_string($conn, $item);
                    }
                }
    
                // return escaped array
                return $return;
            }
        }

        // return escaped array
        return loop($array, self::$conn);
    }

    // construct a query
    public static function query($sql) {
        if (!empty($sql)) {
            self::$query = mysqli_query(self::$conn, $sql);
        }
    }

    // construct a select query
    public static function select($query, $function = "return", $to_function = array(), $num_rows_else = null, $to_function2 = array()) {
        // get ready for a query
        self::reset();

        // query
        self::query($query);

        // check for rows
        if (self::query_result()->num_rows > 0) {
            self::fetch_all();
            $fetch_result = self::fetch_result();
            self::reset();

            if ($function === "return") {
                return $fetch_result;
            }
            else {
                $to_function["fetch_all"] = $fetch_result;
                $function->__invoke($to_function);
            }
        }
        // if num_rows_else var is a string redirect
        elseif (is_string($num_rows_else)) {
            header("Location: " . config_url::BASE($num_rows_else));
        }
        // if num_rows_else is a function invoke the function
        elseif (is_callable($num_rows_else)) {
            return $num_rows_else->__invoke($to_function2);
        }
        else {
            return false;
        }
    }

    // query result
    public static function query_result() {
        return self::$query;
    }

    // num rows result
    public static function query_num_rows($function, $function2 = null) {
        if (self::query_result()->num_rows > 0) {
            $function->__invoke();
        }
        elseif (is_string($function2)) {
            header("Location: " . config_url::BASE($function2));
        }
        else {
            if ($function2 !== null) {
                $function2->__invoke();
            }
        }
    }

    // return the query
    public static function fetch_result() {
        return self::$fetch;
    }

    // fetch all data into an array
    public static function fetch_all($number = 0) {
        if (self::$query->num_rows > $number) {
            while ($rows = self::$query->fetch_assoc()) {
                self::$fetch[] = $rows;
            }
        }
    }

    // reset the query and fetch
    public static function reset() {
        self::$query = NULL;
        self::$fetch = array();
    }
}