$("#add_custom_item").click(function () {
    var main    = $(this).parent().parent().children(".main");

    var name    = main.children('input[name="add_name_custom_url"]').val();
    var url     = main.children('input[name="add_url_custom_url"]').val();

    create_item("custom", name, url, function () {
        return '<h3>Name:</h3><input type="text" name="name" value="' + name + '"><h3>Url:</h3><input type="text" name="url" value="' + url + '">';
    });
});