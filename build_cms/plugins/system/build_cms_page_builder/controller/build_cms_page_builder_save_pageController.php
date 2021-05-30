<?php

class build_cms_page_builder_save_pageController extends controller {
    /* ============================== save page ============================== */
    public static function build_cms_page_builder_save_pages() {
        // Save the basics and get the page id
        $page_id = build_cms_page_builder_save_page::basics(user_url::$post_var["system_area"]["basics"]["data"]);
        build_cms_page_builder_save_page::generate_urls(user_url::$post_var["system_area"]["basics"]["data"], $page_id);

        // building-blocks
        if (isset(user_url::$post_var["system_area"]["page_builder"]["data"]["building-blocks"])) {
            foreach (user_url::$post_var["system_area"]["page_builder"]["data"]["building-blocks"] AS $building_blocks_key => $building_blocks_value) {
                build_cms_page_builder_save_page::save_blocks($building_blocks_value, (string)$building_blocks_key, $page_id);
            }
        }

        if (isset(user_url::$post_var["system_area"]["page_builder"]["data"]["del_blocks_array"])) {
            build_cms_page_builder_save_page::delete_blocks(user_url::$post_var["system_area"]["page_builder"]["data"]["del_blocks_array"], $page_id);
        }

        if (isset(user_url::$post_var["custom_area"])) {
            foreach (user_url::$post_var["custom_area"] AS $custom_area) {
                if (isset(build_cms_page_builder_page_functions::$save_custom_area[$custom_area["area_name"]])) {
                    build_cms_page_builder_page_functions::$save_custom_area[$custom_area["area_name"]]->__invoke($custom_area["data"], $page_id);
                }
            }
        }

        header("Content-type: text/javascript");

        $return_json = array(
            "page_id"       => $page_id,
            "status"        => "success",
            "time_stamp"    => date("Y-m-d G:i:s")
        );
        echo json_encode( $return_json );
    }
    /* ============================== /save page ============================== */

    /* ============================== del page ============================== */
    public static function delete_page() {
        database::reset();
        $page_id = database::escape( user_url::$new_uri )[0];
        database::query("DELETE FROM `page` WHERE id='$page_id'");
        database::query("DELETE FROM `page_blocks` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_cc_block` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_plain_text` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_sub_cat` WHERE page_id='$page_id'");
        database::query("DELETE FROM `page_wysiwyg` WHERE page_id='$page_id'");

        if ( isset(build_cms_page_builder_page_functions::$delete_build_cms_page_builder_page_functions) ) {
            foreach (build_cms_page_builder_page_functions::$delete_build_cms_page_builder_page_functions AS $delete) {
                $delete->__invoke($page_id);
            }
        }

        database::reset();
    }
    /* ============================== /del page ============================== */
}