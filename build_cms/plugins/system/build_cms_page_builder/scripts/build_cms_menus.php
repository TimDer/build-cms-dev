<?php

pluginClass_build_cms_menus_customItems::set_custom_item_name("page", function ($a, $b, $id) {
    return build_cms_page_builder_menus_pluginSubController::set_custom_item_name($id);
});