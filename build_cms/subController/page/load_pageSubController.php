<?php

class load_pageSubController extends controller {
    private static $block_functions = array();
    /*
    Example: $block_functions
    array(
        "block_type_name" => array(
            "function" => function () {}
        )
    )
    */
    private static $blocks = array();
    /*
    Example: $blocks
    array(
        "building_blocks_area" => array(
            (int)the_order => array(
                "block_type" => "value",
                "page_id" => "value",
                "block_id" => "value",
                "db_block_id" => "",
                "building_blocks_area" => "value",
                "the_order" => "value"
            )
        )
    )
    */

    public static function set_block_type($block_type, $function) {
        $default_block_types = array("wysiwyg", "plain_text", "create_columns", "subcategories");

        if (in_array($block_type, $default_block_types) && is_callable($function)) {
            if (isset(self::$block_functions[$block_type])) {
                unset(self::$block_functions[$block_type]);
            }
            self::$block_functions[$block_type] = array(
                "function" => $function
            );
        }
        elseif (!isset(self::$block_functions[$block_type]) && is_callable($function)) {
            self::$block_functions[$block_type] = array(
                "function" => $function
            );
        }
    }

    private static function create_query($load_building_blocks_area) {
        $building_blocks_area_array = array();
        foreach (plugins::$building_blocks_area AS $value) {
            $building_blocks_area_array[] = $value["name"];
        }

        // setup where Clauses
        $where_page_id = "`page_id`='" . user_url::$new_uri[0] . "'";
        $where_building_blocks_area = "`building_blocks_area`='$load_building_blocks_area'";
        $where = "$where_building_blocks_area AND $where_page_id";
        
        // setup selecter
        $selecter_array = array(
            "id",
            "block_type",
            "block_id",
            "page_id",
            "building_blocks_area",
            "the_order"
        );
        $selecter = "`" . implode("`, `", $selecter_array) . "`";

        // table
        $table_name = "`page_blocks`";

        // setup sql
        $sql = "SELECT $selecter FROM $table_name WHERE $where";
        
        return $sql;
    }

    private static function query_blocks_from_db($array) {
        if ($array) {
            foreach ($array AS $value) {
                self::$blocks[$value["building_blocks_area"]][(int)$value["the_order"]] = array(
                    "block_type" => $value["block_type"],
                    "block_id" => $value["block_id"],
                    "db_block_id" => $value["id"],
                    "page_id" => $value["page_id"],
                    "building_blocks_area" => $value["building_blocks_area"],
                    "the_order" => $value["the_order"]
                );
            }
        }
    }

    public static function load_blocks($load_building_blocks_area) {
        if (isset(user_url::$new_uri[0]) && is_numeric(user_url::$new_uri[0])) {
            self::set_block_type("wysiwyg", function ($data) { self::load_wysiwyg($data); });
            self::set_block_type("plain_text", function ($data) { self::load_plain_text($data); });
            self::set_block_type("create_columns", function ($data) { self::load_create_columns($data); });
            self::set_block_type("subcategories", function ($data) { self::load_subcategories($data); });
    
            self::query_blocks_from_db(database::select( (string)self::create_query($load_building_blocks_area) ));
    
            if (isset(self::$blocks[$load_building_blocks_area])) {
                foreach (self::$blocks[$load_building_blocks_area] AS $block) {
                    if (isset(self::$block_functions[$block["block_type"]])) {
                        self::$block_functions[$block["block_type"]]["function"]->__invoke($block);
                    }
                }
            }
        }
    }

    /* ============================== Built In blocks ============================== */
    private static function load_wysiwyg($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `data` FROM `page_wysiwyg` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        pageBuilder_loadWysiwygSubModal::$block_id    = $block_id;
        pageBuilder_loadWysiwygSubModal::$sql_data    = $sql["data"];
        self::getView("/admin/page/add/load_blocks/wysiwyg.php");
    }

    private static function load_plain_text($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `data` FROM `page_plain_text` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        pageBuilder_loadPlainTextSubModal::$block_id    = $block_id;
        pageBuilder_loadPlainTextSubModal::$sql_data    = $sql["data"];
        self::getView("/admin/page/add/load_blocks/plain_text.php");
    }

    private static function load_subcategories($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `limit_type`, `the_limit`, `sort` FROM `page_sub_cat` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        pageBuilder_loadSubcategoriesSubModal::$block_id = $block_id;
        pageBuilder_loadSubcategoriesSubModal::$the_limit = $sql["the_limit"];

        // set selected in html
        if ($sql["limit_type"] === "no-limit") {
            pageBuilder_loadSubcategoriesSubModal::$no_limit = " selected";
        }
        elseif ($sql["limit_type"] === "limited") {
            pageBuilder_loadSubcategoriesSubModal::$limited = " selected";
        }
        if ($sql["sort"] === "first") {
            pageBuilder_loadSubcategoriesSubModal::$first = " selected";
        }
        else if ($sql["sort"] === "latest") {
            pageBuilder_loadSubcategoriesSubModal::$latest = " selected";
        }

        self::getView("/admin/page/add/load_blocks/subcategories.php");
    }

    private static function load_create_columns($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `column_id`, `width` FROM `page_cc_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id' ORDER BY `column_id`");

        pageBuilder_loadCreateColumnsSubModal::$page_id     = $page_id;
        pageBuilder_loadCreateColumnsSubModal::$block_id    = $block_id;
        pageBuilder_loadCreateColumnsSubModal::$array       = $sql;

        foreach ($sql AS $value) {
            pageBuilder_loadCreateColumnsSubModal::$create_columns_number++;
        }

        self::getView("/admin/page/add/load_blocks/create_columns.php");
    }
    /* ============================== /Built In blocks ============================== */
}