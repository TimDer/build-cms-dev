<?php

class build_cms_page_builder_edit_page_pluginController extends controller {
    public static function get_select_page() {
        // set head and footer files
        self::set_head("/edit/head.php", __DIR__);
        self::set_footer("/edit/footer.php", __DIR__);

        // load view
        self::getAdminTemplateView("/edit/edit-page.php", __DIR__);
    }
}