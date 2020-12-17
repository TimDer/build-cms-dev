<?php

// set page_builder default insert blocks
build_cms_page_builder_page_functions::set_insert_block("create_columns", function ($block_array, $page_id) {
    build_cms_page_builder_save_page::add_create_columns($block_array, $page_id);
});
build_cms_page_builder_page_functions::set_insert_block("wysiwyg", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::add_wysiwyg($block_array, $page_id, $database_block_id);
});
build_cms_page_builder_page_functions::set_insert_block("plain_text", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::add_plain_text($block_array, $page_id, $database_block_id);
});
build_cms_page_builder_page_functions::set_insert_block("subcategories", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::add_subcategories($block_array, $page_id, $database_block_id);
});

// set page_builder default update blocks
build_cms_page_builder_page_functions::set_update_block("create_columns", function ($block_array, $page_id) {
    build_cms_page_builder_save_page::save_create_columns($block_array, $page_id);
});
build_cms_page_builder_page_functions::set_update_block("wysiwyg", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::save_wysiwyg($block_array, $page_id, $database_block_id);
});
build_cms_page_builder_page_functions::set_update_block("plain_text", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::save_plain_text($block_array, $page_id, $database_block_id);
});
build_cms_page_builder_page_functions::set_update_block("subcategories", function ($block_array, $page_id, $database_block_id) {
    build_cms_page_builder_save_page::save_subcategories($block_array, $page_id, $database_block_id);
});