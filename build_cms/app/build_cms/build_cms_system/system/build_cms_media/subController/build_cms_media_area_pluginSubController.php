<?php

class build_cms_media_area_pluginSubController extends controller {
    private static function ob_html($function) {
        ob_start();
        
        $function->__invoke();

        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    public static function get_images_html() {
        build_cms_media_pluginModal::$data_array = database::select("SELECT `id`, `the_file_name` FROM `media` WHERE `media_type`='image' ORDER BY `id` DESC");

        if (!empty(build_cms_media_pluginModal::$data_array)) {
            return self::ob_html(function () {
                self::getView("/images/images_html_SubView.php", __DIR__);
            });
        }
        else {
            return "";
        }
    }

    public static function get_downloads_html() {
        build_cms_media_pluginModal::$data_array = database::select("SELECT `id`, `the_file_name` FROM `media` WHERE `media_type`='download' ORDER BY `id` DESC");

        if (!empty(build_cms_media_pluginModal::$data_array)) {
            return self::ob_html(function () {
                self::getView("/downloads/downloads_html_SubView.php", __DIR__);
            });
        }
        else {
            return "";
        }
    }
}