// ============================== Save menu functions ==============================

function save_the_menu(this_menu) {
    var return_array = {};

    var num = 0;
    this_menu.each(function () {
        var data;
        if ($(this).attr("type") in save_menu_to_array_functions) {
            data = save_menu_to_array_functions[$(this).attr("type")].save_function(
                $(this).children(".content").children(".item_content"),
                $(this).attr("item_id"),
                $(this).attr("the_url"),
                $(this).parent().attr("parent_id"),
                $(this).attr("the_name"),
            );
        }
        else {
            data = null;
        }

        return_array[num] = {
            id: $(this).attr("item_id"),
            type: $(this).attr("type"),
            parent_id: $(this).parent().attr("parent_id"),
            data: data
        };
        num++;
    });

    return return_array;
}

var save_menu_to_array_functions = {}
function save_menu_to_array(name, save_function) {
    if (!( name in save_menu_to_array_functions )) {
        save_menu_to_array_functions[name] = {};
        save_menu_to_array_functions[name].name = name;
        save_menu_to_array_functions[name].save_function = save_function;
    }
}

function display_saved_container(message = "", error = false) {
    $("#saved-container-message").text(message);

    $("#saved-container-message").addClass("saved_saved_container");

    if (error) {
        $("#saved-container-message").addClass("error_saved_container");
    }
    setTimeout(function () {
        $("#saved-container-message").removeClass("saved_saved_container");

        if (error) {
            $("#saved-container-message").removeClass("error_saved_container");
        }
    }, 5000);
}

save_menu_to_array("custom", function (thisItem) {
    return {
        "name": thisItem.children('input[name="name"]').val(),
        "url": thisItem.children('input[name="url"]').val()
    };
});

// ============================== /Save menu functions ==============================