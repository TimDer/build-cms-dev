$(document).ready(function () {

    // stop if on add page
    // continue if on edit page
    if ($('input[name="page_id"]').attr("value") === "new") {
        return;
    }

    /* ============================== functions ============================== */

        class load_blocks {
            constructor (block_object) {
                var self = this;
                
                // Load the content, left_sidebar and right_sidebar area
                $.each(block_object, function (key, value) {
                    if (value.building_blocks_area === "content" || value.building_blocks_area === "left_sidebar" || value.building_blocks_area === "right_sidebar") {
                        self.loop_blocks(value, value.building_blocks_area);
                    }
                });
                
                // Load the create columns areas
                $.each(block_object, function (key, value) {
                    if (value.building_blocks_area !== "content" && value.building_blocks_area !== "left_sidebar" && value.building_blocks_area !== "right_sidebar") {
                        self.loop_blocks(value, value.building_blocks_area);
                    }
                });

                // activate the wysiwyg
                text_editer();
                td_sortable();
            }

            loop_blocks (blocks_object, building_blocks_area) {
                var self = this;

                $.each(blocks_object, function (key, value) {
                    if (value !== building_blocks_area) {
                        if (value.block_type === "wysiwyg") {
                            self.load_wysiwyg(value);
                        }
                        else if (value.block_type === "plain_text") {
                            self.load_plain_text(value);
                        }
                        else if (value.block_type === "image") {
                            self.load_image(value);
                        }
                        else if (value.block_type === "create_columns") {
                            self.load_create_columns(value);
                        }
                        else if (value.block_type === "subcategories") {
                            self.load_subcategories(value);
                        }
                    }
                });
            }

            load_wysiwyg (block_object) {
                var block_html = '<div class="wysiwyg block" block_status="saved"><div class="header">Visual Editor</div><div class="content"><button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="wysiwyg_id-' + block_object.block_id + '" wysiwyg_id="' + block_object.block_id + '" rows="10">' + block_object.data + '</textarea></div></div>';

                if (block_object.building_blocks_area === "content") {
                    $("#building-blocks-area").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "left_sidebar") {
                    $("#sortable-building-blocks-left").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "right_sidebar") {
                    $("#sortable-building-blocks-right").append(function () {
                        return block_html;
                    });
                }
                else {
                    $("#building_blocks_area_" + block_object.building_blocks_area).append(function () {
                        return block_html;
                    });
                }
            }

            load_plain_text (block_object) {
                var block_html = '<div class="plain-text block" block_status="saved"><div class="header">plain text</div><div class="content"><button class="delete_block">Delete</button><textarea name="text-editer" class="plain-text-editer" id="plain_text-' + block_object.block_id + '" plain_text="' + block_object.block_id + '" rows="10">' + block_object.data + '</textarea></div></div>';

                if (block_object.building_blocks_area === "content") {
                    $("#building-blocks-area").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "left_sidebar") {
                    $("#sortable-building-blocks-left").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "right_sidebar") {
                    $("#sortable-building-blocks-right").append(function () {
                        return block_html;
                    });
                }
                else {
                    $("#building_blocks_area_" + block_object.building_blocks_area).append(function () {
                        return block_html;
                    });
                }
            }

            load_image (block_object) {
                if (block_object.data !== "") {
                    var img_src = $("#td_cms_base_url").attr("base_url") + "/images/" + block_object.data;
                }
                else {
                    var img_src = "";
                }

                if (block_object.img_size_mode === "custom") {
                    var img_size = 'width="' + block_object.img_width + '" height="' + block_object.img_height + '"';
                }
                else {
                    var img_size = '';
                }

                // image align
                if (block_object.image_align === "center") {
                    var image_content_align = "align_image_center";
                }
                else if (block_object.image_align === "right") {
                    var image_content_align = "align_image_right";
                }
                else if (block_object.image_align === "left") {
                    var image_content_align = "";
                }

                var block_html = '<div class="image block" block_status="saved"><div class="header">image</div><div class="content"><button class="delete_block">Delete</button><button class="image-open-modal-btn">Select an image</button><img src="' + img_src + '" alt="Select an image" class="img_data ' + image_content_align + '" id="image-' + block_object.block_id + '" image_id="' + block_object.block_id + '" img_filename="' + block_object.data + '" img_size_mode="' + block_object.img_size_mode + '" img_width="' + block_object.img_width + '" img_height="' + block_object.img_height + '" ' + img_size + '></div></div>';

                if (block_object.building_blocks_area === "content") {
                    $("#building-blocks-area").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "left_sidebar") {
                    $("#sortable-building-blocks-left").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "right_sidebar") {
                    $("#sortable-building-blocks-right").append(function () {
                        return block_html;
                    });
                }
                else {
                    $("#building_blocks_area_" + block_object.building_blocks_area).append(function () {
                        return block_html;
                    });
                }
            }

            load_subcategories (block_object) {
                var block_html = '<div class="subcategories block" block_status="saved" id="subcategories_block_load" subcategories_block_id="' + block_object.block_id + '"><div class="header">subcategories</div><div class="content"><button class="delete_block">Delete</button></div></div>';

                if (block_object.building_blocks_area === "content") {
                    $("#building-blocks-area").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "left_sidebar") {
                    $("#sortable-building-blocks-left").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "right_sidebar") {
                    $("#sortable-building-blocks-right").append(function () {
                        return block_html;
                    });
                }
                else {
                    $("#building_blocks_area_" + block_object.building_blocks_area).append(function () {
                        return block_html;
                    });
                }

                // setup vars
                var no_limit    = "";
                var limited     = "";
                var latest      = "";
                var first       = "";

                // set selected in html
                if (block_object.limit_type === "no-limit") {
                    no_limit = " selected";
                }
                else if (block_object.limit_type === "limited") {
                    limited = " selected";
                }
                if (block_object.sort === "first") {
                    first = " selected";
                }
                else if (block_object.sort === "latest") {
                    latest = " selected";
                }


                $("#subcategories_block_load").find(".content").append('<select name="subcategories_limit"><option value="no-limit"' + no_limit + '>No limit</option><option value="limited"' + limited + '>Limited</option></select>');
                $("#subcategories_block_load").find(".content").append('<input type="number" name="subcategories_limit_number" min="0" value="' + block_object.the_limit + '">');
                $("#subcategories_block_load").find(".content").append('<select name="subcategories_order"><option value="latest"' + latest + '>Latest page first</option><option value="first"' + first + '>First page first</option></select>');

                $("#subcategories_block_load").removeAttr("id");
            }

            load_create_columns (block_object) {
                // get the amount of columns
                var create_columns_number = 0;
                $.each(block_object.width, function (key) {
                    create_columns_number = Number(key) + 1;
                });

                // create the block
                var block_html = '<div class="create-columns block" block_status="saved" create_columns_id="' + block_object.block_id + '" id="create-columns_block_load"><div class="header">create-columns</div><div class="content"><button class="delete_block">Delete</button><p>Number of columns</p><input type="number" name="create-columns-number" class="create-columns-number" value="' + create_columns_number + '" min="1" max="12"><div class="columns"></div></div></div>';

                // load block
                if (block_object.building_blocks_area === "content") {
                    $("#building-blocks-area").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "left_sidebar") {
                    $("#sortable-building-blocks-left").append(function () {
                        return block_html;
                    });
                }
                else if (block_object.building_blocks_area === "right_sidebar") {
                    $("#sortable-building-blocks-right").append(function () {
                        return block_html;
                    });
                }

                // load columns
                $.each(block_object.width, function (key, value) {
                    var column_html = '<div class="the_column" column="' + (Number(value.column_id) + 1) + '" style="flex: ' + value.width + ';" flex="' + value.width + '"><input type="number" name="column-width" value="100" min="0" max="100" class="column-width-number">%<div class="column-building-blocks-area sortable-building-blocks" id="building_blocks_area_' + value.block_id + '-' + value.column_id + '"></div></div>';

                    $("#create-columns_block_load").find(".columns").append(column_html);
                });

                $("#create-columns_block_load").removeAttr("id");
            }
        }

        function load_page_error(massage) {
            alert("Could not properly load page");
        }

    /* ============================== /functions ============================== */

    // ajax
    $.ajax({
        url: $("#td_cms_base_url").attr("base_url") + "/admin_submit/page/load-page/" + $('input[name="page_id"]').attr("value"),
        type: "POST",
        dataType: "json",
        success: function (massage) {
            new load_blocks(massage);
        },
        error: function (massage) {
            load_page_error(massage);
        }
    });

}); /* <-- $(document).ready() */