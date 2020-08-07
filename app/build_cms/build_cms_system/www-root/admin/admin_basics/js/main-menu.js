// click event
$(document).ready(function () {
    $(document).on("click", ".main-menu-click-event", function () {
        var this_click_menu = $(this);

        // close all
        $('.main-menu-parent').each(function () {
            $(this).children().removeAttr("style");
            $(this).removeAttr("style");
        });

        // open this menu
        if (this_click_menu.children().length > 0) {
            this_click_menu.children().css("display", "block");
            this_click_menu.height(this_click_menu.height() + 5);
        }
    });
});