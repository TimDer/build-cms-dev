<?php

// Create page menu
plugins::set_menu_item("TD_Page_builder", "Pages", "", "author");
plugins::set_submenu_item("TD_Page_builder", "Add page", "/admin/pages", "author");
plugins::set_submenu_item("TD_Page_builder", "Edit pages", "/admin/pages/edit-pages", "author");

// define blocks
build_cms_page_builder_page_functions::define_block("wysiwyg", "Visual Editor");
build_cms_page_builder_page_functions::define_block("plain_text", "Plain text");
build_cms_page_builder_page_functions::define_block("create_columns", "Create-columns");
build_cms_page_builder_page_functions::define_block("subcategories", "Subcategories");