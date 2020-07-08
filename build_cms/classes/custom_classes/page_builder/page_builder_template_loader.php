<?php

class page_builder_template_loader {
    /* ============================== Load blocks ============================== */
    public static function get_blocks($building_blocks_area, $array = array()) {
        $page_id = (isset($array["page_id"])) ? (int)$array["page_id"] : "use_url";
        $page_array = (isset($array["page_array"])) ? $array["page_array"] : "default";

        page_functions::set_load_block_template_function("wysiwyg", function ($data) { self::load_wysiwyg($data); });
        page_functions::set_load_block_template_function("plain_text", function ($data) { self::load_plain_text($data); });
        page_functions::set_load_block_template_function("create_columns", function ($data) { self::load_create_columns($data); });
        page_functions::set_load_block_template_function("subcategories", function ($data) { self::load_subcategories($data); });

        if (is_array($page_array)) {
            if (isset($page_array["id"]) && isset($page_array["url"]) && isset($page_array["status"]) && isset($page_array["post_page"])) {
                self::load_blocks($page_array, $building_blocks_area);
            }
            else {
                echo "invalid array";
            }
        }
        elseif ((user_url::uri_string() !== "/" AND user_url::uri_string() !== "") AND $page_id === "use_url") {
            $prepare_sql_url = array();
            foreach (user_url::uri() AS $uri) {
                $prepare_sql_url[] = "`url`='" . $uri . "'";
            }
    
            $where_string = implode(" OR ", $prepare_sql_url);
            $pages_sql = self::fix_page_array( database::select("SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE $where_string"), user_url::uri() );
    
            if ($pages_sql) {
                self::load_blocks($pages_sql, $building_blocks_area);
            }
            else {
                echo "404 error";
            }
        }
        elseif (is_int($page_id)) {
            // get page using page id
            $pages_sql = database::select("SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE `id`='$page_id'")[0];
    
            if ($pages_sql) {
                self::load_blocks($pages_sql, $building_blocks_area);
            }
        }
        else {
            // get home page
            $pages_sql = database::select("SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE `home_page`='true'")[0];
    
            if ($pages_sql) {
                self::load_blocks($pages_sql, $building_blocks_area);
            }
        }
    }

    private static function fix_page_array($array = array(), $user_url_uri) {
        $new_array = array();

        if (count($array) === count($user_url_uri)) {
            // key number to page url
            foreach ($array AS $sub_array) {
                $new_array[$sub_array["url"]] = $sub_array;
            }
    
            // set page array in the uri order
            $return_array = array();
            foreach ($user_url_uri AS $value) {
                $return_array[$value] = $new_array[$value];
            }

            // 404 check
            $last_page_key_name = array();
            $is_404 = false;
            foreach ($return_array AS $value) {
                if ($value["status"] === "not-published") {
                    $is_404 = true;
                }

                if (empty($last_page_key_name) && !$is_404) {
                    $last_page_key_name = $value;
                }
                elseif (!$is_404) {
                    if ($value["post_page"] === $last_page_key_name["id"]) {
                        $last_page_key_name = $value;
                    }
                    else {
                        $is_404 = true;
                    }
                }
            }
    
            if ($is_404) {
                return false;
            }
            else {
                return end($return_array);
            }
        }
        else {
            return false;
        }
    }

    private static function load_blocks($page_array, $building_blocks_area) {
        $page_id = $page_array["id"];
        $query = "SELECT `id`, `page_id`, `block_type`, `block_id` FROM `page_blocks` WHERE `building_blocks_area`='$building_blocks_area' AND `page_id`='$page_id' ORDER BY `the_order` ASC";
        $blocks_array = database::select($query);

        if (is_array($blocks_array)) {
            foreach ($blocks_array AS $block) {
                if (isset(page_functions::$set_load_block_template_functions[$block["block_type"]])) {
                    echo '<div class="block_' . $block["id"] . '">';
                    page_functions::$set_load_block_template_functions[$block["block_type"]]->__invoke($block);
                    echo "</div>";
                }
            }
        }
    }

    private static function load_wysiwyg($data) {
        $block_root_id = $data["id"];
        $data_wysiwyg = database::select("SELECT `data` FROM `page_wysiwyg` WHERE `page_blocks_id`='$block_root_id'")[0]["data"];

        echo $data_wysiwyg;
    }

    private static function load_plain_text($data) {
        $block_root_id = $data["id"];
        $data_plain_text = database::select("SELECT `data` FROM `page_plain_text` WHERE `page_blocks_id`='$block_root_id'")[0]["data"];

        echo $data_plain_text;
    }

