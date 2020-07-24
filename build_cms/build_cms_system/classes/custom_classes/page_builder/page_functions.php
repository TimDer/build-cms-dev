<?php

class page_functions {
    public static $define_block = array();
    /*
    Example: insert_functions
    array(
        "block_type" => array(
            "name" => "block_type",
            "display_name" => "display_name"
        )
    );
    */
    public static function define_block($area_name, $display_name) {
        if (!isset(self::$define_block[$area_name])) {
            self::$define_block[$area_name] = array(
                "name" => $area_name,
                "display_name" => $display_name
            );
        }
    }

    /* ============================== save delete and add ============================== */
    public static $insert_block_functions = array();
    /*
    Example: insert_functions
    array(
        "block_type" => function () {}
    );
    */
    public static $update_block_functions = array();
    /*
    Example: update_functions
    array(
        "block_type" => function () {}
    );
    */
    public static $delete_block_functions = array();
    /*
    Example: delete_functions
    array(
        "block_type" => function () {}
    );
    */
    public static $delete_page_functions = array();
    /*
    Example: delete_page_functions
    array(
        "block_type" => function () {}
    );
    */
    public static $custom_area = array();
    /*
    Example: custom_area
    array(
        "custom_area_name" => function () {}
    );
    */

    public static function set_custom_area($area_name, $function) {
        if (!isset(self::$custom_area[$area_name]) AND isset(self::$define_block[$area_name])) {
            self::$custom_area[$area_name] = $function;
        }
    }
    public static function set_insert_block($area_name, $function) {
        if (!isset(self::$insert_block_functions[$area_name]) AND isset(self::$define_block[$area_name])) {
            self::$insert_block_functions[$area_name] = $function;
        }
    }
    public static function set_update_block($area_name, $function) {
        if (!isset(self::$update_block_functions[$area_name]) AND isset(self::$define_block[$area_name])) {
            self::$update_block_functions[$area_name] = $function;
        }
    }
    public static function set_delete_block($area_name, $function) {
        if (!isset(self::$delete_block_functions[$area_name]) AND isset(self::$define_block[$area_name])) {
            self::$delete_block_functions[$area_name] = $function;
        }
    }
    public static function set_delete_page($area_name, $function) {
        if (!isset(self::$delete_page_functions[$area_name])) {
            self::$delete_page_functions[$area_name] = $function;
        }
    }
    /* ============================== /save delete and add ============================== */

    /* ============================== load blocks ============================== */
    public static $block_functions = array();
    /*
    Example: $block_functions
    array(
        "block_type_name" => array(
            "function" => function () {}
        )
    )
    */
    public static $blocks = array();
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

    public static function set_load_block($block_type, $function) {
        $default_block_types = array("wysiwyg", "plain_text", "create_columns", "subcategories");

        if (in_array($block_type, $default_block_types) && is_callable($function) && isset(self::$define_block[$block_type])) {
            if (isset(self::$block_functions[$block_type])) {
                unset(self::$block_functions[$block_type]);
            }
            self::$block_functions[$block_type] = array(
                "function" => $function
            );
        }
        elseif (!isset(self::$block_functions[$block_type]) && is_callable($function) && isset(self::$define_block[$block_type])) {
            self::$block_functions[$block_type] = array(
                "function" => $function
            );
        }
    }
    /* ============================== /load blocks ============================== */

    /* ============================== load javascript ============================== */

    public static $custom_page_js_footer = array();

    public static function set_custom_js_footer($path, $location) {
        if (!isset(self::$custom_page_js_footer[$path])) {
            self::$custom_page_js_footer[$path] = array(
                "path" => $path,
                "location" => $location
            );
        }
    }

    /* ============================== /load javascript ============================== */

    /* ============================== load CSS ============================== */

    public static $custom_page_css_head = array();

    public static function set_custom_css_head($path, $location) {
        if (!isset(self::$custom_page_css_head[$path])) {
            self::$custom_page_css_head[$path] = array(
                "path" => $path,
                "location" => $location
            );
        }
    }

    /* ============================== load CSS ============================== */

    /* ============================== custom areas ============================== */

    public static $build_custom_area = array();
    public static $sidebar_custom_area = array();
    public static $bottom_custom_area = array();

    public static function build_custom_area($area, $function) {
        if (!isset(self::$build_custom_area[$area])) {
            self::$build_custom_area[$area] = array(
                "area" => $area,
                "function" => $function
            );
        }
    }
    public static function sidebar_custom_area($area, $function) {
        if (!isset(self::$sidebar_custom_area[$area])) {
            self::$sidebar_custom_area[$area] = array(
                "area" => $area,
                "function" => $function
            );
        }
    }
    public static function bottom_custom_area($area, $function) {
        if (!isset(self::$bottom_custom_area[$area])) {
            self::$bottom_custom_area[$area] = array(
                "area" => $area,
                "function" => $function
            );
        }
    }

    // ---------- save custom area ----------
    public static $save_custom_area = array();
    public static function save_custom_area($area, $function) {
        if (!isset(self::$save_custom_area[$area])) {
            self::$save_custom_area[$area] = $function;
        }
    }

    /* ============================== /custom areas ============================== */

    /* ============================== template loader (load blocks) ============================== */

    public static $set_load_block_template_functions = array();
    public static function set_load_block_template_function($block, $function) {
        $default_block_types = array("wysiwyg", "plain_text", "create_columns", "subcategories");

        if (in_array($block, $default_block_types)) {
            if (isset(self::$set_load_block_template_functions[$block])) {
                unset(self::$set_load_block_template_functions[$block]);
            }
            self::$set_load_block_template_functions[$block] = $function;
        }
        elseif (!isset(self::$set_load_block_template_functions[$block]) && is_callable($function) && isset(self::$define_block[$block])) {
            self::$set_load_block_template_functions[$block] = $function;
        }
    }

    /* ============================== template loader (load blocks) ============================== */

    /* ============================== Load blocks (css) ============================== */

    public static $set_load_blocks_css_functions = array();
    public static function set_load_blocks_css_function($block, $function) {
        $default_block_types = array("wysiwyg", "plain_text", "create_columns");

        if (in_array($block, $default_block_types)) {
            if (isset(self::$set_load_blocks_css_functions[$block])) {
                unset(self::$set_load_blocks_css_functions[$block]);
            }
            self::$set_load_blocks_css_functions[$block] = $function;
        }
        elseif (!isset(self::$set_load_blocks_css_functions[$block]) && is_callable($function) && isset(self::$define_block[$block])) {
            self::$set_load_blocks_css_functions[$block] = $function;
        }
    }

    /* ============================== /Load blocks (css) ============================== */
}