<?php

class add_page extends controller {
    public static function get_add_page() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                // set head and footer files
                self::set_head("/admin/page/add/head.php");
                self::set_footer("/admin/page/add/footer.php");

                // page id
                if (isset(user_url::$new_uri[0])) {
                    add_pageModal::$page_id = user_url::$new_uri[0];
                }

                // setup page array
                self::get_page_array();

                // General
                self::get_page_status();

                // load view
                self::getView("/admin/admin_basics/header.php");
                self::getView("/admin/page/add/add-page.php");
                self::getView("/admin/admin_basics/footer.php");
            });
        });
    }

    // get page data
    private static $get_page_array_array = array();
    private static function get_page_array() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (!empty(user_url::$new_uri)) {
                    database::reset();
                    $url_data   = database::escape(user_url::$new_uri);
                    $id         = $url_data[0];
    
                    database::select("SELECT * FROM `page` WHERE id = '$id'", function ($data) {
                        self::$get_page_array_array = $data["fetch_all"][0];
                    });
                }
            });
        });
    }

    // get highest block id
    private static $get_highest_block_id_return = 1;
    public static function get_highest_block_id() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(user_url::$new_uri[0])) {
                    database::reset();
                    $escape = database::escape( user_url::$new_uri );
                    $id = $escape[0];
                    database::select("SELECT max(block_id) FROM `page_blocks` WHERE `page_id`='$id'", function ($data) {
                        self::$get_highest_block_id_return = $data["fetch_all"][0]["max(block_id)"] + 1;
                    });
                }
            });
        });

        return self::$get_highest_block_id_return;
    }

    /* ============================== General ============================== */
    private static $get_page_name_return;
    public static function get_page_name() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["pagename"])) {
                    self::$get_page_name_return = "Edit: " . self::$get_page_array_array["pagename"];
                }
                else {
                    self::$get_page_name_return = "Add page";
                }
            });
        });

        return self::$get_page_name_return;
    }

    private static $get_page_name_imput_return;
    public static function get_page_name_imput() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["pagename"])) {
                    self::$get_page_name_imput_return = self::$get_page_array_array["pagename"];
                }
                else {
                    self::$get_page_name_imput_return = "";
                }
            });
        });

        return self::$get_page_name_imput_return;
    }

    private static $get_page_url_imput_return;
    public static function get_page_url_imput() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["url"])) {
                    self::$get_page_url_imput_return = self::$get_page_array_array["url"];
                }
                else {
                    self::$get_page_url_imput_return = "";
                }
            });
        });

        return self::$get_page_url_imput_return;
    }

    public static $get_page_status_not_published = "";
    public static $get_page_status_published = "";
    private static function get_page_status() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["status"]) AND self::$get_page_array_array["status"] === "not-published") {
                    self::$get_page_status_not_published = " selected";
                }
                elseif (isset(self::$get_page_array_array["status"]) AND self::$get_page_array_array["status"] === "published") {
                    self::$get_page_status_published = " selected";
                }
            });
        });
    }

    private static $get_page_home_return;
    public static function get_page_home() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["home_page"]) AND self::$get_page_array_array["home_page"] === "1") {
                    self::$get_page_home_return = "checked";
                }
            });
        });

        return self::$get_page_home_return;
    }
    /* ============================== /General ============================== */

    /* ============================== SEO ============================== */
    private static $get_seo_pagetitle_return = "";
    public static function get_seo_pagetitle() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["pagetitle"])) {
                    self::$get_seo_pagetitle_return = self::$get_page_array_array["pagetitle"];
                }
            });
        });

        return self::$get_seo_pagetitle_return;
    }

    private static $get_seo_author_return = "";
    public static function get_seo_author() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["author"])) {
                    self::$get_seo_author_return = self::$get_page_array_array["author"];
                }
            });
        });

        return self::$get_seo_author_return;
    }

    private static $get_seo_keywords_return = "";
    public static function get_seo_keywords() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["author"])) {
                    self::$get_seo_keywords_return = self::$get_page_array_array["keywords"];
                }
            });
        });

        return self::$get_seo_keywords_return;
    }

    private static $get_seo_description_return = "";
    public static function get_seo_description() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array["author"])) {
                    self::$get_seo_description_return = self::$get_page_array_array["description"];
                }
            });
        });

        return self::$get_seo_description_return;
    }
    /* ============================== /SEO ============================== */

    /* ============================== category ============================== */
    private static $get_category_return = "";
    public static function get_category() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                database::reset();

                if (isset(self::$get_page_array_array["id"])) {
                    $id = self::$get_page_array_array["id"];
                }
                else {
                    $id = 0;
                }

                database::select("SELECT * FROM `page`", function ($data) {
                    $fixed_array = self::category_fix_array($data["fetch_all"]);
                    
                    self::$get_category_return = self::setup_category($fixed_array);
                });
            });
        });

        return self::$get_category_return;
    }

    private static function category_fix_array($fix_array) {
        $return = array();

        foreach ($fix_array as $key => $value) {
            $post_page = $value['post_page'];

            if (empty($post_page)) {
                $return["root"][] = $value;
            }
            else {
                $return[$post_page][] = $value;
            }
        }

        return $return;
    }

    private static function setup_category($page_array, $setup_key = "root") {
        $return = "";

        foreach ($page_array[$setup_key] as $key => $value) {
            // select the post page
            if (!empty(self::$get_page_array_array) AND self::$get_page_array_array['post_page'] === $value['id']) {
                $post_page = 'checked="checked"';
            }
            else {
                $post_page = '';
            }

            $return .= '<div class="category_container">';
            if (!empty(self::$get_page_array_array["id"]) AND self::$get_page_array_array["id"] === $value["id"]) {
                $return .=      '<div class="category_placeholder"></div>';
            }
            else {
                $return .=      '<input type="radio" name="page_category" id="category-page-id-' . $value["id"] . '" value="' . $value["id"] . '" ' . $post_page . '>';
            }
            $return .=      '<label for="category-page-id-' . $value["id"] . '">' . $value["pagename"] . '</label>';

            if (isset($page_array[$value['id']])) {
                $return .=  '<div class="page_category">';
                
                $return .=      self::setup_category($page_array, $value['id']);

                $return .=  '</div>';
            }

            $return .= '</div>';
        }

        return $return;
    }

    private static $select_root_category_return;
    public static function select_root_category() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (empty(self::$get_page_array_array)) {
                    self::$select_root_category_return = 'checked="checked"';
                }
                elseif (empty(self::$get_page_array_array['post_page'])) {
                    self::$select_root_category_return = 'checked="checked"';
                }
            });
        });

        return self::$select_root_category_return;
    }
    /* ============================== /category ============================== */

    /* ============================== category_info ============================== */
    private static $get_category_image_src_return;
    public static function get_category_image_src() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                self::$get_category_image_src_return = config_url::VIEW("/images/" . self::$get_page_array_array['category_image']);
            });
        });

        return self::$get_category_image_src_return;
    }

    private static $get_category_image_return;
    public static function get_category_image() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                self::$get_category_image_return = self::$get_page_array_array['category_image'];
            });
        });

        return self::$get_category_image_return;
    }

    private static $get_category_text_return;
    public static function get_category_text() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(self::$get_page_array_array['category_text'])) {
                    self::$get_category_text_return = self::$get_page_array_array['category_text'];
                }
            });
        });

        return self::$get_category_text_return;
    }
    /* ============================== /category_info ============================== */
}