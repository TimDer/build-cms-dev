<?php

class build_cms_media_images_area_pluginSubController extends controller {
    public static function get_images_html() {
        build_cms_media_pluginModal::$images_array = database::select("SELECT `id`, `the_file_name` FROM `media` WHERE `media_type`='image' ORDER BY `id` DESC");

        ob_start();
        
        self::getView("/images/images_html_SubView.php", __DIR__);

        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }
}