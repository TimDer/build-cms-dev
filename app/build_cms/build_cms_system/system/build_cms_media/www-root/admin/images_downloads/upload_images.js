$(function () {

    $("#data_upload_submit").click(function (event) {
        event.preventDefault();

        if ( parseInt( $("#files_uploader")[0].files.length ) > parseInt( $(this).attr("max_files") )) {
            $("#error_modal #error_content").html("<p>You can only upload up to " + $(this).attr("max_files") + " file(s) according to your php.ini configuration</p>");
            $("#error_modal").modal();
        }
        else {
            $("#data_upload_form").submit();
        }
    });

});


$(document).ready(function () {
    if ( $("#error_modal").attr("open_modal") === "open" ) {
        $('#error_modal').modal();
    }
});