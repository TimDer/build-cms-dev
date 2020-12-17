$(document).ready(function () {
    $(".delete_page").click(function (e) {
        e.preventDefault();

        var this_delete_page = $(this);

        if (warning_message("solve this to delete your page", "Are you sure you want to delete this page?")) {
            return;
        }

        var delete_url = this_delete_page.attr("href");

        $.ajax({
            enctype: 'application/x-www-form-urlencoded',
            type: "POST",
            url: delete_url,
            success: function () {
                this_delete_page.parent().parent().remove();
            },
            error: function () {
                alert("Something went wrong");
            }
        });
    })
});