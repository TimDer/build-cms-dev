/* ============================== block content functions ============================== */

    function get_wysiwyg_data(this_block, block_order) {
        var wysiwyg_content_html_id = this_block.find(".wysiwyg-text-editer").attr("id");
        var wysiwyg_content_id      = $("#" + wysiwyg_content_html_id).attr("wysiwyg_id");
        var wysiwyg_content_data    = tinymce.get(wysiwyg_content_html_id).getContent();
        var wysiwyg_content_status  = this_block.attr("block_status");

        // setup new array
        wysiwyg_data = {};

        // add data to the new array
        wysiwyg_data["block_type"]  = "wysiwyg";
        wysiwyg_data["wysiwyg_id"]  = wysiwyg_content_id;
        wysiwyg_data["status"]      = wysiwyg_content_status;
        wysiwyg_data["data"]        = wysiwyg_content_data;
        wysiwyg_data["the_order"]   = block_order + 1;

        return wysiwyg_data;
    }

    function get_plain_text(this_block, block_order) {
        var plain_text_content_html_id  = this_block.find(".plain-text-editer").attr("id");
        var plain_text_content_id       = $("#" + plain_text_content_html_id).attr("plain_text");
        var plain_text_content_data     = $("#" + plain_text_content_html_id).val();
        var plain_text_content_status   = this_block.attr("block_status");

        // setup new array
        plain_text_data = {};

        // add data to the new array
        plain_text_data["block_type"]       = "plain_text";
        plain_text_data["plain-text_id"]    = plain_text_content_id;
        plain_text_data["status"]           = plain_text_content_status;
        plain_text_data["data"]             = plain_text_content_data;
        plain_text_data["the_order"]        = block_order + 1;

        return plain_text_data;
    }

    function get_image(this_block, block_order) {
        // get data from block
        var image_content_html_id       = this_block.find(".img_data").attr("id");
        var image_content_id            = $("#" + image_content_html_id).attr("image_id");
        var image_content_filename      = $("#" + image_content_html_id).attr("img_filename");
        var image_content_img_size_mode = $("#" + image_content_html_id).attr("img_size_mode");
        var image_content_img_width     = $("#" + image_content_html_id).attr("img_width");
        var image_content_img_height    = $("#" + image_content_html_id).attr("img_height");
        var image_content_status        = this_block.attr("block_status");

        // get center left or right from block
        if (this_block.find(".img_data").hasClass("align_image_center")) {
            var image_content_align = "center";
        }
        else if (this_block.find(".img_data").hasClass("align_image_right")) {
            var image_content_align = "right";
        }
        else {
            var image_content_align = "left";
        }

        // setup new array
        image_data = {};

        // store data in the new array
        image_data["block_type"]    = "image";
        image_data["image_id"]      = image_content_id;
        image_data["filename/data"] = image_content_filename;
        image_data["status"]        = image_content_status;
        image_data["img_size_mode"] = image_content_img_size_mode;
        image_data["img_width"]     = image_content_img_width;
        image_data["img_height"]    = image_content_img_height;
        image_data["align"]         = image_content_align;
        image_data["the_order"]     = block_order + 1;

        return image_data;
    }

    function get_subcategories(this_block, block_order) {
        var block_id                    = this_block.attr("subcategories_block_id");
        var block_status                = this_block.attr("block_status");
        var block_type                  = "subcategories";
        var subcategories_limit         = this_block.find('select[name="subcategories_limit"]').val();
        var subcategories_limit_number  = this_block.find('input[name="subcategories_limit_number"]').val();
        var subcategories_order         = this_block.find('select[name="subcategories_order"]').val();

        // setup array
        var data = {};
        
        // add the data to the new array
        data["block_id"]                    = block_id;
        data["status"]                      = block_status;
        data["block_type"]                  = block_type;
        data["subcategories_limit"]         = subcategories_limit;
        data["subcategories_limit_number"]  = subcategories_limit_number;
        data["subcategories_order"]         = subcategories_order;
        data["the_order"]                   = block_order + 1;

        return data;
    }

    function get_create_columns(this_block, block_order) {
        var create_columns_data             = {};

        create_columns_data["block_type"]   = "create_columns";
        create_columns_data["the_order"]    = block_order + 1;
        create_columns_data["block_id"]     = this_block.attr("create_columns_id");
        create_columns_data["data"]         = {};
        create_columns_data["status"]       = this_block.attr("block_status");
        create_columns_data["width"]        = {};
        
        this_block.find(".the_column").each(function () {
            var create_columns_column_id = $(this).attr("column") - 1;
            var create_columns_the_order = 0;

            // add column width
            create_columns_data["width"][create_columns_column_id]              = {};
            
            create_columns_data["width"][create_columns_column_id]["width_id"]  = create_columns_column_id;
            create_columns_data["width"][create_columns_column_id]["width"]     = $(this).attr("flex");

            // create new column data array
            create_columns_data["data"][create_columns_column_id] = {};

            $(this).find(".column-building-blocks-area > .block").each(function () {
                if ($(this).hasClass("wysiwyg")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = get_wysiwyg_data($(this), create_columns_the_order);
                }
                else if ($(this).hasClass("plain-text")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = get_plain_text($(this), create_columns_the_order);
                }
                else if ($(this).hasClass("image")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = get_image($(this), create_columns_the_order);
                }

                create_columns_the_order++;
            }); /* <-- $(this).find(".column-building-blocks-area").find(".block") */
        }); /* <-- this_block.find(".the_column") */

        return create_columns_data;
    }

    function get_data_from_blocks(this_block, block_order) {
        var block_array;

        if (this_block.hasClass("wysiwyg")) {
            block_array = get_wysiwyg_data(this_block, block_order);
        }
        else if (this_block.hasClass("plain-text")) {
            block_array = get_plain_text(this_block, block_order);
        }
        else if (this_block.hasClass("image")) {
            block_array = get_image(this_block, block_order);
        }
        else if (this_block.hasClass("create-columns")) {
            block_array = get_create_columns(this_block, block_order);
        }
        else if (this_block.hasClass("subcategories")) {
            block_array = get_subcategories(this_block, block_order);
        }

        return block_array;
    }

