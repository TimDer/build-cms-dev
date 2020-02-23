/* ============================== submit credentials form ============================== */
    $(document).ready(function () {
        $("#login_credentials_save_btn").click(function () {
            if ( $("input[name='password']").val() !== $("input[name='password_confirm']").val() ) {
                alert("The passwords do not match up");
                return;
            }
            $("#login_credentials_form").find("input[type='submit']").click();
        });
    });
/* ============================== /submit credentials form ============================== */


/* ============================== submit icon (Add/Edit/Delete) ============================== */

    // select a new icon
    $("#add_icon_btn").click(function () {
        $("#add_icon_input").click();
    });

    // submit Edit/Add form
    $("#add_icon_input").change(function (e) {
        var file = $("#build_cms_base_url").attr("base_url") + "/admin_files/dashboard/user_icons/" + $("#user_id").val() + "_" + e.target.files[0].name;

        $("#add_icon_form").submit();

        setTimeout(function () {
            $("#image_user_icon").attr( "src", file );
        }, 200 );
        
    });

    // submit Delete form
    $("#delete_icon_btn").click(function () {
        $("#delete_icon_input").click();
    });

/* ============================== /submit icon (Add/Edit/Delete) ============================== */