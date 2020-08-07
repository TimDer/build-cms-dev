/* ============================== open template modal ============================== */

    $(document).ready(function () {
        $(".toggle_modal").click(function () {
            var toggle = $(this).attr("toggle");
            $(".modals > div").css("display", "none");
            $(".modals").css("z-index", "9999");
            $(".modals > .background").css("display", "block");
            $("body").css("overflow", "hidden");
            $(toggle).css("display", "block");
        });
    });

/* ============================== /open template modal ============================== */

/* ============================== close template modal ============================== */

    $(document).ready(function () {
        $(".modals > div .close, .modals > .background").click(function () {
            $("body").css("overflow", "visible");
            $(".modals > div").css("display", "none");
            $(".modals").css("z-index", "-9999");
        });
    });

/* ============================== /close template modal ============================== */


/* ============================== submit ============================== */

    $(".fileSubmit").change(function () {
        //console.log($(this));
        //$(this).submit();
        var form = $(this).attr("submit_form");
        $(form).submit();
    });

/* ============================== /submit ============================== */


/* ============================== delete template ============================== */

    $(".delete_this_template").click(function (e) {
        e.preventDefault();
        if (warning_message("Please solve this sum to delete this template", "Are you sure you want to delete this template")) {
            alert("The answer is incorrect");
            return;
        }

        var link = $(this).attr("href");
        var modal_id = $(this).attr("modal_id");
        var preview_id = $(this).attr("preview_id");

        $.ajax({
            url: link,
            success: function (e) {
                if (e === "cannot") {
                    alert("You can't delete an active template");
                }
                else {
                    alert("Your template is now been deleted");
                    $(".modals > div .close").click();
                    $(modal_id).remove();
                    $(preview_id).remove();
                }
            }
        });
        //
    });

/* ============================== /delete template ============================== */


/* ============================== accordion ============================== */

    $(document).ready(function () {
        $(".accordion_toggle").on("click", function () {
            var accordion_toggle = $(this).attr("toggle");
            $(this).parent().parent().find(".content").each(function () {
                if ($(this).attr("toggle") !== accordion_toggle) {
                    $(this).hide( "blind", 100 );
                }
            });
            $( accordion_toggle ).toggle( "blind", 100 );
            //$( $(this).parent() ).accordion();
        });
    });

/* ============================== /accordion ============================== */