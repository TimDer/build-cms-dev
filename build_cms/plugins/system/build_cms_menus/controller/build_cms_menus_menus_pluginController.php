<?php

class build_cms_menus_menus_pluginController extends controller {
    public static function get_menus() {
        self::set_head("/head.php", __DIR__);
        self::set_footer("/footer.php", __DIR__);

        if (class_exists("build_cms_page_builder_page_functions")) {
            build_cms_menus_pluginModal::$menus_names_array = database::select("SELECT `id`, `menu_name` FROM `menu_name`");

            if (isset(user_url::$get_var["editMenuId"])) {
                $id = user_url::$get_var["editMenuId"];
                build_cms_menus_pluginModal::$menus_data_array = pluginClass_build_cms_menus::query_menu_fix(
                    database::select("SELECT `id`, `the_name`, `the_url`, `type`, `parent_id` FROM `menu_content` WHERE `menu_name_id`='$id' ORDER BY `the_order` ASC")
                );
            }
    
            self::getAdminTemplateView("/menus.php", __DIR__);
        }
        else {
            self::getAdminTemplateView("/needs_page_builder.php", __DIR__);
        }
    }
}