<?php

if (class_exists( "pluginClass_build_cms_menus_customAreas" )) {
    pluginClass_build_cms_menus_customItems::set_custom_item_name("page", function ($a, $b, $id) {
        return build_cms_page_builder_menus_pluginSubController::set_custom_item_name($id);
    });
    
    pluginClass_build_cms_menus_customAreas::set_custom_area("page", function () {
        build_cms_page_builder_menus_pluginSubController::set_custom_area();
    });

    pluginClass_build_cms_menus_customAreas::set_custom_head("page", "/build_cms_menus/head.php", __DIR__);
    pluginClass_build_cms_menus_customAreas::set_custom_footer("page", "/build_cms_menus/footer.php", __DIR__);
}