    private static function load_subcategories($data) {
        $block_root_id = $data["id"];
        $subcategories_sql = database::select("SELECT `limit_type`, `the_limit`, `sort` FROM `page_sub_cat` WHERE `page_blocks_id`='$block_root_id'")[0];

        $sort = $subcategories_sql["sort"];
        $page_id = $data["page_id"];
        $the_limit = $subcategories_sql["the_limit"];

        if ($subcategories_sql["limit_type"] === "no-limit") {
            $query = "SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE `post_page`='$page_id' AND `status`='published' ORDER BY `time_stamp` $sort";
            $page_array = database::select($query);
        }
        else {
            $query = "SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE `post_page`='$page_id' AND `status`='published' ORDER BY `time_stamp` $sort LIMIT $the_limit";
            $page_array = database::select($query);
        }

        if (is_array($page_array)) {
            foreach ($page_array AS $page) {
                self::get_blocks("category-info", array("page_array" => $page));
            }
        }
    }

    private static function load_create_columns($data) {
        $page_id = $data["page_id"];
        $block_id = $data["block_id"];

        $columns = database::select("SELECT `block_id`, `column_id` FROM `page_cc_block` WHERE `page_id`='$page_id' AND `block_id`='$block_id'");

        if (!empty($columns)) {
            foreach ($columns AS $column) {
                echo '<div class="column_' . $column["column_id"] . '">';
                self::get_blocks(
                    $column["block_id"] . "-" . $column["column_id"],
                    array(
                        "page_id" => $page_id
                    )
                );
                echo '</div>';
            }
        }
    }
    /* ============================== /Load blocks ============================== */

    /* ============================== load css (blocks) ============================== */

    public static function load_css($page, $sub_pages) {
        page_functions::set_load_blocks_css_function("wysiwyg", function ($block) { self::load_wysiwyg_css($block); });
        page_functions::set_load_blocks_css_function("plain_text", function ($block) { self::load_plain_text_css($block); });
        page_functions::set_load_blocks_css_function("create_columns", function ($block) { self::load_create_columns_css($block); });
        page_functions::set_load_blocks_css_function("subcategories", function ($block) { self::load_subcategories_css($block); });

        if (!is_int($page)) {
            $page = (isset($page["page"]) AND !empty($page["page"])) ? explode("/", trim($page["page"], "/")) : "";
        }

        if (is_int($page)) {
            // get by id
            $page_array = database::select("SELECT `id`, `url`, `post_page` FROM `page` WHERE `id`='$page' AND `status`='published'")[0];
        }
        elseif ($page === "") {
            $page_array = database::select("SELECT `id`, `url`, `post_page` FROM `page` WHERE `home_page`='true' AND `status`='published'")[0];
        }
        else {
            $prepare_sql_url = array();
            foreach ($page AS $uri) {
                $prepare_sql_url[] = "`url`='" . $uri . "'";
            }
    
            $where_string = implode(" OR ", $prepare_sql_url);
            
            $page_array = self::fix_page_array( database::select("SELECT `id`, `url`, `status`, `post_page` FROM `page` WHERE $where_string"), $page );
        }

        $page_id = $page_array["id"];
        
        $building_blocks_areas = plugins::$building_blocks_area;
        if ($sub_pages) {
            unset($building_blocks_areas["category-info"]);
        }
        else {
            $category_info = $building_blocks_areas["category-info"];
            foreach ($building_blocks_areas AS $delete_area_key => $delete_area) {
                unset($building_blocks_areas[$delete_area_key]);
            }
            $building_blocks_areas["category-info"] = $category_info;
        }

        // prepare building_blocks_areas for SQL
        $prepare_sql_area = array();
        foreach ($building_blocks_areas AS $key => $building_blocks_area) {
            $prepare_sql_area[$key] = "`building_blocks_area`!='" . $building_blocks_area["name"] . "'";
        }
        $prepare_sql_area = (!$sub_pages) ? implode(" OR ", $prepare_sql_area) : implode(" AND ", $prepare_sql_area);

        // sql
        $query = "SELECT `id`, `block_type`, `block_id`, `page_id`, `building_blocks_area` FROM `page_blocks` WHERE `page_id`='$page_id' AND $prepare_sql_area ORDER BY `the_order` ASC";
        $css_query = database::select($query);

        if (is_array($css_query)) {
            foreach ($css_query AS $block) {
                if (isset(page_functions::$set_load_blocks_css_functions[$block["block_type"]])) {
                    page_functions::$set_load_blocks_css_functions[$block["block_type"]]->__invoke($block);
                }
            }
        }

    }

    private static function load_wysiwyg_css($block_data) {
        // default css
        echo ".block_" . $block_data["id"] . " {";
            echo "padding: 10px 0px;";
        echo "}";

        // top element no margin or padding
        echo ".block_" . $block_data["id"] . " > *:first-child {";
            echo "padding-top: 0px;";
            echo "margin-top: 0px;";
        echo "}";

        // bottom element no margin or padding
        echo ".block_" . $block_data["id"] . " > *:last-child {";
            echo "padding-bottom: 0px;";
            echo "margin-bottom: 0px;";
        echo "}";
    }

