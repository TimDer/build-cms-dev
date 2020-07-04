<?php

class pluginClass_build_cms_media {
    public static function add_image($block_array, $page_id, $page_blocks_id) {
        $block_id       = $block_array["data"]["image_id"];
        $data           = $block_array["data"]["filename/data"];
        $img_size_mode  = $block_array["data"]["img_size_mode"];
        $img_width      = $block_array["data"]["img_width"];
        $img_height     = $block_array["data"]["img_height"];
        $align          = $block_array["data"]["align"];
        
        //$page_blocks_id = database::$conn->insert_id;
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

    public static function save_image($block_array, $page_id) {
        $block_id       = $block_array["data"]["image_id"];
        $data           = $block_array["data"]["filename/data"];
        $img_size_mode  = $block_array["data"]["img_size_mode"];
        $img_width      = $block_array["data"]["img_width"];
        $img_height     = $block_array["data"]["img_height"];
        $align          = $block_array["data"]["align"];

        database::query("UPDATE `page_img_block` SET `image`='$data',
                                                        `img_size_mode`='$img_size_mode',
                                                        `img_width`='$img_width',
                                                        `img_height`='$img_height',
                                                        `image_align`='$align'
                                                        WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    public static function delete_image_block($block_array, $page_id) {
        $block_id = $block_array["block_id"];
        database::query("DELETE FROM `page_img_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");
    }

    public static function delete_page($page_id) {
        database::query("DELETE FROM `page_img_block` WHERE page_id='$page_id'");
    }
}