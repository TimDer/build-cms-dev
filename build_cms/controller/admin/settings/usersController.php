<?php

class usersController extends controller {
    public static function get_all_users() {
        self::set_head("/admin/settings/users/all_users_head.php");
        self::getAdminTemplateView("/admin/settings/users/all_users.php");
    }
}