<?php

class add_pageController extends controller {
    public static function get_add_page() {
        // set head and footer files
        self::set_head("/admin/page/add/head.php");
        self::set_footer("/admin/page/add/footer.php");

        // setup page array
        self::get_page_array();

        // set modal
        self::set_modal();

        // load view
        self::getView("/admin/admin_basics/header.php");
        self::getView("/admin/page/add/add-page.php");
        self::getView("/admin/admin_basics/footer.php");
    }

    // get page data
    public static $get_page_array_array = array();
    private static function get_page_array() {
        if (!empty(user_url::$new_uri)) {
            database::reset();
            $url_data   = database::escape(user_url::$new_uri);
            $id         = $url_data[0];

            database::select("SELECT * FROM `page` WHERE id = '$id'", function ($data) {
                self::$get_page_array_array = $data["fetch_all"][0];
            });
        }
    }

    private static function set_modal() {
        // page id
        if (isset(user_url::$new_uri[0])) {
            add_pageModal::$page_id = user_url::$new_uri[0];
        }
        // highest block id
        if (isset(user_url::$new_uri[0])) {
            $id = user_url::$new_uri[0];
            add_pageModal::$highest_block_id = (int)(database::select("SELECT max(block_id) FROM `page_blocks` WHERE `page_id`='$id'")[0]["max(block_id)"] + 1);
        }
        if (isset(self::$get_page_array_array["id"])) {
            // Edit: page name
            add_pageModal::$edit_page_name = "Edit: " . self::$get_page_array_array["pagename"];
            // page name input
            add_pageModal::$page_name_imput = self::$get_page_array_array["pagename"];
            // url name
            add_pageModal::$page_url_imput = self::$get_page_array_array["url"];

            // ==================== set status ====================
            if (self::$get_page_array_array["status"] === "not-published") {
                add_pageModal::$status_not_published = " selected";
            }
            elseif (self::$get_page_array_array["status"] === "published") {
                add_pageModal::$status_published = " selected";
            }
            // ==================== /set status ====================

            // if (home page)
            if (self::$get_page_array_array["home_page"] === "1") {
                add_pageModal::$page_home = "checked";
            }
            // seo page title
            add_pageModal::$seo_pagetitle   = self::$get_page_array_array["pagetitle"];
            // seo author
            add_pageModal::$seo_author      = self::$get_page_array_array["author"];
            // seo keywords
            add_pageModal::$seo_keywords    = self::$get_page_array_array["keywords"];
            // seo description
            add_pageModal::$seo_description = self::$get_page_array_array["description"];
            // time stamp
            add_pageModal::$time_stamp      = self::$get_page_array_array["time_stamp"];
        }
    }
}