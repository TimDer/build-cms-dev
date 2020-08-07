function resize_height(width, that) {
    if (that.attr("style") !== undefined) {
        that.removeAttr("style");
    }
    that.css("height", width);
}

$(function () {
    $(".main_container .images_container .image_container").each(function () {
        resize_height($(this).width(), $(this));
    });
});

$(window).resize(function () {
    $(".main_container .images_container .image_container").each(function () {
        resize_height($(this).width(), $(this));
    });
});