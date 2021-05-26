// ============================== Save menu functions ==============================

function save_the_menu(this_menu) {
    var return_array = {};

    var num = 0;
    this_menu.each(function () {
        var order = 1;
        $(this).children(".menu_item").each(function () {
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
                name: $(this).attr("the_name"),
                url: $(this).attr("the_url"),
                type: $(this).attr("type"),
                parent_id: $(this).parent().attr("parent_id"),
                the_order: order,
                data: data
            };
            num++;
            order++;
        });
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
    thisItem.parent().parent().children(".header").text(
        thisItem.children('input[name="name"]').val()
    );
    return {
        "name": thisItem.children('input[name="name"]').val(),
        "url": thisItem.children('input[name="url"]').val()
    };
});

// ============================== /Save menu functions ==============================

// ============================== Other functions ==============================

// Add an item to the menu
function create_item(name, item_name, item_url, item_function) {
    var html_opening    = '<div class="menu_item ui-sortable-handle" the_name="' + item_name + '" the_url="' + item_url + '" item_id="new" type="' + name + '"><div class="header">' + item_name + '</div><div class="content" style="display: none;"><button class="delete_the_item_from_the_menu">Delete</button><div class="item_content">';
    var html_middle     = item_function();
    var html_closing    = '</div><div class="edit_menu_area menus_area_container ui-sortable" parent_id="2"></div></div></div>';

    var html = html_opening + html_middle + html_closing;

    $('.edit_menu_area[parent_id="0"]').append(html);

    run_editor();
}

// run the menu editor
function run_editor() {
    $(".edit_menu_area").sortable({
        connectWith: ".edit_menu_area"
    });

    $(".edit_menu_area > .menu_item").each(function () {
        if ( $(this).attr("has_click_event") === undefined ) {
            $(this).children(".header").click(function () {
                $(this).parent().children(".content").toggle( "blind", 300 );
            });
            $(this).attr("has_click_event", "true");
        }
    });

    $("#select_edit_menu").change(function () {
        window.location = $("#build_cms_base_url").attr("base_url") + "/admin/settings/menus?editMenuId=" + $(this).val();
    });

    $(".add_item_area .header").click(function () {
        $(this).parent().children(".main").toggle( "blind", 300 );
        $(this).parent().children(".footer").toggle( "blind", 300 );
    });

    $(".delete_the_item_from_the_menu").click(function () {
        var item = $(this).parent().parent();

        if (item.attr("item_id") !== "new") {
            $("#delete_menu_area").append(item[0].outerHTML);
        }

        item.remove();
    });
}

// ============================== /Other functions ==============================