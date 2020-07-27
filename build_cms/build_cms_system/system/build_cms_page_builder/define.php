<?php

// Create page menu
plugins::set_menu_item("TD_Page_builder", "Pages", "", "author");
plugins::set_submenu_item("TD_Page_builder", "Add page", "/admin/pages", "author");
plugins::set_submenu_item("TD_Page_builder", "Edit pages", "/admin/pages/edit-pages", "author");

// define blocks
page_functions::define_block("wysiwyg", "Visual Editor");
page_functions::define_block("plain_text", "Plain text");
page_functions::define_block("create_columns", "Create-columns");
page_functions::define_block("subcategories", "Subcategories");

// set page_builder default insert blocks
page_functions::set_insert_block("create_columns", function ($block_array, $page_id) {
    save_page::add_create_columns($block_array, $page_id);
});
page_functions::set_insert_block("wysiwyg", function ($block_array, $page_id, $database_block_id) {
    save_page::add_wysiwyg($block_array, $page_id, $database_block_id);
});
page_functions::set_insert_block("plain_text", function ($block_array, $page_id, $database_block_id) {
    save_page::add_plain_text($block_array, $page_id, $database_block_id);
});
page_functions::set_insert_block("subcategories", function ($block_array, $page_id, $database_block_id) {
    save_page::add_subcategories($block_array, $page_id, $database_block_id);
});

// set page_builder default update blocks
page_functions::set_update_block("create_columns", function ($block_array, $page_id) {
    save_page::save_create_columns($block_array, $page_id);
});
page_functions::set_update_block("wysiwyg", function ($block_array, $page_id, $database_block_id) {
    save_page::save_wysiwyg($block_array, $page_id, $database_block_id);
});
page_functions::set_update_block("plain_text", function ($block_array, $page_id, $database_block_id) {
    save_page::save_plain_text($block_array, $page_id, $database_block_id);
});
page_functions::set_update_block("subcategories", function ($block_array, $page_id, $database_block_id) {
    save_page::save_subcategories($block_array, $page_id, $database_block_id);
});