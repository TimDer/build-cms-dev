<?php

pluginClass_build_cms_menus_customItems::set_custom_item("custom", function ($id, $name, $url) {
    build_cms_page_builder_menuPlugin_pluginSubController::page_menu_item($id, $name, $url);
});