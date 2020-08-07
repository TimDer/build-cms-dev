<?php

require_once config_dir::PLUGINDIR(__DIR__, "/scripts/image_block_define.php");

plugins::set_menu_item("build_cms_media", "Media", "", "author");
plugins::set_submenu_item("build_cms_media", "Images", "/admin/media/images", "author");
plugins::set_submenu_item("build_cms_media", "Downloads", "/admin/media/downloads", "author");