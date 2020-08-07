$(document).ready(function () {
    $(".tab_links > .tab").click(function () {
        var toggle_id = $(this).attr("tab_toggle");

        // hide all
        $(".tab_container > .menu_container").each(function () {
            $(this).removeClass("active");
        });

        // toggle tab
        $(toggle_id).addClass("active");
    }); // <=== $(".tab_links > .tab").click()
}); // <=== $(document).ready()