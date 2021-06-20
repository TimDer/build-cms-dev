<?php

class buildCmsTemplateLoaderController extends controller {
    public static function get_template() {
        if (file_exists( templateLoader::base_template_dir("/" . templateLoader::$template_file) )) {
            $functions = config_dir::BASE("/templates/" . templateLoader::$template_dir . "/functions.php");
            if (file_exists($functions)) {
                require $functions;
            }
            require config_dir::BASE("/templates/" . templateLoader::$template_dir . "/" . templateLoader::$template_file);
        }
        else {
            self::getView("/fornt-end/select-template.php");
        }
    }
}