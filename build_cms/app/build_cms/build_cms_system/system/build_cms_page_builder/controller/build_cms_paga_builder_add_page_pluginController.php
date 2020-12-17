<?php

class build_cms_paga_builder_add_page_pluginController extends controller {
    public static function get_add_page() {
        // set head and footer files
        self::set_head("/add/head.php", __DIR__);
        self::set_footer("/add/footer.php", __DIR__);

        if (!empty(build_cms_page_builder_page_functions::$custom_page_js_footer)) {
            foreach (build_cms_page_builder_page_functions::$custom_page_js_footer AS $footer) {
                self::set_footer($footer["path"], $footer["location"]);
            }
        }

        if (!empty(build_cms_page_builder_page_functions::$custom_page_css_head)) {
            foreach (build_cms_page_builder_page_functions::$custom_page_css_head AS $head) {
                self::set_head($head["path"], $head["location"]);
            }
        }

        // setup page array
        build_cms_page_builder_add_page_loaderBack::get_page_array();

        // set modal
        build_cms_page_builder_add_page_loaderBack::set_modal();

        // set template array
        build_cms_page_builder_add_page_loaderBack::set_template_array();

        // load view
        self::getAdminTemplateView("/add/add-page.php", __DIR__);
    }
}