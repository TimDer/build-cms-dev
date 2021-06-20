/*$(document).ready(function () {
    $('#data_modal').modal();
});*/

$(function () {
    var delete_image    = "";
    var delete_download = "";

    // delete image
    $("#delete_image_btn").click(function () {
        $('#data_modal').modal('hide');
        delete_image = $("#load_image").attr("image_id");
    });

    // delete download
    $("#delete_download_btn").click(function () {
        $('#data_modal').modal('hide');
        delete_download = $("#delete_download_btn").attr("delete_id");
    });

    // open image modal
    $(".image_btn").click(function () {
        var file_name   = $(this).attr("img_filename");
        var image_id    = $(this).attr("image_id");

        $("#data_modal_content #load_image").attr("src", $("#build_cms_base_url").attr("base_url") + "/images/" + file_name);
        $("#data_modal_content #load_image").attr("image_id", image_id);
        $("#data_modal_title").text(file_name);

        $('#data_modal').modal();
    });

    // open download modal
    $(".download_open_btn").click(function () {
        var file_name   = $(this).attr("download_filename");
        var download_id = $(this).attr("download_id");

        $("#data_modal_content").html("<p>Are you sure you want to delete: " + file_name + "</p>");
        $("#delete_download_btn").attr("delete_id", download_id);
        $("#data_modal_title").text(file_name);

        $('#data_modal').modal();
    });

    // Close modal
    $('#data_modal').on('hidden.bs.modal', function (e) {
        $("#load_image").attr("src", "");
        if (delete_image !== "") {
            window.location = $("#build_cms_base_url").attr("base_url") + "/admin/media/images/delete/" + delete_image;
        }
        else if (delete_download !== "") {
            window.location = $("#build_cms_base_url").attr("base_url") + "/admin/media/downloads/delete/" + delete_download;
        }
    });
});