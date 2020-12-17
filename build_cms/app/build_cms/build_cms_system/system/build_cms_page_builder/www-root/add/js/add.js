/* ============================== custom area functions ============================== */

    var custom_area_functions = {};

    function custom_area_save_function(area_name, save_function) {
        if (!(area_name in custom_area_functions)) {
            custom_area_functions[area_name] = {};
            custom_area_functions[area_name].area_name = area_name;
            custom_area_functions[area_name].save_function = save_function;
        }
    }

/* ============================== /custom area functions ============================== */

/* ============================== system area functions ============================== */

    var system_area_functions = {};

    function system_area_save_function(area_name, save_function) {
        if (!(area_name in custom_area_functions)) {
            system_area_functions[area_name] = {};
            system_area_functions[area_name].area_name = area_name;
            system_area_functions[area_name].save_function = save_function;
        }
    }

/* ============================== /system area functions ============================== */

/* ============================== ajax functions ============================== */

    function ajax_success(this_massage) {
        close_load_page(function () {
            // set time_stamp
            if ($('input[name="time_stamp"]').attr("value") === "") {
                $('input[name="time_stamp"]').attr("value", this_massage.time_stamp);
            }

            // delete del blocks
            $("#del_area_blocks > .block").each(function () {
                $(this).remove();
            });

            // set block status to saved
            $(".sortable-building-blocks").find(".block").each(function () {
                $(this).attr("block_status", "saved");
            });

            // set page title
            $("#build_cms-page_title").text( "Edit: " + $('input[name="pagename"]').val() );

            // get page id
            $('input[name="page_id"]').attr("value", this_massage.page_id)

            // added massage
            $("html, body").animate({ scrollTop: 0 }, 0);
            $("#save_massage_success").css("display", "block");
            $("#save_massage_success").html( this_massage.status );

            setTimeout(function () {
                $("#save_massage_success").removeAttr("style");
            }, (3 * 1000));
        });
    }

    function ajax_error(fail_massage = "fail") {
        close_load_page(function () {
            $("html, body").animate({ scrollTop: 0 }, 0);
            $("#save_massage_success").css("display", "block");
            $("#save_massage_success").css("background-color", "red");
            $("#save_massage_success").html( fail_massage );

            setTimeout(function () {
                $("#save_massage_success").removeAttr("style");
            }, (3 * 1000));
        });
    }

/* ============================== ajax functions ============================== */


$(document).ready(function () {

    $("#add_btn").click(function () {
        /* ============================== loading page ============================== */

            open_load_page("saving page...");

        /* ============================== /loading page ============================== */

        /* ============================== check if inputs are empty ============================== */

            if ($('input[name="pagename"]').val() === "") {
                ajax_error('Please fill out "Pagename"');
                return;
            }

            if ($('input[name="url"]').val() === "") {
                ajax_error('Please fill out "URL name"');
                return;
            }

        /* ============================== /check if inputs are empty ============================== */

        /* ============================== custom area loop ============================== */

            var custom_area_data = {}
            $.each(custom_area_functions, function (key, value) {
                custom_area_data[value.area_name] = {};
                custom_area_data[value.area_name].area_name = value.area_name;
                custom_area_data[value.area_name].data = value.save_function();
            });

        /* ============================== /custom area loop ============================== */

        /* ============================== system area loop ============================== */

            var system_area_data = {}
            $.each(system_area_functions, function (key, value) {
                system_area_data[value.area_name] = {};
                system_area_data[value.area_name].area_name = value.area_name;
                system_area_data[value.area_name].data = value.save_function();
            });

        /* ============================== /system area loop ============================== */
        
        /* ============================== data object ============================== */
            var data_array = {};

            // custom area to ajax object
            data_array.system_area              = system_area_data;
            data_array.custom_area              = custom_area_data;
        /* ============================== /data object ============================== */

        /* ============================== ajax ============================== */
            
            $.ajax({
                enctype: 'application/x-www-form-urlencoded',
                type: "POST",
                url: $("#build_cms_base_url").attr("base_url") + "/admin_submit/page",
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