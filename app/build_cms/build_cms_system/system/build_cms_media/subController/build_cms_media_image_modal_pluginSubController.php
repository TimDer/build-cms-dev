<?php

class build_cms_media_image_modal_pluginSubController extends controller {
    public static function get_images_modal() {
        user_session::check_session("user_id", function () {
            user_session::check_session_permission("author", function () {
                database::reset();
                database::select("SELECT * FROM `media` WHERE `media_type` = 'image'", function ($data) {
                    foreach ($data["fetch_all"] as $value) {
                        build_cms_media_image_modal_pluginModal::$image_id   = $value["id"];
                        build_cms_media_image_modal_pluginModal::$image_url  = $value["the_file_name"];

                        self::getView("/admin/image-modal-page_builder.php", __DIR__);
                    }
                });
            });
        });
    }
}