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
                                                    new_user_default_role="' . user_url::$post_var["new-user-default-role"] . '",
                                                    tamplateLoaderID="' . user_url::$post_var["set-a-template-loader"] . '"');
            
            echo "Success";
        }
    /* ============================== /submit ============================== */

    /* ============================== view ============================== */
        public static function get_general() {
            $all_plugins_array = array(
                array(
                    "id" => 0,
                    "displayName" => "Use built in templateloader"
                )
            );

            $pluginsDir = scandir( config_dir::BASE("/plugins") );
            foreach ($pluginsDir AS $plugin) {
                if (file_exists( config_dir::BASE("/plugins/" . $plugin . "/index.php") ) && ($plugin !== ".dirPlaceholder" || $plugin !== "." || $plugin !== "..")) {
                    $all_plugins_array[] = array(
                        "id" => "/plugins/" . $plugin . "/index.php",
                        "displayName" => $plugin
                    );
                }
            }

            $systemDir = scandir(config_dir::BUILD_CMS_SYSTEM("/system"));
            foreach ($systemDir AS $sys_plugin) {
                if (file_exists( config_dir::BUILD_CMS_SYSTEM("/system/" . $sys_plugin . "/index.php") ) && ($sys_plugin !== ".dirPlaceholder" || $sys_plugin !== "." || $sys_plugin !== "..")) {
                    $all_plugins_array[] = array(
                        "id" => "/build_cms_system/system/" . $sys_plugin . "/index.php",
                        "displayName" => $sys_plugin
                    );
                }
            }

            generalModal::$templateLoader = $all_plugins_array;

            $form_data = database::select("SELECT `sidetitle`, `sideslogan`, `membership`, `new_user_default_role`, `tamplateLoaderID` FROM `settings`")[0];
            // form data
            generalModal::$sidetitle                = $form_data["sidetitle"];
            generalModal::$sideslogan               = $form_data["sideslogan"];
            generalModal::$templateLoaderSelectedID = $form_data["tamplateLoaderID"];

            // membership
            if ( (int)$form_data["membership"] === 0 ) {
                // false
                generalModal::$membership = "";
            }
            elseif ( (int)$form_data["membership"] === 1 ) {
                // true
                generalModal::$membership = "checked";
            }

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
            self::getAdminTemplateView("/admin/settings/general/general.php");
        }
    /* ============================== /view ============================== */
}