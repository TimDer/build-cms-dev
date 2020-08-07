$(document).ready(function () {
    $("#dropdown_user_menu").hover(
        function () {
            // hover in
            $("#main_user_menu").addClass("user_dropdown_menu_active");
            $("#dropdown_user_menu").addClass("main_user_menu_active");
        }, function () {
            // hover out
            $("#main_user_menu").removeClass("user_dropdown_menu_active");
            $("#dropdown_user_menu").removeClass("main_user_menu_active");
        }
    );
});