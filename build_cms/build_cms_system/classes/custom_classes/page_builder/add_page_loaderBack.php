<?php

class add_page_loaderBack {
    // get page data
    public static $get_page_array_array = array();
    public static function get_page_array() {
        if (!empty(user_url::$new_uri)) {
            database::reset();
            $url_data   = database::escape(user_url::$new_uri);
            $id         = $url_data[0];

            database::select("SELECT * FROM `page` WHERE id = '$id'", function ($data) {
                self::$get_page_array_array = $data["fetch_all"][0];
            });
        }
    }

    public static function set_modal() {
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
            if (self::$get_page_array_array["home_page"] === "true") {
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

    private static $files_array = array();
    private static function loop_template_array($array) {
        $return = array();

        foreach ($array AS $item_key => $item) {
            if (is_numeric($item_key)) {
                if (isset($array[$item]) && $array[$item] !== "empty_folder") {
                    // is a directory
                    $return[$item] = self::loop_template_array($array[$item]);
                    if (empty($return[$item])) {
                        unset($return[$item]);
                    }
                    else {
                        $return[] = $item;
                    }
                }
                elseif (preg_match("/_template.php\$/", $item)) {
                    // is a file
                    $return[] = preg_replace("/_template.php\$/", "", $item);
                }
            }
        }

        return $return;
    }
    public static function set_template_array() {
        $index_the_template = files::findFiles_toSingleArray(
            self::loop_template_array(
                files::findFiles(
                    config_dir::BUILD_CMS_SYSTEM(
                        "/view/templates/" . templateLoader::$template_dir
                    )
                )
            )
        );

        $index_the_template_new = array();
        foreach ($index_the_template AS $template) {
            if (isset(self::$get_page_array_array["choose_template"]) && $template === self::$get_page_array_array["choose_template"]) {
                add_pageModal::$default_template = "";
                $active = " selected";
            }
            else {
                $active = "";
            }

            $index_the_template_new[] = array(
                "template"  => $template,
                "active"    => $active
            );
        }

        add_pageModal::$index_the_template = $index_the_template_new;
    }
}