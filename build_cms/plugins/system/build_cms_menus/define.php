<?php

require config_dir::PLUGINDIR(__DIR__, "/scripts/build_cms_menus.php");

plugins::set_submenu_item("system-settings", "Menus", "/admin/settings/menus", "author");