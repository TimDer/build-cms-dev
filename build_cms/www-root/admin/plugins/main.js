$('#no_space_allowed').on('keypress', function(e) {
    if ( e.which == 32 ){
        alert('Spaces are not allowed in this field');
        return false;
    }
    else if ( String.fromCharCode(e.keyCode) === "/" || String.fromCharCode(e.keyCode) === "\\" ) {
        alert('Slashes are not allowed in this field');
        return false;
    }
});

$(".delete_btn").click(function () {
    var delete_btn = $(this);
    var id = delete_btn.attr("delete_id");

    if (warning_message("Solve this sum in order to delete this plugin", "Are you sure you want to delete this plugin")) {
        return;
    }

    var base_url = $("#build_cms_base_url").attr("base_url");
    $.ajax({
        url: base_url + "/admin_submit/plugins/delete/" + id,
        success: function () {
            delete_btn.parent().parent().remove();
            setTimeout(function () {
                alert("The plugin has been successfully deleted");
            }, 50);
        }
    });
});