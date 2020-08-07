<?php

class build_cms_page_builder_edit_page_pluginSubController extends controller {
    private static $get_pages_table_return;
    public static function get_pages_table() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                database::reset();

                if (isset($_GET["search"])) {
                    $search = user_url::$get_var["search"];
                    database::select("SELECT * FROM `page` WHERE pagename LIKE '%$search%' ORDER BY id", function ($data) {
                        self::$get_pages_table_return = self::setup_pages_table_html($data['fetch_all']);
                    });
                }
                else {
                    database::select("SELECT * FROM `page` ORDER BY id", function ($data) {
                        self::$get_pages_table_return = self::setup_pages_table_html($data['fetch_all']);
                    });
                }
                
            });
        });

        return self::$get_pages_table_return;
    }

    private static function setup_pages_table_html($array) {
        $return = "";

        foreach ($array as $key => $value) {
            $date = date("l, ( Y-m-d G:i )", strtotime($value['time_stamp']));

            $return .=  '<tr>';

            $return .=      '<td>' . $value['pagename'] . '</td>';
            $return .=      '<td>' . $value['status'] . '</td>';
            $return .=      '<td>';
            $return .=          'Edit: ';
            $return .=          '<a href="' . config_url::BASE('/admin/pages/' . $value['id']) . '">' . $value['pagename'] . '</a>';
            $return .=          ' / ';
            $return .=          'Delete: ';
            $return .=          '<a href="' . config_url::BASE('/admin_submit/page/delete_page/' . $value['id']) . '" class="delete_page">' . $value['pagename'] . '</a>';
            $return .=      '</td>';
            $return .=      '<td class="table-data">' . $date . '</td>';

            $return .=  '</tr>';
        }

        return $return;
    }
}