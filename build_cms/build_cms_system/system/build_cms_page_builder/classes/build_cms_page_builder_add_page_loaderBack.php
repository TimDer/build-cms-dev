<?php

class build_cms_page_builder_add_page_loaderBack {
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
            build_cms_page_builder_add_page_pluginModal::$page_id = user_url::$new_uri[0];
        }
        // highest block id
        if (isset(user_url::$new_uri[0])) {
            $id = user_url::$new_uri[0];
            build_cms_page_builder_add_page_pluginModal::$highest_block_id = (int)(database::select("SELECT max(block_id) FROM `page_blocks` WHERE `page_id`='$id'")[0]["max(block_id)"] + 1);
        }
        if (isset(self::$get_page_array_array["id"])) {
            // Edit: page name
            build_cms_page_builder_add_page_pluginModal::$edit_page_name = "Edit: " . self::$get_page_array_array["pagename"];
            // page name input
            build_cms_page_builder_add_page_pluginModal::$page_name_imput = self::$get_page_array_array["pagename"];
            // url name
            build_cms_page_builder_add_page_pluginModal::$page_url_imput = self::$get_page_array_array["url"];

            // ==================== set status ====================
            if (self::$get_page_array_array["status"] === "not-published") {
                build_cms_page_builder_add_page_pluginModal::$status_not_published = " selected";
            }
            elseif (self::$get_page_array_array["status"] === "published") {
                build_cms_page_builder_add_page_pluginModal::$status_published = " selected";
            }
            // ==================== /set status ====================

            // if (home page)
            if (self::$get_page_array_array["home_page"] === "true") {
                build_cms_page_builder_add_page_pluginModal::$page_home = "checked";
            }
            // seo page title
            build_cms_page_builder_add_page_pluginModal::$seo_pagetitle   = self::$get_page_array_array["pagetitle"];
            // seo author
            build_cms_page_builder_add_page_pluginModal::$seo_author      = self::$get_page_array_array["author"];
            // seo keywords
            build_cms_page_builder_add_page_pluginModal::$seo_keywords    = self::$get_page_array_array["keywords"];
            // seo description
            build_cms_page_builder_add_page_pluginModal::$seo_description = self::$get_page_array_array["description"];
            // time stamp
            build_cms_page_builder_add_page_pluginModal::$time_stamp      = self::$get_page_array_array["time_stamp"];
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
                    config_dir::BASE(
                        "/templates/" . templateLoader::$template_dir
                    )
                )
            )
        );

        $index_the_template_new = array();
        foreach ($index_the_template AS $template) {
            if (isset(self::$get_page_array_array["choose_template"]) && $template === self::$get_page_array_array["choose_template"]) {
                build_cms_page_builder_add_page_pluginModal::$default_template = "";
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

        build_cms_page_builder_add_page_pluginModal::$index_the_template = $index_the_template_new;
    }
}