/* ============================== /block content functions ============================== */

/* ============================== ajax functions ============================== */

    function ajax_success(this_massage) {
        // delete del blocks
        $("#del_area_blocks > .block").each(function () {
            $(this).remove();
        });

        // set block status to saved
        $("#building-blocks-area, #sortable-building-blocks-left, #sortable-building-blocks-right").find(".block").each(function () {
            $(this).attr("block_status", "saved");
        });

        // set page title
        $("#td_cms-page_title").text( "Edit: " + $('input[name="pagename"]').val() );

        // get page id
        $('input[name="page_id"]').attr("value", this_massage.page_id)

        // added massage
        $("html, body").animate({ scrollTop: 0 }, 0);
        $("#save_massage_success").css("display", "block");
        $("#save_massage_success").html( this_massage.status );

        setTimeout(function () {
            $("#save_massage_success").removeAttr("style");
        }, (3 * 1000));
    }

    function ajax_error(fail_massage = "fail") {
        $("html, body").animate({ scrollTop: 0 }, 0);
        $("#save_massage_success").css("display", "block");
        $("#save_massage_success").css("background-color", "red");
        $("#save_massage_success").html( fail_massage );

        setTimeout(function () {
            $("#save_massage_success").removeAttr("style");
        }, (3 * 1000));
    }

/* ============================== ajax functions ============================== */

/* ============================== other functions ============================== */

    function page_category() {
        return $("#page-category").find('input[checked="checked"]').val();
    }

    function get_category_info() {
        var image       = $("#category_image").attr("img_filename");
        var text        = tinymce.get("category_text").getContent();

        var data        = {};

        data["image"]   = image;
        data["text"]    = text;

        return data;
    }

/* ============================== /other functions ============================== */


