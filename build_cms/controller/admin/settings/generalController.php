<?php

class generalController extends controller {
    /* ============================== submit ============================== */
        public static function submit_general() {
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
            
            echo "Success";
        }
    /* ============================== /submit ============================== */

    /* ============================== view ============================== */
        public static function get_general() {
            //self::form_data();
            $form_data = database::select("SELECT `sidetitle`, `sideslogan`, `membership`, `new_user_default_role` FROM `settings`")[0];
            // form data
            generalModal::$sidetitle    = $form_data["sidetitle"];
            generalModal::$sideslogan   = $form_data["sideslogan"];

            // membership
            generalModal::$membership = $form_data["membership"];

            // user role
            if ($form_data['new_user_default_role'] === "admin") {
                generalModal::$new_user_default_role_admin = 'selected="selected"';
            }
            elseif ($form_data['new_user_default_role'] === "author") {
                generalModal::$new_user_default_role_author = 'selected="selected"';
            }
            elseif ($form_data['new_user_default_role'] === "user") {
                generalModal::$new_user_default_role_user = 'selected="selected"';
            }

            self::set_head("/admin/settings/general/head.php");

            self::getView("/admin/admin_basics/header.php");
            self::getView("/admin/settings/general/general.php");
            self::getView("/admin/admin_basics/footer.php");
        }
    /* ============================== /view ============================== */
}