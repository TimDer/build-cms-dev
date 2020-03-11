<?php

class buildCmsTemplateLoader_pluginController extends controller {
    public static function get_template() {
        if (file_exists( templateLoaderFiles::base_template_dir("/" . templateLoaderFiles::$template_file) )) {
            self::getView("/templates/" . templateLoaderFiles::$template_dir . "/" . templateLoaderFiles::$template_file, __DIR__);
        }
        else {
            echo "nope";
        }
    }
}