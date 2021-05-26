$(document).ready(function () {
    $("#saveTheMenuBtn").click(function () {
        var data_array = {
            "menu_name": $("#rename_menu_name").val(),
            "menu_id": $("#select_edit_menu").val(),
            "data": save_the_menu( $(".edit_menu_area") ),
            "remove": save_the_menu( $(".delete_menu_area") )
        };

        $.ajax({
            enctype: 'application/x-www-form-urlencoded',
            type: "POST",
            url: $("#build_cms_base_url").attr("base_url") + "/admin_submit/settings/menus",
            dataType: "json",
            data: data_array,
            success: function (message) {
                display_saved_container('The menu has been saved');

                if (message.menu_name !== false && message.menu_name !== "") {
                    $("#select_edit_menu").children().each(function () {
                        if ($(this).attr("value") === message.menu_id) {
                            $(this).text(message.menu_name);
                        }
                    });
                }

                $(".edit_menu_area").each(function () {
                    var parent_id = $(this).attr("parent_id");
                    var order = 1;

                    $(this).children(".menu_item").each(function () {
                        if ( $(this).attr("item_id") === "new" ) {
                            $(this).attr("item_id", message.data[parent_id][order].id);
                        }
                        order++;
                    });
                });

                $("#rename_menu_name").val("");
                $("#delete_menu_area").text("");
            },
            error: function (message) {
                display_saved_container("Something went wong", true);
            }
        });
    });
});