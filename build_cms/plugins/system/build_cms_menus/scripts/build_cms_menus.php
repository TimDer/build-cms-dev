<?php

pluginClass_build_cms_menus_customItems::set_custom_item("custom", function ($id, $name, $url) {
    build_cms_page_builder_menuPlugin_pluginSubController::page_menu_item($id, $name, $url);
});

pluginClass_build_cms_menus_customItems::set_custom_item_save("custom", function ($array) {
    build_cms_menus_menus_pluginController::save_menu_custom($array);
});