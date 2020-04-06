<?php

class buildCmsTemplateLoaderController extends controller {
    public static function get_template() {
        if (file_exists( templateLoaderFiles::base_template_dir("/" . templateLoaderFiles::$template_file) )) {
            $functions = config_dir::BASE("/view/templates/" . templateLoaderFiles::$template_dir . "/functions.php ");
            if (file_exists($functions)) {
                require $functions;
            }
            self::getView("/templates/" . templateLoaderFiles::$template_dir . "/" . templateLoaderFiles::$template_file);
        }
        else {
            echo "nope";
        }
    }
}