<?php

require config_dir::PLUGINDIR(__DIR__, "/scripts/menu.php");
require config_dir::PLUGINDIR(__DIR__, "/scripts/blocks.php");
require config_dir::PLUGINDIR(__DIR__, "/scripts/template_loader_head.php");

// set template (page builder)
build_cms_page_builder_template_loader::set_template();

// set default page builder areas
build_cms_page_builder_template_loader::set_building_blocks_area("category-info", "Category info");