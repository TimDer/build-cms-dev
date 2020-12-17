<?php

class build_cms_page_builder_load_page_pluginSubController extends controller {
    private static function create_query($load_building_blocks_area) {
        $building_blocks_area_array = array();
        foreach (build_cms_page_builder_template_loader::$building_blocks_area AS $value) {
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
        $sql = "SELECT $selecter FROM $table_name WHERE $where ORDER BY `the_order` ASC";
        
        return $sql;
    }

    private static function query_blocks_from_db($array) {
        if ($array) {
            foreach ($array AS $value) {
                build_cms_page_builder_page_functions::$blocks[$value["building_blocks_area"]][(int)$value["the_order"]] = array(
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
            build_cms_page_builder_page_functions::set_load_block("wysiwyg", function ($data) { self::load_wysiwyg($data); });
            build_cms_page_builder_page_functions::set_load_block("plain_text", function ($data) { self::load_plain_text($data); });
            build_cms_page_builder_page_functions::set_load_block("create_columns", function ($data) { self::load_create_columns($data); });
            build_cms_page_builder_page_functions::set_load_block("subcategories", function ($data) { self::load_subcategories($data); });
    
            self::query_blocks_from_db(database::select( (string)self::create_query($load_building_blocks_area) ));
    
            if (isset(build_cms_page_builder_page_functions::$blocks[$load_building_blocks_area])) {
                foreach (build_cms_page_builder_page_functions::$blocks[$load_building_blocks_area] AS $block) {
                    echo '<div class="block" block_status="saved" block_id="' . $block["block_id"] . '" block_type="' . $block["block_type"] . '" id="block_id_' . $block["block_id"] . '">';
                    if (isset(build_cms_page_builder_page_functions::$block_functions[$block["block_type"]])) {
                        build_cms_page_builder_page_functions::$block_functions[$block["block_type"]]["function"]->__invoke($block);
                    }
                    else {
                        echo "<p>" . $block["block_type"] . "</p>";
                    }
                    echo "</div>";
                }
            }
        }
    }

    /* ============================== Built In blocks ============================== */
    private static function load_wysiwyg($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `data` FROM `page_wysiwyg` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        build_cms_page_builder_loadWysiwyg_pluginSubModal::$block_id    = $block_id;
        build_cms_page_builder_loadWysiwyg_pluginSubModal::$sql_data    = $sql["data"];
        self::getView("/add/load_blocks/wysiwyg.php", __DIR__);
    }

    private static function load_plain_text($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `data` FROM `page_plain_text` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        build_cms_page_builder_loadPlainText_pluginSubModal::$block_id    = $block_id;
        build_cms_page_builder_loadPlainText_pluginSubModal::$sql_data    = $sql["data"];
        self::getView("/add/load_blocks/plain_text.php", __DIR__);
    }

    private static function load_subcategories($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `limit_type`, `the_limit`, `sort` FROM `page_sub_cat` WHERE `page_id`='$page_id' AND `block_id`='$block_id'")[0];
        build_cms_page_builder_loadSubcategories_pluginSubModal::$block_id = $block_id;
        build_cms_page_builder_loadSubcategories_pluginSubModal::$the_limit = $sql["the_limit"];

        // set selected in html
        if ($sql["limit_type"] === "no-limit") {
            build_cms_page_builder_loadSubcategories_pluginSubModal::$no_limit = " selected";
        }
        elseif ($sql["limit_type"] === "limited") {
            build_cms_page_builder_loadSubcategories_pluginSubModal::$limited = " selected";
        }
        if ($sql["sort"] === "first") {
            build_cms_page_builder_loadSubcategories_pluginSubModal::$first = " selected";
        }
        else if ($sql["sort"] === "latest") {
            build_cms_page_builder_loadSubcategories_pluginSubModal::$latest = " selected";
        }

        self::getView("/add/load_blocks/subcategories.php", __DIR__);
    }

    private static function load_create_columns($data) {
        $page_id    = $data["page_id"];
        $block_id   = $data["block_id"];
        $sql        = database::select("SELECT `column_id`, `width` FROM `page_cc_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id' ORDER BY `column_id`");

        build_cms_page_builder_loadCreateColumns_pluginSubModal::$page_id     = $page_id;
        build_cms_page_builder_loadCreateColumns_pluginSubModal::$block_id    = $block_id;
        build_cms_page_builder_loadCreateColumns_pluginSubModal::$array       = $sql;

        foreach ($sql AS $value) {
            build_cms_page_builder_loadCreateColumns_pluginSubModal::$create_columns_number++;
        }

        self::getView("/add/load_blocks/create_columns.php", __DIR__);
    }
    /* ============================== /Built In blocks ============================== */
}