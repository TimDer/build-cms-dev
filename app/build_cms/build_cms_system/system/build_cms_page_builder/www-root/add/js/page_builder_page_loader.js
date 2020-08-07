$("#page_builder_loading_progressbar").progressbar({
    value: false
});

function open_load_page(loading_page_text) {
    $("#loading_page_text").text(loading_page_text);

    $(".page_builder_page_loader").css("display", "block");
    $(".page_builder_the_page").css("display", "none");
}

function close_load_page(load_function) {
    var num = randomNumber(1, 5) * 1000;
    setTimeout(function () {
        $(".page_builder_page_loader").css("display", "none");
        $(".page_builder_the_page").css("display", "block");
        if ({}.toString.call(load_function) === '[object Function]') {
            load_function();
        }
    }, num);
}

$(window).ready(function () {
    close_load_page();
});