$(document).ready(function () {

    $("#add_btn").click(function () {
        /* ============================== check if inputs are empty ============================== */

            if ($('input[name="pagename"]').val() === "") {
                ajax_error('Please fill out "Pagename"');
                return;
            }

            if ($('input[name="url"]').val() === "") {
                ajax_error('Please fill out "URL name"');
                return;
            }

        /* ============================== check if inputs are empty ============================== */

        /* ============================== General ============================== */
            var general_pagename    = $('input[name="pagename"]').val();
            var general_url         = $('input[name="url"]').val();
            var general_status      = $('select[name="status"]').val();
            var general_homepage    = $('input[name="homepage"]').attr("checked");
            var general_page_id     = $('input[name="page_id"]').attr("value");
        /* ============================== /General ============================== */

        /* ============================== SEO ============================== */
            var seo_pagetitle       = $('input[name="pagetitle"]').val();
            var seo_author          = $('input[name="author"]').val();
            var seo_keywords        = $('input[name="keywords"]').val();
            var seo_description     = $('input[name="description"]').val();
        /* ============================== /SEO ============================== */

        /* ============================== content ============================== */
            var content = {};
            var the_order = 0;
            $('#building-blocks-area > .block').each(function () {
                content[the_order] = get_data_from_blocks($(this), the_order);

                the_order++;
            }); /* <-- $('#building-blocks-area') */
        /* ============================== /content ============================== */
        
        /* ============================== Left sidebar ============================== */

            var left_sidebar_array      = {};
            var left_sidebar_the_order  = 0;
            $("#sortable-building-blocks-left > .block").each(function () {
                left_sidebar_array[left_sidebar_the_order] = get_data_from_blocks($(this), left_sidebar_the_order);

                left_sidebar_the_order++;
            });

        /* ============================== /Left sidebar ============================== */

        /* ============================== right sidebar ============================== */

            var right_sidebar_array      = {};
            var right_sidebar_the_order  = 0;
            $("#sortable-building-blocks-right > .block").each(function () {
                right_sidebar_array[right_sidebar_the_order] = get_data_from_blocks($(this), right_sidebar_the_order);

                right_sidebar_the_order++;
            });

        /* ============================== /right sidebar ============================== */

        /* ============================== delete blocks ============================== */

            var del_blocks_array      = {};
            var del_blocks_the_order  = 0;
            $("#del_area_blocks > .block").each(function () {
                del_blocks_array[del_blocks_the_order] = get_data_from_blocks($(this), del_blocks_the_order);

                del_blocks_the_order++;
            });

        /* ============================== /delete blocks ============================== */

        
        /* ============================== data array ============================== */
            var data_array = {};

            // General
            data_array["general_pagename"]      = general_pagename;
            data_array["general_url"]           = general_url;
            data_array["general_status"]        = general_status;
            data_array["general_homepage"]      = general_homepage;
            data_array["general_page_id"]       = general_page_id;

            // SEO
            data_array["seo_pagetitle"]         = seo_pagetitle;
            data_array["seo_author"]            = seo_author;
            data_array["seo_keywords"]          = seo_keywords;
            data_array["seo_description"]       = seo_description;

            // content
            data_array["content"]               = content;

            // Left sidebar
            data_array["left_sidebar_array"]    = left_sidebar_array;

            // right sidebar
            data_array["right_sidebar_array"]   = right_sidebar_array;

            // delete
            data_array["del_blocks_array"]      = del_blocks_array;

            // page_category
            data_array["page_category"]         = page_category();

            // category info
            data_array["category_info"]         = get_category_info();
        /* ============================== data array ============================== */


        /* ============================== ajax ============================== */
            
            $.ajax({
                enctype: 'application/x-www-form-urlencoded',
                type: "POST",
                url: $("#td_cms_base_url").attr("base_url") + "/admin_submit/page",
                dataType: "json",
                data: data_array,
                success: function (massage) {
                    ajax_success(massage);
                },
                error: function (massage) {
                    ajax_error(massage);
                }
            });

        /* ============================== /ajax ============================== */
    }); /* <-- $("#add_btn").click() */

}); /* <-- $(document).ready() */