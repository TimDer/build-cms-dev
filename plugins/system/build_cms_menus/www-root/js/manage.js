$(document).ready(function () {

    // function
    var func = function (response) {
        response = JSON.parse(response);

        alert(response.alert);

        if (response.id !== false) {
            $("#select_delete_menu").append('<option value="' + response.id + '">' + response.name + '</option>');
            $("#select_edit_menu").append('<option value="' + response.id + '">' + response.name + '</option>');

            $("#add_menu_name").val("");
        }
    };

    // add
    set_on_success_function("add-menu", func, false);

    // delete
    set_on_error_function("add-menu", func, false);

    $("#delete-menu-btn").on("click", function (e) {
        e.preventDefault();
        
        if ( $("#select_delete_menu").val() === null ) {
            alert("Select a menu to delete");
            return;
        }

        $("#delete-menu-form").submit();
    });

});