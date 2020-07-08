/* ============================== move blocks ============================== */

    var create_columns_move_block_functions = {};

    function create_columns_move_block_function(block_type, move_block_function) {
        if (!(block_type in create_columns_move_block_functions)) {
            create_columns_move_block_functions[block_type] = move_block_function;
        }
    }

    var sortable_get_move_block_functions = {};

    function sortable_get_move_block_function(block_type, move_block_function) {
        if (!(block_type in sortable_get_move_block_functions)) {
            sortable_get_move_block_functions[block_type] = move_block_function;
        }
    }

    var sortable_set_move_block_functions = {};

    function sortable_set_move_block_function(block_type, move_block_function) {
        if (!(block_type in sortable_set_move_block_functions)) {
            sortable_set_move_block_functions[block_type] = move_block_function;
        }
    }

/* ============================== /move blocks ============================== */

/* ============================== block function ============================== */

    var make_block_functions = {};
    /*
    Example: make_block_functions
    {
        current_block_name: {
            current_block_name: "name",
            current_block: "html"
        }
    }
    */

    function make_block_function(current_block_name = "", current_block) {
        if (!(current_block_name in make_block_functions)) {
            make_block_functions[current_block_name] = {
                current_block_name: current_block_name,
                current_block:      current_block
            };
        }
    }

/* ============================== /block function ============================== */

/* ============================== droppable custom functions ============================== */

    var droppable_custom_functions = {};
    function droppable_custom_function(block, block_function) {
        if (!(block in droppable_custom_functions)) {
            droppable_custom_functions[block] = block_function;
        }
    }

/* ============================== /droppable custom functions ============================== */

/* ============================== sortable ============================== */
    function page_builder_sortable() {
        $(".sortable-building-blocks").sortable({
            connectWith: ".sortable-building-blocks",

            sort: function (event, ui) {
                if (ui.item.attr('block_type') in sortable_get_move_block_functions) {
                    sortable_get_move_block_functions[ui.item.attr('block_type')](event, ui);
                }
            },
            stop: function (event, ui) {
                if (ui.item.attr('block_type') in sortable_set_move_block_functions) {
                    sortable_set_move_block_functions[ui.item.attr('block_type')](event, ui);
                }
            }
        });
    }
/* ============================== /sortable ============================== */

$(document).ready(function () {

    var current_block       = null;
    var current_block_name  = null;

    // activate sortable
    page_builder_sortable();

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
                            var move_to_column = $(this).parent().find('.the_column[column="' + (remove_column_number - 1) + '"]').find(".column-building-blocks-area");
                            $(this).parent().find('.the_column[column="' + remove_column_number + '"]').each(function () {
                                $(this).find(".column-building-blocks-area").find(".block").each(function () {
                                    // custom
                                    if ($(this).attr("block_type") in create_columns_move_block_functions) {
                                        create_columns_move_block_functions[$(this).attr("block_type")](move_to_column, $(this));
                                    } // else
                                    else {
                                        move_to_column.append($(this).clone());
                                        $(this).remove();
                                    }
                                });
                            });

                            // remove
                            $(this).parent().find('.the_column[column="' + remove_column_number + '"]').remove();
                        }
                    }
                    
                    // add
                    if (input_value > number_of_columns) {
                        for (let column_number = new_number_of_columns; column_number <= input_value; column_number++) {
                            var add_html = '<div class="the_column" column="' + column_number + '" style="flex: 100;"><input type="number" name="column-width" value="100" min="0" max="100" class="column-width-number">%<div class="sortable-building-blocks column-building-blocks-area" building_blocks_area="' + $(this).parent().parent().parent().attr("block_id") + '-' + (column_number - 1) + '"></div></div>';

                            $(this).parent().find(".columns").append(function () {
                                return add_html;
                            });
                            page_builder_sortable();
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

    $("#all-building-blocks > .content > .create_block").draggable({
        helper: function () {
            var head_html = '<div class="block" block_status="new" block_id="' + block_id + '" block_type="' + $(this).attr("block_type") + '" id="block_id_' + block_id + '">';
            var footer_html = "</div>";

            var body_html = "";
            if ($(this).attr("block_type") in make_block_functions) {
                body_html = make_block_functions[$(this).attr("block_type")].current_block(block_id);
            }
            else {
                body_html = "<p>" + $(this).attr("block_type") + "</p>";
            }

            current_block_name  = $(this).attr("block_type");
            current_block       = head_html + body_html + footer_html;
            block_id++;
            return current_block;
        }
    });

    /* ============================== droppable ============================== */
        function td_droppable(id, event, ui) {
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
                    page_builder_sortable();

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
            else {
                var JQ_this = id;
                droppable_custom_functions[current_block_name]((block_id - 1), JQ_this, event, ui);
            }

            // reset variables
            current_block       = null;
            current_block_name  = null;
        }

        $(".sortable-building-blocks").droppable({
            drop: function (event, ui) {
                td_droppable($(this), event, ui);
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

            var del_block_from_building_area = $(this).parent().parent().parent();

            del_block_from_building_area.toggle("highlight", 400);
            setTimeout(function () {
                if (del_block_from_building_area.attr("block_type") === "create_columns") {
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