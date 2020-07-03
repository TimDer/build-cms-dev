/* ============================== Save content ============================== */

    var block_functions = {};

    function building_blocks_area_save_function(block_type, save_block_function) {
        if (!(block_type in block_functions)) {
            block_functions[block_type] = save_block_function;
        }
    }

    function get_data_from_blocks(this_block, block_order) {
        var block_array;

        if (this_block[0].hasAttribute("block_type")) {
            block_array = block_functions[this_block.attr("block_type")](this_block, block_order);
        }

        return block_array;
    }


    system_area_save_function("page_builder", function () {
        // save all blocks
        var all_building_blocks_areas = {};
        var building_blocks_area = "";
        var the_order = 0;
        $('.sortable-building-blocks').each(function () {
            building_blocks_area = $(this).attr("building_blocks_area");
            all_building_blocks_areas[building_blocks_area] = {};
            the_order = 1;
            $(this).children().each(function () {
                all_building_blocks_areas[building_blocks_area][the_order] = {
                    block_type: $(this).attr("block_type"),
                    block_id: $(this).attr("block_id"),
                    block_status: $(this).attr("block_status"),
                    the_order: the_order,
                    data: get_data_from_blocks($(this), the_order)
                };
                the_order++;
            });
        });

        // delete blocks
        var del_blocks_array      = {};
        var del_blocks_the_order  = 0;
        $("#del_area_blocks > .block").each(function () {
            del_blocks_array[del_blocks_the_order] = {
                block_type: $(this).attr("block_type"),
                block_id: $(this).attr("block_id"),
                data: get_data_from_blocks($(this), del_blocks_the_order)
            };

            del_blocks_the_order++;
        });

        var data = {};
        data["building-blocks"]   = all_building_blocks_areas;
        data["del_blocks_array"]  = del_blocks_array;

        return data;
    });

    building_blocks_area_save_function("wysiwyg", function (this_block, block_order) {
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
        wysiwyg_data["the_order"]   = block_order;

        return wysiwyg_data;
    });

    building_blocks_area_save_function("plain_text", function (this_block, block_order) {
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
        plain_text_data["the_order"]        = block_order;

        return plain_text_data;
    });

    building_blocks_area_save_function("image", function (this_block, block_order) {
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
        image_data["the_order"]     = block_order;

        return image_data;
    });

    building_blocks_area_save_function("subcategories", function (this_block, block_order) {
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
        data["the_order"]                   = block_order;

        return data;
    });

    building_blocks_area_save_function("create_columns", function (this_block, block_order) {
        var create_columns_data             = {};

        create_columns_data["block_type"]   = "create_columns";
        create_columns_data["the_order"]    = block_order;
        create_columns_data["block_id"]     = this_block.attr("create_columns_id");
        //create_columns_data["data"]         = {};
        create_columns_data["status"]       = this_block.attr("block_status");
        create_columns_data["width"]        = {};
        
        this_block.find(".the_column").each(function () {
            var create_columns_column_id = $(this).attr("column") - 1;
            //var create_columns_the_order = 0;

            // add column width
            create_columns_data["width"][create_columns_column_id]              = {};
            
            create_columns_data["width"][create_columns_column_id]["width_id"]  = create_columns_column_id;
            create_columns_data["width"][create_columns_column_id]["width"]     = $(this).attr("flex");

            // create new column data array
            /*create_columns_data["data"][create_columns_column_id] = {};

            $(this).find(".column-building-blocks-area > .block").each(function () {
                if ($(this).hasClass("wysiwyg")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = block_functions["wysiwyg"]($(this), create_columns_the_order);
                }
                else if ($(this).hasClass("plain-text")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = block_functions["plain_text"]($(this), create_columns_the_order);
                }
                else if ($(this).hasClass("image")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = block_functions["image"]($(this), create_columns_the_order);
                }
                else if (this_block.hasClass("subcategories")) {
                    create_columns_data["data"][create_columns_column_id][create_columns_the_order] = block_functions["subcategories"](this_block, block_order);
                }

                create_columns_the_order++;
            }); */ // <-- $(this).find(".column-building-blocks-area").find(".block")
        }); // <-- this_block.find(".the_column")

        return create_columns_data;
    });

/* ============================== /Save content ============================== */

