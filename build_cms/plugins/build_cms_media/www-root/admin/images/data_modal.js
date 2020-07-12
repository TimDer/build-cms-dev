/*$(document).ready(function () {
    $('#data_modal').modal();
});*/

$(function () {
    var delete_image = "";

    $("#delete_image_btn").click(function () {
        $('#data_modal').modal('hide');
        delete_image = $("#load_image").attr("image_id");
    });

    $(".image_btn").click(function () {
        var file_name   = $(this).attr("img_filename");
        var image_id    = $(this).attr("image_id");

        $("#load_image").attr("src", $("#build_cms_base_url").attr("base_url") + "/images/" + file_name);
        $("#load_image").attr("image_id", image_id);
        $("#data_modal_title").text(file_name);

        $('#data_modal').modal();
    });

    $('#data_modal').on('hidden.bs.modal', function (e) {
        $("#load_image").attr("src", "");
        if (delete_image !== "") {
            window.location = $("#build_cms_base_url").attr("base_url") + "/admin/media/images/delete/" + delete_image;
        }
    });
});