<?php

class database {
    public static $conn;
    public static $query;
    public static $fetch = array();
    public static $escape = array();

    // connect to the database
    public static function connect($DB = array("servername" => "", "username" => "", "password" => "", "dbname" => "",)) {
        self::$conn = mysqli_connect(
            $DB["servername"],
            $DB["username"],
            $DB["password"],
            $DB["dbname"]
        );

        if (!self::$conn) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    // escape string
    public static function escape($array = "") {
        if (!function_exists("loop")) {
            function loop($value, $conn) {
                if (!is_array($value)) {
                    return mysqli_real_escape_string($conn, $value);
                }
    
                foreach ($value as $item_key => $item) {
                    if (is_array($item)) {
                        $return[$item_key] = loop($item, $conn);
                    }
                    else {
                        $return[$item_key] = mysqli_real_escape_string($conn, $item);
                    }
                }
    
                return $return;
            }
        }

        // run
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                self::$escape[$key] = loop($value, self::$conn);
            }
        }
    }

    // construct a query
    public static function query($sql) {
        if (!empty($sql)) {
            self::$query = mysqli_query(self::$conn, $sql);
        }
    }

    public static function select($query, $function, $to_function = array(), $num_rows_else = null, $to_function2 = array()) {
        self::query($query);

        if (is_object(self::query_result()) AND self::query_result()->num_rows > 0) {
            self::fetch_all();
            $to_function["fetch_all"] = self::fetch_result();
            $function->__invoke($to_function);
            self::reset();
        }
        elseif (is_string($num_rows_else)) {
            header("Location: " . config_url::BASE($num_rows_else));
        }
        elseif ($num_rows_else !== null) {
            $num_rows_else->__invoke($to_function2);
        }
    }

    // result of the query
    public static function query_result() {
        return self::$query;
    }

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

    // reset the query
    public static function reset() {
        self::$query = NULL;
        self::$fetch = array();
        self::$escape = array();
    }
}