/* ============================== move blocks ============================== */

    $(function () {
        // create_columns move wysiwyg to left column
        var wysiwyg_id_number   = "";
        var wysiwyg_id          = "";
        var wysiwyg_data        = "";
        create_columns_move_block_function("wysiwyg", function (move_to_column, JQ_this) {
            JQ_this.find(".wysiwyg-text-editer").each(function () {
                wysiwyg_id_number   = $(this).attr("wysiwyg_id");
                wysiwyg_id          = $(this).attr("id");
                wysiwyg_data        = tinymce.get( wysiwyg_id ).getContent();
                $(this).parent().html("");
            });
    
            move_to_column.append(JQ_this.clone());
            JQ_this.remove();
            
            move_to_column.find('.block[block_type="wysiwyg"]:last-child').find(".content").each(function () {
                $(this).html(function () {
                    return '<button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="' + wysiwyg_id + '" wysiwyg_id="' + wysiwyg_id_number + '" rows="10">' + wysiwyg_data + '</textarea>';
                });
                wysiwyg_id_number   = "";
                wysiwyg_data        = "";
                wysiwyg_id          = "";
            });
            text_editer();
        });
    });

    $(function () {
        var wysiwyg_data        = "";
        var wysiwyg_id          = "";
        var wysiwyg_id_number   = 0;
        var wysiwyg_array       = [];

        // sortable get wysiwyg
        sortable_get_move_block_function("wysiwyg", function (event, ui) {
            ui.item.each(function () {
                $(this).attr("id", "wysiwyg_block_sortable");

                var wysiwyg_text_editer = $(this).find(".wysiwyg-text-editer").attr("id");

                wysiwyg_data        = tinymce.get(wysiwyg_text_editer).getContent();
                wysiwyg_id          = wysiwyg_text_editer;
                wysiwyg_id_number   = $("#" + wysiwyg_text_editer).attr("wysiwyg_id");
            });
        });

        // sortable get create_columns
        sortable_get_move_block_function("create_columns", function (event, ui) {
            ui.item.each(function () {
                $(this).attr("id", "create_columns-wysiwyg_block_sortable");

                var wysiwyg_array_key_number = -1;
                $(this).find(".the_column").each(function () {
                    $(this).find(".wysiwyg").each(function () {
                        wysiwyg_array_key_number = wysiwyg_array_key_number + 1;

                        var wysiwyg_text_editer = $(this).find(".wysiwyg-text-editer").attr("id");

                        $(this).attr("id", "wysiwyg_block_sortable-" + wysiwyg_text_editer);
                        
                        wysiwyg_array[wysiwyg_array_key_number] = {
                            wysiwyg_data:       tinymce.get(wysiwyg_text_editer).getContent(),
                            wysiwyg_id:         wysiwyg_text_editer,
                            wysiwyg_id_number:  $("#" + wysiwyg_text_editer).attr("wysiwyg_id")
                        };
                    });
                });
            });
        });

        // sortable set wysiwyg
        sortable_set_move_block_function("wysiwyg", function () {
            $(".sortable-building-blocks").find("#wysiwyg_block_sortable").each(function () {
                $(this).removeAttr("id");
                
                $(this).find(".content").html(function () {
                    return '<button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="' + wysiwyg_id + '" wysiwyg_id="' + wysiwyg_id_number + '" rows="10">' + wysiwyg_data + '</textarea>';
                });
                text_editer();

                wysiwyg_data        = "";
                wysiwyg_id          = "";
                wysiwyg_id_number   = 0;
            });
        });

        // sortable set create_columns
        sortable_set_move_block_function("create_columns", function () {
            $("#create_columns-wysiwyg_block_sortable").each(function () {
                $(this).removeAttr("id");

                wysiwyg_array.forEach(function (wysiwyg_object) {
                    $("#wysiwyg_block_sortable-" + wysiwyg_object.wysiwyg_id).each(function () {
                        $(this).removeAttr("id");

                        $(this).find(".content").html(function () {
                            return '<button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="' + wysiwyg_object.wysiwyg_id + '" wysiwyg_id="' + wysiwyg_object.wysiwyg_id_number + '" rows="10">' + wysiwyg_object.wysiwyg_data + '</textarea>';
                        });
                    });
                });
                text_editer();

                wysiwyg_array = new Array();
            });
        });
    });

/* ============================== /move blocks ============================== */

/* ============================== make blocks ============================== */

    $(function () {
        make_block_function("wysiwyg", function (block_id) {
            return '<div class="wysiwyg" block_type="wysiwyg"><div class="header">Visual Editor</div><div class="content"><button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="wysiwyg_id-' + block_id + '" wysiwyg_id="' + block_id + '" rows="10"></textarea></div></div>';
        });

        make_block_function("plain_text", function (block_id) {
            return '<div class="plain-text" block_type="plain_text"><div class="header">plain text</div><div class="content"><button class="delete_block">Delete</button><textarea name="text-editer" class="plain-text-editer" id="plain_text-' + block_id + '" plain_text="' + block_id + '" rows="10"></textarea></div></div>';
        });

        make_block_function("create_columns", function (block_id) {
            return '<div class="create-columns" block_type="create_columns"><div class="header">create-columns</div><div class="content"><button class="delete_block">Delete</button><p>Number of columns</p><input type="number" name="create-columns-number" class="create-columns-number" value="1" min="1" max="12"><div class="columns"><div class="the_column" column="1" style="flex: 100;" flex="100"><input type="number" name="column-width" value="100" min="0" max="100" class="column-width-number">%<div class="column-building-blocks-area sortable-building-blocks" building_blocks_area="' + block_id + '-0"></div></div></div></div></div>';
        });

        make_block_function("subcategories", function (block_id) {
            return '<div class="subcategories" id="subcategories_block_' + block_id + '" subcategories_block_id="' + block_id + '" block_type="subcategories"><div class="header">subcategories</div><div class="content"><button class="delete_block">Delete</button><select name="subcategories_limit"><option value="no-limit">No limit</option><option value="limited">Limited</option></select><input type="number" name="subcategories_limit_number" min="0" value="1"><select name="subcategories_order"><option value="latest">Latest page first</option><option value="first">First page first</option></select></div></div>';
        });
    });

/* ============================== /make blocks ============================== */