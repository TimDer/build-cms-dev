<?php

class buildCmsTemplateLoader_pluginController extends controller {
    public static function get_template() {
        if (file_exists( templateLoaderFiles::base_template_dir("/" . templateLoaderFiles::$template_file) )) {
            $functions = config_dir::PLUGINDIR(__DIR__, "/view/templates/" . templateLoaderFiles::$template_dir . "/functions.php ");
            if (file_exists($functions)) {
                require $functions;
            }
            self::getView("/templates/" . templateLoaderFiles::$template_dir . "/" . templateLoaderFiles::$template_file, __DIR__);
        }
        else {
            echo "nope";
        }
    }
}