/* ============================== sortable ============================== */
    function td_sortable() {
        var wysiwyg_data        = "";
        var wysiwyg_id          = "";
        var wysiwyg_id_number   = 0;
        var wysiwyg_array       = [];

        $(".sortable-building-blocks").sortable({
            connectWith: ".sortable-building-blocks",

            sort: function (event, ui) {
                // reload one wysiwyg
                if (ui.item.is(".wysiwyg")) {
                    ui.item.each(function () {
                        $(this).attr("id", "wysiwyg_block_sortable");

                        var wysiwyg_text_editer = $(this).find(".wysiwyg-text-editer").attr("id");

                        wysiwyg_data        = tinymce.get(wysiwyg_text_editer).getContent();
                        wysiwyg_id          = wysiwyg_text_editer;
                        wysiwyg_id_number   = $("#" + wysiwyg_text_editer).attr("wysiwyg_id");
                    });
                } // reload wysiwyg in a "create_columns" block
                else if (ui.item.is(".create-columns")) {
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
                }
            },
            stop: function () {
                // reload one wysiwyg
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

                // reload wysiwyg in a "create_columns" block
                $(".sortable-building-blocks").find("#create_columns-wysiwyg_block_sortable").each(function () {
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
            }
        });
    }
/* ============================== /sortable ============================== */

$(document).ready(function () {

    var current_block       = null;
    var current_block_name  = null;

    // activate sortable
    td_sortable();

    /* ============================== create-columns columns ============================== */
        function create_columns_columns() {
            $(document).on("change", '.create-columns-number', function (event) {
                event.stopImmediatePropagation();
                if ($(this).val() > 0) {
                    // number_of_columns
                    var number_of_columns;
                    $(this).parent().find(".the_column").each(function (e, ui) {
                        number_of_columns = parseInt($(this).attr("column"));
                    });
                    var new_number_of_columns = number_of_columns + 1;

                    // input value
                    input_value = parseInt($(this).val());

                    // remove
                    if (input_value < number_of_columns) {
                        for (let remove_column_number = number_of_columns; remove_column_number > input_value; remove_column_number = remove_column_number - 1) {
                            // move
                            var move_to_child       = $(this).parent().find('.the_column[column="' + (remove_column_number - 1) + '"]').find(".column-building-blocks-area");
                            var wysiwyg_id_number   = "";
                            var wysiwyg_id          = "";
                            var wysiwyg_data        = "";
                            $(this).parent().find('.the_column[column="' + remove_column_number + '"]').each(function () {
                                $(this).find(".column-building-blocks-area").find(".block").each(function () {
                                    // wysiwyg
                                    if ($(this).hasClass("wysiwyg")) {
                                        $(this).find(".wysiwyg-text-editer").each(function () {
                                            wysiwyg_id_number   = $(this).attr("wysiwyg_id");
                                            wysiwyg_id          = $(this).attr("id");
                                            wysiwyg_data        = tinymce.get( wysiwyg_id ).getContent();
                                            $(this).parent().html("");
                                        });

                                        move_to_child.append($(this).clone());
                                        $(this).remove();
                                        
                                        move_to_child.find(".wysiwyg:last-child").find(".content").each(function () {
                                            $(this).html(function () {
                                                return '<button class="delete_block">Delete</button><textarea name="text-editer" class="wysiwyg-text-editer" id="' + wysiwyg_id + '" wysiwyg_id="' + wysiwyg_id_number + '" rows="10">' + wysiwyg_data + '</textarea>';
                                            });
                                            wysiwyg_id_number   = "";
                                            wysiwyg_data        = "";
                                            wysiwyg_id          = "";
                                        });
                                    } // else
                                    else {
                                        move_to_child.append($(this).clone());
                                        $(this).remove();
                                    }
                                });
                            });

                            // remove
                            $(this).parent().find('.the_column[column="' + remove_column_number + '"]').remove();
                            text_editer();
                        }
                    }
                    
                    // add
                    if (input_value > number_of_columns) {
                        for (let column_number = new_number_of_columns; column_number <= input_value; column_number++) {
                            var add_html = '<div class="the_column" column="' + column_number + '" style="flex: 100;"><input type="number" name="column-width" value="100" min="0" max="100" class="column-width-number">%<div class="sortable-building-blocks column-building-blocks-area"></div></div>';

                            $(this).parent().find(".columns").append(function () {
                                return add_html;
                            });
                            td_sortable();
                        } 
                    }

                    var flex_column_width = 100 / $(this).val();

                    $(this).parent().find(".the_column").each(function () {
                        $(this).find(".column-width-number").val(flex_column_width);
                        $(this).attr("style", "flex: " + flex_column_width + ";");
                        $(this).attr("flex", flex_column_width);
                    });
                }
            });
        }
        create_columns_columns();
    /* ============================== /create-columns columns ============================== */


    // block id
    var block_id = $("#block_id_start").val();


    /* ============================== wysiwyg_block ============================== */
        $("#wysiwyg_block").draggable({
            helper: function () {
                //style="width: ' + $("#wysiwyg_block").width() + 'px"
                current_block_name  = "wysiwyg";
                current_block       = '<div style="width: ' + $("#wysiwyg_block").parent().width() + 'px" class="wysiwyg block" block_status="new" id="wysiwyg_block_move"><div class="header">Visual Editor</div><div class="content"><button class="delete_block">Delete</button><textarea name="new-text-editer" class="wysiwyg-text-editer" id="wysiwyg_id-' + block_id + '" wysiwyg_id="' + block_id + '" rows="10"></textarea></div></div>';
                block_id++;
                return current_block;
            }
        });
    /* ============================== /wysiwyg_block ============================== */

    /* ============================== plain-text_block ============================== */
        $("#plain-text_block").draggable({
            helper: function () {
                //style="width: ' + $("#plain-text_block").width() + 'px"
                current_block_name  = "plain-text_block";
                current_block       = '<div style="width: ' + $("#plain-text_block").parent().width() + 'px" class="plain-text block" block_status="new" id="plain-text_block_move"><div class="header">plain text</div><div class="content"><button class="delete_block">Delete</button><textarea name="text-editer" class="plain-text-editer" id="plain_text-' + block_id + '" plain_text="' + block_id + '" rows="10"></textarea></div></div>';
                block_id++;
                return current_block;
            }
        });
    /* ============================== /plain-text_block ============================== */

    /* ============================== image_block ============================== */
        $("#image_block").draggable({
            helper: function () {
                //style="width: ' + $("#image_block").width() + 'px"
                current_block_name  = "image_block";
                current_block       = '<div style="width: ' + $("#image_block").parent().width() + 'px" class="image block" block_status="new" id="image_block_move"><div class="header">image</div><div class="content"><button class="delete_block">Delete</button><button class="image-open-modal-btn">Select an image</button><img src="" alt="Select an image" class="img_data" id="image-' + block_id + '" image_id="' + block_id + '" img_filename="" img_size_mode="auto" img_width="0" img_height="0"></div></div>';
                block_id++;
                return current_block;
            }
        });
    /* ============================== /image_block ============================== */

    /* ============================== create-columns_block ============================== */
        $("#create-columns_block").draggable({
            helper: function () {
                //style="width: ' + $("#create-columns_block").width() + 'px"
                current_block_name  = "create-columns_block";
                current_block       = '<div style="width: ' + $("#create-columns_block").parent().width() + 'px" class="create-columns block" block_status="new" id="create-columns_block_move" create_columns_id="' + block_id + '"><div class="header">create-columns</div><div class="content"><button class="delete_block">Delete</button><p>Number of columns</p><input type="number" name="new-create-columns-number_move" value="1" min="1" max="12" disabled><div class="columns"><div class="the_column" column="1" style="flex: 100;" flex="100"><input type="number" name="column-width" value="100" min="0" max="100" disabled class="column-width-number">%<div class="new-column-building-blocks-area sortable-building-blocks"></div></div></div></div></div>';
                block_id++;
                return current_block;
            }
        });
    /* ============================== /create-columns_block ============================== */

    /* ============================== subcategories_block ============================== */
        $("#subcategories_block").draggable({
            helper: function () {
                //style="width: ' + $("#subcategories_block").width() + 'px"
                current_block_name  = "subcategories_block";
                current_block       = '<div style="width: ' + $("#subcategories_block").parent().width() + 'px" class="subcategories block" block_status="new" id="subcategories_block_move" subcategories_block_id="' + block_id + '"><div class="header">subcategories</div><div class="content"><button class="delete_block">Delete</button><select name="subcategories_limit" disabled><option value="no-limit">No limit</option><option value="limited">Limited</option></select><input type="number" name="subcategories_limit_number" min="0" value="1" disabled><select name="subcategories_order" disabled><option value="latest">Latest page first</option><option value="first">First page first</option></select></div></div>';
                block_id++;
                return current_block;
            }
        });
    /* ============================== /subcategories_block ============================== */

    /* ============================== droppable ============================== */
        function td_droppable(id) {
            $(id).append(function () {
                return current_block;
            });

            // wysiwyg
            if (current_block_name === "wysiwyg") {
                $("#wysiwyg_block_move").each(function () {
                    $(this).removeAttr("style");
                    $(this).removeAttr("id");
                    $(this).find('textarea[name="new-text-editer"]').each(function () {
                        $(this).attr('name', 'text-editer');
                    });
                });
                text_editer();
            } // plain-text_block
            else if (current_block_name === "plain-text_block") {
                $("#plain-text_block_move").each(function () {
                    $(this).removeAttr("style");
                    $(this).removeAttr("id");
                });
            } // image_block
            else if (current_block_name === "image_block") {
                $("#image_block_move").each(function () {
                    $(this).removeAttr("style");
                    $(this).removeAttr("id");
                });
            } // create-columns_block
            else if (current_block_name === "create-columns_block") {
                $("#create-columns_block_move").each(function () {
                    $(this).removeAttr("style");
                    $(this).removeAttr("id");

                    // .new-column-building-blocks-area
                    $(this).find(".new-column-building-blocks-area").each(function () {
                        $(this).removeClass("new-column-building-blocks-area");
                        $(this).addClass("column-building-blocks-area");
                    });

                    // input name="new-create-columns-number_move"
                    $(this).find('input[name="new-create-columns-number_move"]').each(function () {
                        $(this).attr("name", "create-columns-number");
                        $(this).addClass("create-columns-number");
                    });

                    // inputs
                    $(this).find("input").each(function () {
                        $(this).removeAttr("disabled");
                    });

                    // re-enable sortable-building-blocks class
                    td_sortable();

                    // re-enable create-columns-number class
                    create_columns_columns();
                });
            }
            else if (current_block_name === "subcategories_block") {
                $("#subcategories_block_move").each(function () {
                    $(this).removeAttr("style");
                    $(this).removeAttr("id");

                    // enabled form tags
                    $(this).find("select").removeAttr("disabled");
                    $(this).find("input").removeAttr("disabled");
                });
            }

            // reset variables
            current_block       = null;
            current_block_name  = null;
        }

        $(".sortable-building-blocks").droppable({
            drop: function (event, ui) {
                td_droppable($(this));
            }
        });
    /* ============================== /droppable ============================== */

    /* ============================== width columns_block ============================== */

        $(document).on("change", ".column-width-number", function () {
            var column_width_number = $(this).val();

            $(this).parent().each(function () {
                $(this).attr("style", "flex: " + column_width_number + ";");
                $(this).attr("flex", column_width_number);
            });
        });

    /* ============================== /width columns_block ============================== */

    /* ============================== delete_block btn ============================== */

        $(document).on("click", ".delete_block", function () {
            if (warning_message("solve this to delete your block", "Are you sure you want to delete this block?")) {
                return;
            }

            var del_block_from_building_area = $(this).parent().parent();

            del_block_from_building_area.toggle("highlight", 400);
            setTimeout(function () {
                if (del_block_from_building_area.hasClass("create-columns")) {
                    // delete new blocks
                    del_block_from_building_area.find('.block[block_status="new"]').each(function () {
                        $(this).remove();
                    });
                    // delete blocks from database
                    del_block_from_building_area.find('.block[block_status="saved"]').each(function () {
                        $("#del_area_blocks").append( $(this).clone() );
                        $(this).remove();
                    });
                }

                if (del_block_from_building_area.attr("block_status") !== "new") {
                    $("#del_area_blocks").append( del_block_from_building_area.clone() );
                }

                del_block_from_building_area.remove();
            }, 440);
        });

    /* ============================== /delete_block btn ============================== */

    /* ============================== open and close building-blocks-areas ============================== */

        $(".building-blocks-area-container > .header").click(function () {
            $(this).parent().children().each(function () {
                if ($(this).hasClass("content")) {
                    $(this).toggle("blind", 300);
                }
            });
        });

    /* ============================== /open and close building-blocks-areas ============================== */

}); // <-- $(document).ready()