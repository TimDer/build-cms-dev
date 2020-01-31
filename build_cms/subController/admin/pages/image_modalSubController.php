<?php

class image_modalSubController extends controller {
    public static function get_images_modal() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                database::reset();
                database::select("SELECT * FROM `media` WHERE `media_type` = 'image'", function ($data) {
                    foreach ($data["fetch_all"] as $value) {
                        $image_id   = $value["id"];
                        $image_url  = $value["the_file_name"];

                        require config_dir::VIEW("/admin/page/image-modal.php");
                    }
                });
            });
        });
    }
}