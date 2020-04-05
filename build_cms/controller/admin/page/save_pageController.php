<?php

class save_pageController extends controller {
    public static function save_pages() {
        // Save the basics and get the page id
        $page_id = self::basics(user_url::$post_var);
        // building-blocks
        foreach (user_url::$post_var["building-blocks"] AS $building_blocks_key => $building_blocks_value) {
            self::save_blocks($building_blocks_value, (string)$building_blocks_key, $page_id);
        }

        // Delete blocks
        if (isset(user_url::$post_var["del_blocks_array"])) {
            self::delete_blocks(user_url::$post_var["del_blocks_array"], $page_id);
        }

        header("Content-type: text/javascript");

        $return_json = array(
            "page_id"       => $page_id,
            "status"        => "success",
            "time_stamp"    => date("Y-m-d G:i:s")
        );

        echo json_encode( $return_json );
    }

    // save / add blocks
    private static function save_blocks($blocks_array, $building_blocks_area, $page_id, $create_columns_block = true) {
        foreach ($blocks_array as $key => $value) {
            // add
            if ($value["status"] === "new") {
                if ($value["block_type"] === "create_columns" AND $create_columns_block) {
                    self::add_create_columns($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "wysiwyg") {
                    self::add_wysiwyg($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "plain_text") {
                    self::add_plain_text($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "image") {
                    self::add_image($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "subcategories") {
                    self::add_subcategories($value, $building_blocks_area, $page_id);
                }
            }
            elseif ($value["status"] === "saved") {
                if ($value["block_type"] === "create_columns" AND $create_columns_block) {
                    self::save_create_columns($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "wysiwyg") {
                    self::save_wysiwyg($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "plain_text") {
                    self::save_plain_text($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "image") {
                    self::save_image($value, $building_blocks_area, $page_id);
                }
                elseif ($value["block_type"] === "subcategories") {
                    self::save_subcategories($value, $building_blocks_area, $page_id);
                }
            }
        }
    }

    // add / save basics
    private static function basics($data_array) {
        if ($data_array["general_page_id"] === "new") {
            return self::add_basics($data_array);
        }
        else {
            return self::save_basics($data_array);
        }
    }

    /* ============================== add ============================== */
    private static function add_basics($data_array) {
        // general
        $general_pagename       = $data_array["general_pagename"];
        $general_url            = $data_array["general_url"];
        $general_status         = $data_array["general_status"];
        if (isset($data_array["general_homepage"])) {
            $general_homepage   = "true";
        }
        else {
            $general_homepage   = "false";
        }

        // SEO
        $seo_pagetitle      = $data_array["seo_pagetitle"];
        $seo_author         = $data_array["seo_author"];
        $seo_keywords       = $data_array["seo_keywords"];
        $seo_description    = $data_array["seo_description"];

        // category
        $page_category      = $data_array["page_category"];

        // category info
        $info_image         = $data_array["category_info"]["image"];
        $info_text          = $data_array["category_info"]["text"];

        // save data
        database::query("INSERT INTO `page` (`pagename`,
                                                `status`,
                                                `home_page`,
                                                `url`,
                                                `pagetitle`,
                                                `author`,
                                                `keywords`,
                                                `description`,
                                                `post_page`,
                                                `category_image`,
                                                `category_text`)
                                        VALUES ('$general_pagename',
                                                '$general_status',
                                                '$general_homepage',
                                                '$general_url',
                                                '$seo_pagetitle',
                                                '$seo_author',
                                                '$seo_keywords',
                                                '$seo_description',
                                                '$page_category',
                                                '$info_image',
                                                '$info_text')");
    
        // return auto_increment id
        if (database::$query) {
            return database::$conn->insert_id;
        }
        else {
            return 0;
        }
    }

    private static function add_subcategories($block_array, $building_blocks_area, $page_id) {
        $block_id   = $block_array['block_id'];
        $the_order  = $block_array['the_order'];
        
        // block data
        $subcategories_limit        = $block_array['subcategories_limit'];
        $subcategories_limit_number = $block_array['subcategories_limit_number'];
        $subcategories_order        = $block_array['subcategories_order'];

        database::query("INSERT INTO `page_blocks` (`page_id`,
                                                    `block_type`,
                                                    `block_id`,
                                                    `building_blocks_area`,
                                                    `the_order`)
                                            VALUES ('$page_id',
                                                    'subcategories',
                                                    '$block_id',
                                                    '$building_blocks_area',
                                                    '$the_order')");

        $page_blocks_id = database::$conn->insert_id;
        database::query("INSERT INTO `page_sub_cat` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `limit_type`,
                                                        `the_limit`,
                                                        `sort`)
                                                VALUES ('$page_blocks_id',
                                                        '$page_id',
                                                        '$block_id',
                                                        '$subcategories_limit',
                                                        '$subcategories_limit_number',
                                                        '$subcategories_order')");
    }

    private static function add_create_columns($block_array, $building_blocks_area, $page_id) {
        $the_order      = $block_array["the_order"];
        $block_id       = $block_array["block_id"];
        $width          = $block_array["width"];
        
        if (isset($block_array["data"])) {
            $data       = $block_array["data"];
        }
        else {
            $data       = array();
        }

        
        database::query("INSERT INTO `page_blocks` (`page_id`,
                                                    `block_type`,
                                                    `block_id`,
                                                    `building_blocks_area`,
                                                    `the_order`)
                                            VALUES ('$page_id',
                                                    'create_columns',
                                                    '$block_id',
                                                    '$building_blocks_area',
                                                    '$the_order')");

        foreach ($width as $key_create_columns => $value_create_columns) {
            database::query("INSERT INTO `page_cc_block` (`page_id`,
                                                                        `block_id`,
                                                                        `column_id`,
                                                                        `width`)
                                                                VALUES ('$page_id',
                                                                        '$block_id',
                                                                        " . $value_create_columns['width_id'] . ",
                                                                        " . $value_create_columns['width'] . ")");
            
            $building_blocks_area_create_columns = $block_id . "-" . $value_create_columns['width_id'];
            if (isset($data[$key_create_columns])) {
                self::save_blocks(
                    $data[$key_create_columns],
                    $building_blocks_area_create_columns,
                    $page_id,
                    false
                );
            }
        }
    }

    private static function add_wysiwyg($block_array, $building_blocks_area, $page_id) {
        $wysiwyg_id = $block_array["wysiwyg_id"];
        $the_order  = $block_array["the_order"];
        $data       = $block_array["data"];

        // page_blocks table
        database::query("INSERT INTO `page_blocks` (`page_id`,
                                                    `block_type`,
                                                    `block_id`,
                                                    `building_blocks_area`,
                                                    `the_order`)
                                            VALUES  ('$page_id',
                                                        'wysiwyg',
                                                        '$wysiwyg_id',
                                                        '$building_blocks_area',
                                                        '$the_order')");
        
        // page_wysiwyg table
        $page_blocks_id = database::$conn->insert_id;
        database::query("INSERT INTO `page_wysiwyg` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `data`)
                                                VALUES ('$page_blocks_id',
                                                        '$page_id',
                                                        '$wysiwyg_id',
                                                        '$data')");
    }

    private static function add_plain_text($block_array, $building_blocks_area, $page_id) {
        $plain_text_id  = $block_array["plain-text_id"];
        $data           = $block_array["data"];
        $the_order      = $block_array["the_order"];

        // page_blocks table
        database::query("INSERT INTO `page_blocks` (`page_id`,
                                                    `block_type`,
                                                    `block_id`,
                                                    `building_blocks_area`,
                                                    `the_order`)
                                            VALUES ('$page_id',
                                                    'plain_text',
                                                    '$plain_text_id',
                                                    '$building_blocks_area',
                                                    '$the_order')");
        
        // page_plain_text table
        $page_blocks_id = database::$conn->insert_id;
        database::query("INSERT INTO `page_plain_text` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `data`)
                                                VALUES ('$page_blocks_id',
                                                        '$page_id',
                                                        '$plain_text_id',
                                                        '$data')");
    }

    private static function add_image($block_array, $building_blocks_area, $page_id) {
        $block_id       = $block_array["image_id"];
        $data           = $block_array["filename/data"];
        $img_size_mode  = $block_array["img_size_mode"];
        $img_width      = $block_array["img_width"];
        $img_height     = $block_array["img_height"];
        $align          = $block_array["align"];
        $the_order      = $block_array["the_order"];

        database::query("INSERT INTO `page_blocks` (`page_id`,
                                                    `block_type`,
                                                    `block_id`,
                                                    `building_blocks_area`,
                                                    `the_order`)
                                            VALUES ('$page_id',
                                                    'image',
                                                    '$block_id',
                                                    '$building_blocks_area',
                                                    '$the_order')");
        
        $page_blocks_id = database::$conn->insert_id;
        database::query("INSERT INTO `page_img_block` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `image`,
                                                        `img_size_mode`,
                                                        `img_width`,
                                                        `img_height`,
                                                        `image_align`)
                                                VALUES ('$page_blocks_id',
                                                        '$page_id',
                                                        '$block_id',
                                                        '$data',
                                                        '$img_size_mode',
                                                        '$img_width',
                                                        '$img_height',
                                                        '$align')");
    }
    /* ============================== /add ============================== */

    /* ============================== save ============================== */
    private static function save_basics($data_array) {
        // page id
        $id = $data_array["general_page_id"];

        // general
        $general_pagename       = $data_array["general_pagename"];
        $general_url            = $data_array["general_url"];
        $general_status         = $data_array["general_status"];
        if (isset($data_array["general_homepage"])) {
            $general_homepage   = true;
        }
        else {
            $general_homepage   = false;
        }

        // SEO
        $seo_pagetitle      = $data_array["seo_pagetitle"];
        $seo_author         = $data_array["seo_author"];
        $seo_keywords       = $data_array["seo_keywords"];
        $seo_description    = $data_array["seo_description"];

        // category
        $page_category      = $data_array["page_category"];

        // category info
        $info_image         = $data_array["category_info"]["image"];
        $info_text          = $data_array["category_info"]["text"];

        // time_stamp
        $time_stamp         = $data_array["general_time_stamp"];

        database::query("UPDATE `page` SET `pagename`='$general_pagename',
                                            `status`='$general_status',
                                            `home_page`='$general_homepage',
                                            `url`='$general_url',
                                            `pagetitle`='$seo_pagetitle',
                                            `author`='$seo_author',
                                            `keywords`='$seo_keywords',
                                            `description`='$seo_description',
                                            `post_page`='$page_category',
                                            `category_image`='$info_image',
                                            `category_text`='$info_text',
                                            `time_stamp`='$time_stamp'
                                            WHERE id = '$id'");

        return $id;
    }

    private static function save_subcategories($block_array, $building_blocks_area, $page_id) {
        $block_id   = $block_array['block_id'];
        $the_order  = $block_array['the_order'];
        
        // block data
        $subcategories_limit        = $block_array['subcategories_limit'];
        $subcategories_limit_number = $block_array['subcategories_limit_number'];
        $subcategories_order        = $block_array['subcategories_order'];

        database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='subcategories',
                                                    `block_id`='$block_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE `page_id`='$page_id' AND `block_id`='$block_id'");

        database::query("UPDATE `page_sub_cat` SET `limit_type`='$subcategories_limit',
                                                    `the_limit`='$subcategories_limit_number',
                                                    `sort`='$subcategories_order'
                                                    WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    private static function save_wysiwyg($block_array, $building_blocks_area, $page_id) {
        $wysiwyg_id = $block_array["wysiwyg_id"];
        $the_order  = $block_array["the_order"];
        $data       = $block_array["data"];

        // update block
        database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='wysiwyg',
                                                    `block_id`='$wysiwyg_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE page_id='$page_id' AND block_id='$wysiwyg_id'");

        // update data
        database::query("UPDATE `page_wysiwyg` SET `data`='$data' WHERE `page_id`='$page_id' AND `block_id`='$wysiwyg_id'");
    }
    
    private static function save_plain_text($block_array, $building_blocks_area, $page_id) {
        $plain_text_id  = $block_array["plain-text_id"];
        $data           = $block_array["data"];
        $the_order      = $block_array["the_order"];

        database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='plain_text',
                                                    `block_id`='$plain_text_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE page_id='$page_id' AND block_id='$plain_text_id'");

        // update data
        database::query("UPDATE `page_plain_text` SET `data`='$data' WHERE `page_id`='$page_id' AND `block_id`='$plain_text_id'");
    }

    private static function save_image($block_array, $building_blocks_area, $page_id) {
        $block_id       = $block_array["image_id"];
        $data           = $block_array["filename/data"];
        $img_size_mode  = $block_array["img_size_mode"];
        $img_width      = $block_array["img_width"];
        $img_height     = $block_array["img_height"];
        $align          = $block_array["align"];
        $the_order      = $block_array["the_order"];


        database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='image',
                                                    `block_id`='$block_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE page_id='$page_id' AND block_id='$block_id'");

        database::query("UPDATE `page_img_block` SET `image`='$data',
                                                        `img_size_mode`='$img_size_mode',
                                                        `img_width`='$img_width',
                                                        `img_height`='$img_height',
                                                        `image_align`='$align'
                                                        WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    private static function save_create_columns($block_array, $building_blocks_area, $page_id) {
        $the_order      = $block_array["the_order"];
        $block_id       = $block_array["block_id"];
        $width          = $block_array["width"];
        
        if (isset($block_array["data"])) {
            $data       = $block_array["data"];
        }
        else {
            $data       = array();
        }

        database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='create_columns',
                                                    `block_id`='$block_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        
        foreach ($width as $key_create_columns => $value_create_columns) {
            database::select("SELECT * FROM `page_cc_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id' AND `column_id`=" . $value_create_columns['width_id'],
                // update row
                function ($data) {
                    $page_id    = $data['page_id'];
                    $block_id   = $data['block_id'];
                    $width_id   = $data['width_id'];
                    $width      = $data['width'];
                    database::query("UPDATE `page_cc_block` SET `page_id`='$page_id',
                                                                            `block_id`='$block_id',
                                                                            `column_id`='$width_id',
                                                                            `width`='$width'
                                                                            WHERE `page_id`='$page_id' AND `block_id`='$block_id' AND `column_id`='$width_id'");
                }, array(
                    "page_id" => $page_id,
                    "block_id" => $block_id,
                    "width_id" => $value_create_columns['width_id'],
                    "width" => $value_create_columns['width']
                ),
                // add new row
                function ($data) {
                    $page_id    = $data['page_id'];
                    $block_id   = $data['block_id'];
                    $width_id   = $data['width_id'];
                    $width      = $data['width'];
                    database::query("INSERT INTO `page_cc_block` (`page_id`,
                                                                                `block_id`,
                                                                                `column_id`,
                                                                                `width`)
                                                                        VALUES ('$page_id',
                                                                                '$block_id',
                                                                                '$width_id',
                                                                                '$width')");
                }, array(
                    "page_id" => $page_id,
                    "block_id" => $block_id,
                    "width_id" => $value_create_columns['width_id'],
                    "width" => $value_create_columns['width']
                )
            );
            
            $building_blocks_area_create_columns = $block_id . "-" . $value_create_columns['width_id'];
            if (isset($data[$key_create_columns])) {
                self::save_blocks(
                    $data[$key_create_columns],
                    $building_blocks_area_create_columns,
                    $page_id,
                    false
                );
            }
        }

        // remove deleted columns
        
        for ($column_num_delete= end($width)["width_id"] + 1; $column_num_delete <= 12; $column_num_delete++) { 
            database::query("DELETE FROM `page_cc_block` WHERE `page_id`=$page_id AND `block_id`='$block_id' AND `column_id`='$column_num_delete'");
        }
    }
    /* ============================== /save ============================== */

    /* ============================== del ============================== */
    private static function delete_blocks($blocks_array, $page_id) {
        foreach ($blocks_array as $key => $value) {
            if ($value["block_type"] === "create_columns") {
                self::del_create_columns($value, $page_id);
            }
            else {
                self::del_block($value, $page_id);
            }
        }
    }

    private static function del_block($block_array, $page_id) {
        if (isset($block_array["plain-text_id"])) {
            $block_id = $block_array["plain-text_id"];
            database::query("DELETE FROM `page_plain_text` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif (isset($block_array["image_id"])) {
            $block_id = $block_array["image_id"];
            database::query("DELETE FROM `page_img_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif (isset($block_array["wysiwyg_id"])) {
            $block_id = $block_array["wysiwyg_id"];
            database::query("DELETE FROM `page_wysiwyg` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif (isset($block_array["block_id"]) AND $block_array["block_type"] === "subcategories") {
            $block_id = $block_array["block_id"];
            database::query("DELETE FROM `page_sub_cat` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        
        database::query("DELETE FROM `page_blocks` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    private static function del_create_columns($block_array, $page_id) {
        $block_id = $block_array["block_id"];

        database::query("DELETE FROM `page_blocks` WHERE `block_id`='$block_id' AND `page_id`='$page_id'");
        database::query("DELETE FROM `page_cc_block` WHERE `block_id`='$block_id' AND `page_id`='$page_id'");

        if (isset($block_array["data"])) {
            foreach ($block_array["data"] as $key => $value) {
                self::delete_blocks($value, $page_id);
            }
        }
    }
    /* ============================== /del ============================== */

    /* ============================== del page ============================== */
    public static function delete_page() {
        database::reset();
        $page_id = database::escape( user_url::$new_uri )[0];
        database::query("DELETE FROM `page` WHERE id='$page_id'");
        database::query("DELETE FROM `page_blocks` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_cc_block` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_img_block` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_plain_text` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_sub_cat` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_wysiwyg` WHERE page_id='$page_id'");
        database::reset();
    }
    /* ============================== /del page ============================== */
}