<?php

class buildCmsTemplateLoaderController extends controller {
    public static function get_template() {
        if (file_exists( templateLoader::base_template_dir("/" . templateLoader::$template_file) )) {
            $functions = config_dir::BASE("/view/templates/" . templateLoader::$template_dir . "/functions.php");
            if (file_exists($functions)) {
                require $functions;
            }
            self::getView("/templates/" . templateLoader::$template_dir . "/" . templateLoader::$template_file);
        }
        else {
            echo "nope";
        }
    }
}