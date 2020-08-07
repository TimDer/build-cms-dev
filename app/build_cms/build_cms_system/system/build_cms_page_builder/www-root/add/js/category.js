$(document).ready(function () {
    $("#page-category").find('input[name="page_category"]').click(function () {
        var this_category_radio_button = $(this);

        $('#page-category').find('input[name="page_category"]').each(function () {
            $(this).removeAttr('checked');
        });

        this_category_radio_button.attr('checked', "checked");
    });
}); // <-- $(document).ready()