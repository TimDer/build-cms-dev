<?php

class media_loadImageBlock_pluginController extends controller {
    public static function author_get_image_block($data) {
        $db_block_id = $data["db_block_id"];
        $sql = database::select("SELECT `image`, `img_size_mode`, `img_width`, `img_height`, `image_align` FROM `page_img_block` WHERE `page_blocks_id`='$db_block_id'")[0];
        
        media_loadImageBlock_pluginModal::$block_id         = $data["block_id"];
        media_loadImageBlock_pluginModal::$image            = $sql["image"];
        media_loadImageBlock_pluginModal::$img_size_mode    = $sql["img_size_mode"];
        media_loadImageBlock_pluginModal::$img_width        = $sql["img_width"];
        media_loadImageBlock_pluginModal::$img_height       = $sql["img_height"];
        media_loadImageBlock_pluginModal::$image_align      = $sql["image_align"];

        // image align
        if ($sql["image_align"] === "center") {
            media_loadImageBlock_pluginModal::$image_content_align = " align_image_center";
        }
        elseif ($sql["image_align"] === "right") {
            media_loadImageBlock_pluginModal::$image_content_align = " align_image_right";
        }
        elseif ($sql["image_align"] === "left") {
            media_loadImageBlock_pluginModal::$image_content_align = "";
        }

        if ($sql["img_size_mode"] === "custom") {
            media_loadImageBlock_pluginModal::$img_size = 'width="' . $sql["img_width"] . '" height="' . $sql["img_height"] . '"';
        }
        else {
            media_loadImageBlock_pluginModal::$img_size = '';
        }
        
        self::getView("/admin/load_author_block.php", __DIR__);
    }
}