    private static function load_plain_text_css($block_data) {
        echo ".block_" . $block_data["id"] . " {";
            echo "padding: 10px 0px;";
        echo "}";
    }

    private static function load_create_columns_css($block_data) {
        $page_id = $block_data["page_id"];
        $block_id = $block_data["block_id"];
        $create_columns_sql = database::select("SELECT `column_id`, `width` FROM `page_cc_block` WHERE `block_id`='$block_id' AND `page_id`='$page_id' ORDER BY `column_id` ASC");

        echo ".block_" . $block_data["id"] . " {";
        echo    "display: flex;";
        echo    "padding: 0px;";
        echo "}";

        $last_key = count($create_columns_sql) - 1;
        if (is_array($create_columns_sql)) {
            foreach ($create_columns_sql AS $key => $block) {
                echo ".block_" . $block_data["id"] . " > .column_" . $block["column_id"] . " {";
                    if ($key == $last_key) {
                        echo "padding: 0px 0px 0px 0px;";
                    }
                    else {
                        echo "padding: 0px 5px 0px 0px;";
                    }
                    echo "flex: " . rtrim(rtrim((string)$block["width"], "0"), ".") . ";";
                echo "}";
            }
        }
    }

    private static function load_subcategories_css($block_data) {
        $block_root_id = $block_data["id"];
        $subcategories_sql = database::select("SELECT `limit_type`, `the_limit`, `sort` FROM `page_sub_cat` WHERE `page_blocks_id`='$block_root_id'")[0];

        $sort = $subcategories_sql["sort"];
        $page_id = $block_data["page_id"];
        $the_limit = $subcategories_sql["the_limit"];

        if ($subcategories_sql["limit_type"] === "no-limit") {
            $query = "SELECT `id` FROM `page` WHERE `post_page`='$page_id' ORDER BY `time_stamp` $sort";
            $page_array = database::select($query);
        }
        else {
            $query = "SELECT `id` FROM `page` WHERE `post_page`='$page_id' ORDER BY `time_stamp` $sort LIMIT $the_limit";
            $page_array = database::select($query);
        }

        if (is_array($page_array)) {
            foreach ($page_array AS $page) {
                self::load_css((int)$page["id"], true);
            }
        }
    }

    /* ============================== /load css (blocks) ============================== */

    /* ============================== Load SEO ============================== */

    public static function get_seo() {
        if (user_url::uri_string() !== "/") {
            $prepare_sql_url = array();
            foreach (user_url::uri() AS $uri) {
                $prepare_sql_url[] = "`url`='" . $uri . "'";
            }
    
            $where_string = implode(" OR ", $prepare_sql_url);
            $pages_sql = self::fix_page_array( database::select("SELECT `id`, `url`, `post_page`, `status`, `pagetitle`, `author`, `keywords`, `description` FROM `page` WHERE $where_string"), user_url::uri() );
    
            if (empty($pages_sql["pagetitle"]) && empty($pages_sql['description'])) {
                $select_query = "`sidetitle`, `sideslogan`";
            }
            elseif (empty($pages_sql["pagetitle"])) {
                $select_query = "`sidetitle`";
            }
            elseif (empty($pages_sql["description"])) {
                $select_query = "`sideslogan`";
            }
            else {
                $select_query = "";
            }
            $empty_sql = ($select_query === "") ? array() : database::select("SELECT $select_query FROM `settings`")[0];

            if ( isset($empty_sql["sidetitle"]) ) {
                $empty_sql["sidetitle"] = (empty($empty_sql["sidetitle"])) ? "no page name" : $empty_sql["sidetitle"];
            }

            if ( isset($empty_sql["sideslogan"]) ) {
                $empty_sql["sideslogan"] = (empty($empty_sql["sideslogan"])) ? "no page description" : $empty_sql["sideslogan"];
            }

            $return = "";
            if (is_array($pages_sql)) {
                $return .= '<title>' . ( (empty($pages_sql["pagetitle"])) ? $empty_sql["sidetitle"] : $pages_sql["pagetitle"] ) . '</title>';
                $return .= (!empty($pages_sql['author'])) ? '<meta name="author" content="' . $pages_sql['author'] . '">' : "";
                $return .= (!empty($pages_sql['keywords'])) ? '<meta name="keywords" content="' . $pages_sql['keywords'] . '">' : "";
                $return .= '<meta name="description" content="' . ( (empty($pages_sql["description"])) ? $empty_sql["sideslogan"] : $pages_sql['description'] ) . '">';
            }
            else {
                $return .= '<title>' . $empty_sql["sidetitle"] . '</title>';
                $return .= '<meta name="description" content="' . $empty_sql["sideslogan"] . '">';
            }
            return $return;
        }
    }

    /* ============================== /Load SEO ============================== */
}