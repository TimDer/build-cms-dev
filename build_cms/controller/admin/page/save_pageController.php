<?php

class save_pageController extends controller {
    public static function save_pages() {
        // Save the basics and get the page id
        $page_id = save_page::basics(user_url::$post_var["system_area"]["basics"]["data"]);

        // building-blocks
        if (isset(user_url::$post_var["system_area"]["page_builder"]["data"]["building-blocks"])) {
            foreach (user_url::$post_var["system_area"]["page_builder"]["data"]["building-blocks"] AS $building_blocks_key => $building_blocks_value) {
                save_page::save_blocks($building_blocks_value, (string)$building_blocks_key, $page_id);
            }
        }

        if (isset(user_url::$post_var["system_area"]["page_builder"]["data"]["del_blocks_array"])) {
            save_page::delete_blocks(user_url::$post_var["system_area"]["page_builder"]["data"]["del_blocks_array"], $page_id);
        }

        if (isset(user_url::$post_var["custom_area"])) {
            foreach (user_url::$post_var["custom_area"] AS $custom_area) {
                if (isset(page_functions::$save_custom_area[$custom_area["area_name"]])) {
                    page_functions::$save_custom_area[$custom_area["area_name"]]->__invoke($custom_area["data"]);
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
}