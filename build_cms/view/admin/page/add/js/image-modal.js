$(document).ready(function () {
    function image_block_modal() {
        return $("#select-an-image-modal").find(".img_data");
    }

    /* ============================== open modal ============================== */

        $(document).on("click", ".image-open-modal-btn", function () {
            $("body").css("overflow-y", "hidden");
            $(this).parent().parent().attr("id", "select-an-image-modal");
            $("#image_modal").css("display", "block");

            if (image_block_modal().attr("category_image") === undefined) {
                console.log("dit is een test");
                // set height and width (img_width="434" img_height="353")
                $('.form_group_img > input[name="img_width"]').val( image_block_modal().attr("img_width") );
                $('.form_group_img > input[name="img_height"]').val( image_block_modal().attr("img_height") );

                // set size mode
                $(".img_size_mode").val( image_block_modal().attr("img_size_mode") );

                // if custom form tags
                if (image_block_modal().attr("img_size_mode") === "custom") {
                    $(".form_group_img > input").removeAttr("disabled");
                    $(".align_image_modal").removeAttr("disabled");
                }
            }

            // select selected image
            $('#image_modal .content input[img_url="' + image_block_modal().attr("img_filename") + '"]').prop('checked', true);
            $('#image_modal .content input[img_url="' + image_block_modal().attr("img_filename") + '"]').parent().parent().addClass("img_btn_container_select");
            $(".selected_image > img").attr("src", $("#build_cms_base_url").attr("base_url") + "/view/images/" + image_block_modal().attr("img_filename") );

            // set align image to preferred setting
            $(".align_image_modal").val(function () {
                if (image_block_modal().hasClass("align_image_right")) {
                    return "right";
                }
                else if (image_block_modal().hasClass("align_image_center")) {
                    return "center";
                }
                else {
                    return "left";
                }
            });
        });

    /* ============================== open modal ============================== */

    /* ============================== close modal ============================== */

        $(document).on("click", "#close-image-modal", function () {
            // close-image-modal
            $("#image_modal").css("display", "none");
            // remove id from "image block"
            $("#select-an-image-modal").removeAttr("id");
            // uncheck image in modal
            $(".img_btn_radio").prop('checked', false);
            // unset preview image
            $(".selected_image > img").attr("src", "");
            // unset height and width
            $(".form_group_img > input").val("0");
            // set image size to auto
            $(".img_size_mode").val("auto");
            // disable width and height
            $(".form_group_img > input").attr("disabled", true);
            // disable align image
            $(".align_image_modal").attr("disabled", true);
            // remove blue border
            $(".img_btn_container_select").removeClass("img_btn_container_select");
            // enable body scroling
            $("body").css("overflow-y", "scroll");
            // set align image to left
            $(".align_image_modal").val("left");
        });

    /* ============================== /close modal ============================== */

    /* ============================== img_btn ============================== */

        $(".img_btn_radio").click(function () {
            var image       = $(this).attr("img_url");
            var image_url   = $("#build_cms_base_url").attr("base_url") + "/images/" + image;

            $(".selected_image > img").attr("src", image_url);

            // blue border
            $(".img_btn_container_select").removeClass("img_btn_container_select");
            $(this).parent().parent().addClass("img_btn_container_select");

            // add image to img block
            image_block_modal().attr("src", image_url);
            image_block_modal().attr("img_filename", image);
        });

    /* ============================== /img_btn ============================== */

    /* ============================== image size ============================== */

        $(".img_size_mode").change(function () {
            if (image_block_modal().attr("category_image") === undefined) {
                if ($(this).val() === "custom") {
                    // enable
                    $(".form_group_img > input").removeAttr("disabled");
                    $(".align_image_modal").removeAttr("disabled");
                    image_block_modal().attr("img_size_mode", "custom");

                    // set height and width
                    image_block_modal().attr("height", image_block_modal().attr("img_height") );
                    image_block_modal().attr("width", image_block_modal().attr("img_width") );
                }
                
                if ($(this).val() === "auto") {
                    // disable
                    $(".form_group_img > input").attr("disabled", true);
                    $(".align_image_modal").attr("disabled", true);
                    image_block_modal().attr("img_size_mode", "auto");
                    image_block_modal().removeAttr("width");
                    image_block_modal().removeAttr("height");
                }
            }
        });

        // X
        $('.form_group_img > input[name="img_width"]').change(function () {
            if (image_block_modal().attr("category_image") === undefined) {
                var img_width = $(this).val();
                image_block_modal().attr("img_width", img_width);
                image_block_modal().attr("width", img_width);
            }
        });

        // Y
        $('.form_group_img > input[name="img_height"]').change(function () {
            if (image_block_modal().attr("category_image") === undefined) {
                var img_height = $(this).val();
                image_block_modal().attr("img_height", img_height);
                image_block_modal().attr("height", img_height);
            }
        });

    /* ============================== /image size ============================== */

    /* ============================== Align image ============================== */

        $(".align_image_modal").change(function () {
            if (image_block_modal().attr("category_image") === undefined) {
                // left
                if ($(this).val() === "left") {
                    image_block_modal().removeClass("align_image_right");
                    image_block_modal().removeClass("align_image_center");
                }

                // right
                if ($(this).val() === "right") {
                    image_block_modal().removeClass("align_image_center");
                    image_block_modal().addClass("align_image_right");
                }

                // center
                if ($(this).val() === "center") {
                    image_block_modal().removeClass("align_image_right");
                    image_block_modal().addClass("align_image_center");
                }
            }
        });

    /* ============================== /Align image ============================== */
});