$(window).ready(function () {
    setTimeout(function () {
        $(".root_container > .loader_root_container").css("display", "none");
        $(".root_container > .content_root_container").css("visibility", "visible");
    }, 2000);
});