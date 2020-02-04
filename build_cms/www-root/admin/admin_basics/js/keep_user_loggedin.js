function keep_user_loggedin() {
    var time = 5 * 60 * 1000;

    setTimeout(function () {
        $.ajax({
            type: "POST",
            url: $("#build_cms_base_url").attr("base_url") + "/admin/keep-user-loggedin",
            cache: false,
            success: function () {
                keep_user_loggedin();
            },
            error: function () {
                alert("Connection was lost");
                keep_user_loggedin();
            }
        });
    }, time );
}
keep_user_loggedin();