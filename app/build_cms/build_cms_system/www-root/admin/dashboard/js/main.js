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

    // ==================== Edit/Add ====================
    // select a new icon
    $("#add_icon_btn").click(function () {
        $("#add_icon_input").click();
    });

    // submit Edit/Add form
    $("#add_icon_input").change(function (e) {
        var file = $("#build_cms_base_url").attr("base_url") + "/admin_files/dashboard/user_icons/" + $("#user_id").val() + "_user_icon." + e.target.files[0].name.split(".").pop();

        $("#add_icon_form").submit();

        setTimeout(function () {
            $("#image_user_icon").attr( "src", file );
            $("#add_icon_input").val("");
        }, 200 );
        
    });

    // ==================== Delete ====================
    $("#delete_icon_btn").click(function () {
        if ( $("#image_user_icon").attr("src") !== $("#build_cms_base_url").attr("base_url") + "/admin_files/dashboard/default_user_icon.png" ) {
            var file = $("#build_cms_base_url").attr("base_url") + "/admin_files/dashboard/default_user_icon.png";
            $("#delete_icon_input").click();
            setTimeout(function () {
                $("#image_user_icon").attr( "src", file );
            }, 200 );
        }
        else {
            alert("You can not delete the default user icon");
        }
    });

/* ============================== /submit icon (Add/Edit/Delete) ============================== */