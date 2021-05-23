$(document).ready(function () {
    $(".edit_menu_area").sortable({
        connectWith: ".edit_menu_area"
    });

    $(".menu_item > .header").click(function () {
        $(this).parent().children(".content").toggle( "blind", 300 );
    });

    $("#select_edit_menu").change(function () {
        window.location = $("#build_cms_base_url").attr("base_url") + "/admin/settings/menus?editMenuId=" + $(this).val();
    });

    $(".add_item_area .header").click(function () {
        $(this).parent().children(".main").toggle( "blind", 300 );
        $(this).parent().children(".footer").toggle( "blind", 300 );
    });
});