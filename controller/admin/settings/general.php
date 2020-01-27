<?php

class general extends controller {
    public static $form_data = array();

    /* ============================== submit ============================== */
        public static function submit_general() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("admin", function () {
                    if (isset(user_url::$post_var["membership"])) {
                        $membership = user_url::$post_var["membership"];
                    }
                    else {
                        $membership = 0;
                    }

                    database::query('UPDATE settings SET sidetitle="' . user_url::$post_var["site-title"] . '",
                                                            sideslogan="' . user_url::$post_var["site-slogan"] . '",
                                                            membership="' . $membership . '",
                                                            new_user_default_role="' . user_url::$post_var["new-user-default-role"] . '"');
                });
            });
        }
    /* ============================== /submit ============================== */

    /* ============================== view ============================== */
        public static function get_general() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("admin", function () {
                    self::form_data();
                    self::set_head("/admin/settings/general/head.php");

                    self::getView("/admin/admin_basics/header.php");
                    self::getView("/admin/settings/general/general.php");
                    self::getView("/admin/admin_basics/footer.php");
                });
            });
        }

        // return selected to the new-user-default-role admin option
        private static $new_user_default_role_admin;
        public static function new_user_default_role_admin() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("admin", function () {
                    if (self::$form_data['new_user_default_role'] === "admin") {
                        self::$new_user_default_role_admin = 'selected="selected"';
                    }
                });
            });
            return self::$new_user_default_role_admin;
        }
        // return selected to the new-user-default-role author option
        private static $new_user_default_role_author;
        public static function new_user_default_role_author() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("author", function () {
                    if (self::$form_data['new_user_default_role'] === "author") {
                        self::$new_user_default_role_author = 'selected="selected"';
                    }
                });
            });
            return self::$new_user_default_role_author;
        }
        // return selected to the new-user-default-role user option
        private static $new_user_default_role_user;
        public static function new_user_default_role_user() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("user", function () {
                    if (self::$form_data['new_user_default_role'] === "user") {
                        self::$new_user_default_role_user = 'selected="selected"';
                    }
                });
            });
            return self::$new_user_default_role_user;
        }

        // return checked to the membership checkbox
        private static $membership_return;
        public static function membership() {
            user_session::check_session("user_id", function () {
                user_session::check_session_permission("admin", function () {
                    if ((int)self::$form_data['membership'] === 1) {
                        self::$membership_return = 'checked="checked"';
                    }
                });
            });

            return self::$membership_return;
        }
    /* ============================== /view ============================== */

    /* ============================== private functions ============================== */
        private static function form_data() {
            database::reset();

            database::select("SELECT `sidetitle`, `sideslogan`, `membership`, `new_user_default_role` FROM `settings`", function ($data) {
                self::$form_data = $data["fetch_all"][0];
            });
        }
    /* ============================== private functions ============================== */
}