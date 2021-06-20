$("#add_page_item").click(function () {
    var main = $(this).parent().parent().children(".main");

    main.children().each(function () {
        var input = $(this).children(".page_builder-add-page-checkbox");

        if (input[0].checked === true) {
            var name = input.attr("page-name");
            var url = input.attr("page-id");

            create_item("page", name, url, function () {
                return "";
            });
        }

        input[0].checked = false;
    });
});