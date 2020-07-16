<?php

class add_pageController extends controller {
    public static function get_add_page() {
        // set head and footer files
        self::set_head("/admin/page/add/head.php");
        self::set_footer("/admin/page/add/footer.php");

        if (!empty(page_functions::$custom_page_js_footer)) {
            foreach (page_functions::$custom_page_js_footer AS $footer) {
                self::set_footer($footer["path"], $footer["location"]);
            }
        }

        if (!empty(page_functions::$custom_page_css_head)) {
            foreach (page_functions::$custom_page_css_head AS $head) {
                self::set_head($head["path"], $head["location"]);
            }
        }

        // setup page array
        add_page_loaderBack::get_page_array();

        // set modal
        add_page_loaderBack::set_modal();

        // set template array
        add_page_loaderBack::set_template_array();

        // load view
        self::getAdminTemplateView("/admin/page/add/add-page.php");
    }
}