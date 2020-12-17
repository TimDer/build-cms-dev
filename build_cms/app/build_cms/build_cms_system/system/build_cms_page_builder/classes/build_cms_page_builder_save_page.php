<?php

class build_cms_page_builder_save_page {
    // save / add blocks
    public static function save_blocks($blocks_array, $building_blocks_area, $page_id, $create_columns_block = true) {
        foreach ($blocks_array as $key => $value) {
            $block_id   = $value['block_id'];
            $the_order  = $value['the_order'];
            $block_type = $value['block_type'];
            // add
            if ($value["block_status"] === "new") {
                if (isset(build_cms_page_builder_page_functions::$insert_block_functions[$value["block_type"]])) {
                    database::query("INSERT INTO `page_blocks` (`page_id`,
                                                                `block_type`,
                                                                `block_id`,
                                                                `building_blocks_area`,
                                                                `the_order`)
                                                        VALUES ('$page_id',
                                                                '$block_type',
                                                                '$block_id',
                                                                '$building_blocks_area',
                                                                '$the_order')");
                    $database_block_id = database::$conn->insert_id;
                    build_cms_page_builder_page_functions::$insert_block_functions[$value["block_type"]]->__invoke($value, $page_id, $database_block_id, $building_blocks_area);
                }
            }
            elseif ($value["block_status"] === "saved") {
                if (isset(build_cms_page_builder_page_functions::$update_block_functions[$value["block_type"]])) {
                    database::query("UPDATE `page_blocks` SET `page_id`='$page_id',
                                                    `block_type`='$block_type',
                                                    `block_id`='$block_id',
                                                    `building_blocks_area`='$building_blocks_area',
                                                    `the_order`='$the_order'
                                                    WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
                    $database_block_id = database::select("SELECT `id` FROM `page_blocks` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
                    build_cms_page_builder_page_functions::$update_block_functions[$value["block_type"]]->__invoke($value, $page_id, $database_block_id, $building_blocks_area);
                }
            }
        }
    }

    // add / save basics
    public static function basics($data_array) {
        if ($data_array["general_page_id"] === "new") {
            return self::add_basics($data_array);
        }
        else {
            return self::save_basics($data_array);
        }
    }

    /* ============================== add ============================== */
    public static function add_basics($data_array) {
        // general
        $general_pagename       = $data_array["general_pagename"];
        $general_url            = $data_array["general_url"];
        $general_status         = $data_array["general_status"];
        $choose_template        = ($data_array["general_template"] === "default") ? "" : $data_array["general_template"];
        if (isset($data_array["general_homepage"])) {
            $general_homepage   = "true";
            database::query("UPDATE `page` SET `home_page`='false'");
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

        // save data
        database::query("INSERT INTO `page` (`pagename`,
                                                `status`,
                                                `home_page`,
                                                `choose_template`,
                                                `url`,
                                                `pagetitle`,
                                                `author`,
                                                `keywords`,
                                                `description`,
                                                `post_page`)
                                        VALUES ('$general_pagename',
                                                '$general_status',
                                                '$general_homepage',
                                                '$choose_template',
                                                '$general_url',
                                                '$seo_pagetitle',
                                                '$seo_author',
                                                '$seo_keywords',
                                                '$seo_description',
                                                '$page_category')");
    
        // return auto_increment id
        if (database::$query) {
            return database::$conn->insert_id;
        }
        else {
            return 0;
        }
    }

    public static function add_subcategories($block_array, $page_id, $database_block_id) {
        $block_id   = $block_array['block_id'];
        
        // block data
        $subcategories_limit        = $block_array["data"]['subcategories_limit'];
        $subcategories_limit_number = $block_array["data"]['subcategories_limit_number'];
        $subcategories_order        = $block_array["data"]['subcategories_order'];

        database::query("INSERT INTO `page_sub_cat` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `limit_type`,
                                                        `the_limit`,
                                                        `sort`)
                                                VALUES ('$database_block_id',
                                                        '$page_id',
                                                        '$block_id',
                                                        '$subcategories_limit',
                                                        '$subcategories_limit_number',
                                                        '$subcategories_order')");
    }

    public static function add_create_columns($block_array, $page_id) {
        $block_id       = $block_array["block_id"];
        $width          = $block_array["data"]["width"];

        foreach ($width as $key_create_columns => $value_create_columns) {
            database::query("INSERT INTO `page_cc_block` (`page_id`,
                                                            `block_id`,
                                                            `column_id`,
                                                            `width`)
                                                    VALUES ('$page_id',
                                                            '$block_id',
                                                            " . $value_create_columns['width_id'] . ",
                                                            " . $value_create_columns['width'] . ")");
        }
    }

    public static function add_wysiwyg($block_array, $page_id, $database_block_id) {
        $wysiwyg_id = $block_array["block_id"];
        $data       = $block_array["data"]["data"];
        
        database::query("INSERT INTO `page_wysiwyg` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `data`)
                                                VALUES ('$database_block_id',
                                                        '$page_id',
                                                        '$wysiwyg_id',
                                                        '$data')");
    }

    public static function add_plain_text($block_array, $page_id, $database_block_id) {
        $plain_text_id  = $block_array["block_id"];
        $data           = $block_array["data"]["data"];
        
        database::query("INSERT INTO `page_plain_text` (`page_blocks_id`,
                                                        `page_id`,
                                                        `block_id`,
                                                        `data`)
                                                VALUES ('$database_block_id',
                                                        '$page_id',
                                                        '$plain_text_id',
                                                        '$data')");
    }
    
    /* ============================== /add ============================== */

    /* ============================== save ============================== */
    public static function save_basics($data_array) {
        // page id
        $id = $data_array["general_page_id"];

        // general
        $general_pagename       = $data_array["general_pagename"];
        $general_url            = $data_array["general_url"];
        $general_status         = $data_array["general_status"];
        $choose_template        = ($data_array["general_template"] === "default") ? "" : $data_array["general_template"];
        if (isset($data_array["general_homepage"])) {
            $general_homepage   = "true";
            database::query("UPDATE `page` SET `home_page`='false'");
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

        // time_stamp
        $time_stamp         = $data_array["general_time_stamp"];

        database::query("UPDATE `page` SET `pagename`='$general_pagename',
                                            `status`='$general_status',
                                            `home_page`='$general_homepage',
                                            `choose_template`='$choose_template',
                                            `url`='$general_url',
                                            `pagetitle`='$seo_pagetitle',
                                            `author`='$seo_author',
                                            `keywords`='$seo_keywords',
                                            `description`='$seo_description',
                                            `post_page`='$page_category',
                                            `time_stamp`='$time_stamp'
                                            WHERE id = '$id'");

        return $id;
    }

    public static function save_subcategories($block_array, $page_id) {
        $block_id   = $block_array['block_id'];
        
        // block data
        $subcategories_limit        = $block_array["data"]['subcategories_limit'];
        $subcategories_limit_number = $block_array["data"]['subcategories_limit_number'];
        $subcategories_order        = $block_array["data"]['subcategories_order'];

        database::query("UPDATE `page_sub_cat` SET `limit_type`='$subcategories_limit',
                                                    `the_limit`='$subcategories_limit_number',
                                                    `sort`='$subcategories_order'
                                                    WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    public static function save_wysiwyg($block_array, $page_id) {
        $wysiwyg_id = $block_array["block_id"];
        $data       = $block_array["data"]["data"];

        // update data
        database::query("UPDATE `page_wysiwyg` SET `data`='$data' WHERE `page_id`='$page_id' AND `block_id`='$wysiwyg_id'");
    }
    
    public static function save_plain_text($block_array, $page_id) {
        $plain_text_id  = $block_array["block_id"];
        $data           = $block_array["data"]["data"];

        // update data
        database::query("UPDATE `page_plain_text` SET `data`='$data' WHERE `page_id`='$page_id' AND `block_id`='$plain_text_id'");
    }

    public static function save_create_columns($block_array, $page_id) {
        $block_id       = $block_array["block_id"];
        $width          = $block_array["data"]["width"];
        
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
        }

        // remove deleted columns
        
        for ($column_num_delete = end($width)["width_id"] + 1; $column_num_delete <= 12; $column_num_delete++) { 
            database::query("DELETE FROM `page_cc_block` WHERE `page_id`=$page_id AND `block_id`='$block_id' AND `column_id`='$column_num_delete'");
        }
    }
    /* ============================== /save ============================== */

    /* ============================== del ============================== */
    public static function delete_blocks($blocks_array, $page_id) {
        foreach ($blocks_array as $key => $value) {
            self::del_block($value, $page_id);
        }
    }

    public static function del_block($block_array, $page_id) {
        $block_id = $block_array["block_id"];

        if ($block_array["block_type"] === "plain_text") {
            database::query("DELETE FROM `page_plain_text` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif ($block_array["block_type"] === "wysiwyg") {
            database::query("DELETE FROM `page_wysiwyg` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif ($block_array["block_type"] === "subcategories") {
            database::query("DELETE FROM `page_sub_cat` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
        }
        elseif ($block_array["block_type"] === "create_columns") {
            database::query("DELETE FROM `page_cc_block` WHERE `block_id`='$block_id' AND `page_id`='$page_id'");
        }
        else {
            build_cms_page_builder_page_functions::$delete_block_functions[$block_array["block_type"]]->__invoke($block_array, $page_id);
        }
        
        database::query("DELETE FROM `page_blocks` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }
    /* ============================== /del ============================== */
}