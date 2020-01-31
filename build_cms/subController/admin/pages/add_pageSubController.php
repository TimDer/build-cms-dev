<?php

class add_pageSubController extends controller {
    /* ============================== category ============================== */
    private static $get_category_return = "";
    public static function get_category() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                database::reset();

                if (isset(add_pageController::$get_page_array_array["id"])) {
                    $id = add_pageController::$get_page_array_array["id"];
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
            if (!empty(add_pageController::$get_page_array_array) AND add_pageController::$get_page_array_array['post_page'] === $value['id']) {
                $post_page = 'checked="checked"';
            }
            else {
                $post_page = '';
            }

            $return .= '<div class="category_container">';
            if (!empty(add_pageController::$get_page_array_array["id"]) AND add_pageController::$get_page_array_array["id"] === $value["id"]) {
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
                if (empty(add_pageController::$get_page_array_array)) {
                    self::$select_root_category_return = 'checked="checked"';
                }
                elseif (empty(add_pageController::$get_page_array_array['post_page'])) {
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
                self::$get_category_image_src_return = config_url::VIEW("/images/" . add_pageController::$get_page_array_array['category_image']);
            });
        });

        return self::$get_category_image_src_return;
    }

    private static $get_category_image_return;
    public static function get_category_image() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                self::$get_category_image_return = add_pageController::$get_page_array_array['category_image'];
            });
        });

        return self::$get_category_image_return;
    }

    private static $get_category_text_return;
    public static function get_category_text() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                if (isset(add_pageController::$get_page_array_array['category_text'])) {
                    self::$get_category_text_return = add_pageController::$get_page_array_array['category_text'];
                }
            });
        });

        return self::$get_category_text_return;
    }
    /* ============================== /category_info ============================== */
}