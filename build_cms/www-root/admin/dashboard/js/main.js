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