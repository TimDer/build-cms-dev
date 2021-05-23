$(document).ready(function () {
    $("#saveTheMenuBtn").click(function () {
        var data_array = {
            "menu_name": $("#rename_menu_name").val(),
            "menu_id": $("#select_edit_menu").val(),
            "data": save_the_menu( $(".edit_menu_area") )
        };

        console.log(data_array);

        $.ajax({
            enctype: 'application/x-www-form-urlencoded',
            type: "POST",
            url: $("#build_cms_base_url").attr("base_url") + "/admin_submit/settings/menus",
            dataType: "json",
            data: data_array,
            success: function (massage) {
                display_saved_container('The menu has been saved');

                if (massage.menu_name !== false && massage.menu_name !== "") {
                    $("#select_edit_menu").children().each(function () {
                        if ($(this).attr("value") === massage.menu_id) {
                            $(this).text(massage.menu_name);
                        }
                    });
                }

                $("#rename_menu_name").val("");
            },
            error: function (massage) {
                display_saved_container("Something went wong", true);
            }
        });
    });
});