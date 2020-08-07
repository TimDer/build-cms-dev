/* ============================== delete link ============================== */

    $(document).ready(function () {
        $(".delete_link").click(function (e) {
            e.preventDefault();
            var that = $(this);

            if (warning_message("Solve this sum in order to delete this user", "Are you sure you want to delete this user")) {
                return;
            }

            $.ajax({
                url: that.attr("href"),
                success: function (response) {
                    that.parent().parent().remove();
                    setTimeout(function () {
                        alert("The user has been successfully deleted");
                    }, 50);
                }
            });
        });
    });

/* ============================== delete link ============================== */