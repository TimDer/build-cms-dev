<?php

// set the base url
config_url::displayUntrustedDomain();

// connect to the database
database::connect();

// Create dashboard menu
plugins::set_menu_item("system-dashboard", "Dashboard", "/admin/dashboard", "user");

// Create page menu
plugins::set_menu_item("TD_Page_builder", "Pages", "", "author");
plugins::set_submenu_item("TD_Page_builder", "Add page", "/admin/pages", "author");
plugins::set_submenu_item("TD_Page_builder", "Edit pages", "/admin/pages/edit-pages", "author");

// Create settings menu
plugins::set_menu_item("system-settings", "Settings", "", "admin");
plugins::set_submenu_item("system-settings", "General", "/admin/settings/general", "admin");

// query the template folder name from the database
templateLoader::set_template_base_dir();

// call plugin definer and routes
plugins::call_plugins();

// call template definer
templateLoader::call_template_definer();

// set default page builder areas
plugins::set_building_blocks_area("building-blocks-area", "content", "Content", "block");
plugins::set_building_blocks_area("sortable-building-blocks-left", "left_sidebar", "Left sidebar");
plugins::set_building_blocks_area("sortable-building-blocks-right", "right_sidebar", "Right sidebar");
plugins::set_building_blocks_area("building-blocks-area-category-info", "category-info", "Category info");

// set template loader link in settings menu
plugins::set_submenu_item("system-settings", "Templates", "/admin/settings/template_loader", "admin");

// Create plugins menu
plugins::set_menu_item("system-plugins", "Plugins", "", "admin");
plugins::set_submenu_item("system-plugins", "Install a plugin", "/admin/plugins/install", "admin");
plugins::set_submenu_item("system-plugins", "Create a new plugin", "/admin/plugins/create", "admin");
plugins::set_submenu_item("system-plugins", "Plugins", "/admin/plugins/plugins", "admin");

// set settings to the end of the array
if (isset(plugins::$main_menu_items["system-settings"])) {
    $settings = plugins::$main_menu_items["system-settings"];
    unset(plugins::$main_menu_items["system-settings"]);
    plugins::$main_menu_items["system-settings"] = $settings;
}

// set users to the end of the array
plugins::set_submenu_item("system-settings", "Users", "/admin/settings/users", "admin");