<?php

class load_page {
    private static $load_json = array();

    public static function load() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                header("Content-type: text/javascript");

                database::reset();
                database::escape( user_url::$new_uri );
                $id = database::$escape[0];
                database::select(self::load_sql_query($id), function ($data) {
                        $new_data = array();
                        foreach ($data["fetch_all"] AS $key => $value) {
                            $new_data[$key] = $value;

                            if (isset($value['img_block_data'])) {
                                $new_data[$key]['data'] = $value['img_block_data'];
                            }
                            elseif (isset($value['plain_text_data'])) {
                                $new_data[$key]['data'] = $value['plain_text_data'];
                            }
                            elseif (isset($value['wysiwyg_data'])) {
                                $new_data[$key]['data'] = $value['wysiwyg_data'];
                            }

                            unset($new_data[$key]['img_block_data']);
                            unset($new_data[$key]['plain_text_data']);
                            unset($new_data[$key]['wysiwyg_data']);
                        }

                        foreach ($new_data AS $key1 => $value1) {
                            foreach ($value1 AS $key2 => $value2) {
                                if (!isset($value2)) {
                                    unset($new_data[$key1][$key2]);
                                }
                            }
                        }

                        self::loop_blocks($new_data);
                    }
                );

                echo json_encode( self::$load_json, JSON_FORCE_OBJECT );
            });
        });
    }

    private static $load_sql_query_return;
    private static $load_sql_query_id;
    private static function load_sql_query($id) {
        self::$load_sql_query_id = $id;

        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                $id = self::$load_sql_query_id;
                self::$load_sql_query_return = "SELECT
                    -- page_blocks table
                    page_blocks.id,
                    page_blocks.page_id,
                    block_type,
                    page_blocks.block_id,
                    building_blocks_area,
                    the_order,
                
                    -- page_img_block table
                    page_img_block.image AS `img_block_data`,
                    page_img_block.img_size_mode,
                    page_img_block.img_width,
                    page_img_block.img_height,
                    page_img_block.image_align,
                
                    -- page_plain_text table
                    page_plain_text.data AS `plain_text_data`,
                
                    -- page_wysiwyg table
                    page_wysiwyg.data AS `wysiwyg_data`,
                
                    -- page_sub_cat table
                    page_sub_cat.limit_type,
                    page_sub_cat.the_limit,
                    page_sub_cat.sort
                FROM `page_blocks`
                
                LEFT JOIN page_img_block ON
                    page_img_block.page_blocks_id   = page_blocks.id AND
                    page_img_block.page_id          = page_blocks.page_id AND
                    page_img_block.block_id         = page_blocks.block_id
                
                LEFT JOIN page_plain_text ON
                    page_plain_text.page_blocks_id  = page_blocks.id AND
                    page_plain_text.page_id         = page_blocks.page_id AND
                    page_plain_text.block_id        = page_blocks.block_id
                
                LEFT JOIN page_wysiwyg ON
                    page_wysiwyg.page_blocks_id     = page_blocks.id AND
                    page_wysiwyg.page_id            = page_blocks.page_id AND
                    page_wysiwyg.block_id           = page_blocks.block_id
                
                LEFT JOIN page_sub_cat ON
                    page_sub_cat.page_blocks_id     = page_blocks.id AND
                    page_sub_cat.page_id            = page_blocks.page_id AND
                    page_sub_cat.block_id           = page_blocks.block_id
                
                WHERE page_blocks.page_id = '$id'";
            });
        });
        
        return self::$load_sql_query_return;
    }

    private static function loop_blocks($blocks_array) {
        foreach ($blocks_array AS $key => $value) {
            if ($value["block_type"] === "wysiwyg") {
                self::load_wysiwyg($value);
            }
            elseif ($value["block_type"] === "plain_text") {
                self::load_plain_text($value);
            }
            elseif ($value["block_type"] === "image") {
                self::load_image($value);
            }
            elseif ($value["block_type"] === "create_columns") {
                self::load_create_columns($value);
            }
            elseif ($value["block_type"] === "subcategories") {
                self::load_subcategories($value);
            }


            self::$load_json[$value["building_blocks_area"]]["building_blocks_area"] = $value["building_blocks_area"];
        }
    }

    private static function load_wysiwyg($block_array) {
        $building_blocks_area   = $block_array["building_blocks_area"];
        $the_order              = $block_array["the_order"];

        self::$load_json[$building_blocks_area][$the_order] = array(
            "block_type"            => "wysiwyg",
            "block_id"              => $block_array["block_id"],
            "data"                  => $block_array["data"],
            "the_order"             => $the_order,
            "building_blocks_area"  => $building_blocks_area
        );
    }

    private static function load_plain_text($block_array) {
        $building_blocks_area   = $block_array["building_blocks_area"];
        $the_order              = $block_array["the_order"];

        self::$load_json[$building_blocks_area][$the_order] = array(
            "block_type"            => "plain_text",
            "block_id"              => $block_array["block_id"],
            "data"                  => $block_array["data"],
            "the_order"             => $the_order,
            "building_blocks_area"  => $building_blocks_area
        );
    }

    private static function load_image($block_array) {
        $building_blocks_area   = $block_array["building_blocks_area"];
        $the_order              = $block_array["the_order"];

        self::$load_json[$building_blocks_area][$the_order] = array(
            "block_type"            => "image",
            "block_id"              => $block_array["block_id"],
            "data"                  => $block_array["data"],
            "img_size_mode"         => $block_array["img_size_mode"],
            "img_width"             => $block_array["img_width"],
            "img_height"            => $block_array["img_height"],
            "image_align"           => $block_array["image_align"],
            "the_order"             => $the_order,
            "building_blocks_area"  => $building_blocks_area
        );
    }

    private static function load_subcategories($block_array) {
        $building_blocks_area   = $block_array["building_blocks_area"];
        $the_order              = $block_array["the_order"];

        self::$load_json[$building_blocks_area][$the_order] = array(
            "block_type"            => "subcategories",
            "block_id"              => $block_array["block_id"],
            "limit_type"            => $block_array["limit_type"],
            "the_limit"             => $block_array["the_limit"],
            "sort"                  => $block_array["sort"],
            "the_order"             => $the_order,
            "building_blocks_area"  => $building_blocks_area
        );
    }

    private static $load_create_columns_width_array;
    private static function load_create_columns($block_array) {
        $building_blocks_area   = $block_array["building_blocks_area"];
        $the_order              = $block_array["the_order"];

        $page_id    = $block_array["page_id"];
        $block_id   = $block_array["block_id"];
        self::$load_create_columns_width_array = array();
        database::reset();
        database::select("SELECT `page_id`, `block_id`, `column_id`, `width` FROM `page_cc_block` WHERE page_id='$page_id' AND block_id='$block_id'", function ($data) {
            self::$load_create_columns_width_array = $data["fetch_all"];
        });

        self::$load_json[$building_blocks_area][$the_order] = array(
            "block_type"            => "create_columns",
            "block_id"              => $block_array["block_id"],
            "width"                 => self::$load_create_columns_width_array,
            "the_order"             => $the_order,
            "building_blocks_area"  => $building_blocks_area,
        );
    }
}