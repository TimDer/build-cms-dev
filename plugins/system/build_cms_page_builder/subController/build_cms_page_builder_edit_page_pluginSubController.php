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
                    }, array(), function () {
                        self::$get_pages_table_return = self::setup_pages_table_html(array());
                    });
                }
                else {
                    $where = "WHERE `post_page`=''";
                    if (isset( user_url::$get_var["page_id"] )) {
                        $page_id = user_url::$get_var["page_id"];
                        $where = "WHERE `post_page`='$page_id'";
                    }

                    database::select("SELECT * FROM `page` $where ORDER BY id", function ($data) {
                        self::$get_pages_table_return = self::setup_pages_table_html($data['fetch_all']);
                    }, array(), function () {
                        self::$get_pages_table_return = self::setup_pages_table_html(array());
                    });
                }
                
            });
        });

        return self::$get_pages_table_return;
    }

    private static function setup_pages_table_html($array) {
        $return = "";

        if (!empty( $array )) {
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
                $return .=          ' / ';
                $return .=          'Subpages:';
                $return .=          '<a href="' . config_url::BASE('/admin/pages/edit-pages?page_id=' . $value['id']) . '">' . $value['pagename'] . '</a>';
                $return .=      '</td>';
                $return .=      '<td class="table-data">' . $date . '</td>';
    
                $return .=  '</tr>';
            }
        }
        else {
            $return .=  '<tr>';
            $return .=      '<td>No page found</td>';
            $return .=      '<td>Not published</td>';
            $return .=      '<td>';
            $return .=          'Subpages: ';
            $return .=          '<a href="' . config_url::BASE('/admin/pages/edit-pages') . '">Root</a>';
            $return .=      '</td>';
            $return .=      '<td>' . date("l, ( Y-m-d G:i )") . '</td>';
            $return .=  '</tr>';
        }

        return $return;
    }
}