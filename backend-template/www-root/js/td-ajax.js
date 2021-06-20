/*

TD-AJAX Version 1.2

Other required files:
  1. jQuery (tested with version: v3.3.1)

*/

// configs
var successMessage  = "";
var errorMessage    = "";
var allowResponse   = true;
var BASE_URL        = $("#build_cms_base_url").attr("base_url");

// on success function
on_success_functions = {};
function set_on_success_function(name, on_success_function, display_response = true) {
    if (!(name in on_success_functions)) {
        on_success_functions[name] = {
            function: on_success_function,
            display_response: display_response
        }
    }
};

// on error function
on_error_functions = {};
function set_on_error_function(name, on_error_function, display_response = true) {
    if (!(name in on_error_functions)) {
        on_error_functions[name] = {
            function: on_error_function,
            display_response: display_response
        }
    }
};

// toggle checked on checkboxes
$("form.td-ajax, body").find("[type='checkbox']").each(function () {
    var this_checkbox = $(this);
    $(this_checkbox).click(function() {
        if (this_checkbox.attr("checked")) {
            this_checkbox.removeAttr("checked");
        }
        else {
            this_checkbox.attr("checked", "checked");
        }
    });
});

// submit
$("form.td-ajax").on("submit", function (e) {
    e.preventDefault();
    // form tag
    var formTag = $(this);
    var action  = formTag.attr("action");
    var method  = formTag.attr("method");
    var data    = new FormData(formTag[0]);
    
    // get the data from the input fields
    formTag.find("[name]").each(function () {
        function form_data(formDataTag) {
            var formDataTagName     = formDataTag.attr("name");
            var formDataTagValue    = formDataTag.val();
            
            data.append(formDataTagName, formDataTagValue);
        }

        if ($(this).attr("type") === "checkbox" && $(this).attr("checked")) {
            form_data($(this));
        }
        else if ($(this).attr("type") !== "checkbox") {
            form_data($(this));
        }
    });

    // enctype 
    if (formTag.attr("enctype")) {
        var enctype = formTag.attr("enctype");
    }
    else {
        var enctype = 'application/x-www-form-urlencoded';
    }

    // submit the data
    $.ajax({
        enctype: enctype,
        url: BASE_URL + action,
        processData: false,
        contentType: false,
        type: method,
        data: data,
        success: function (response) {
            if (
                (
                    formTag.attr("td-ajax-on-success") !== undefined &&
                    formTag.attr("td-ajax-on-success") in on_success_functions &&
                    on_success_functions[formTag.attr("td-ajax-on-success")].display_response === true
                ) ||
                (
                    formTag.attr("td-ajax-on-success") === undefined ||
                    on_success_functions[formTag.attr("td-ajax-on-success")] === undefined
                )
            ) {
                if (successMessage === "" && allowResponse === true) {
                    alert(response);
                }
                else if (successMessage !== "" && allowResponse === true) {
                    alert(successMessage + ": " + response);
                }
                else {
                    alert(successMessage);
                }
            }
            
            if ( formTag.attr("td-ajax-on-success") !== undefined && formTag.attr("td-ajax-on-success") in on_success_functions ) {
                on_success_functions[formTag.attr("td-ajax-on-success")].function(response);
            }
        },
        error: function (response) {
            if (
                (
                    formTag.attr("td-ajax-on-error") !== undefined &&
                    formTag.attr("td-ajax-on-error") in on_error_functions &&
                    on_error_function[formTag.attr("td-ajax-on-error")].display_response === true
                ) ||
                (
                    formTag.attr("td-ajax-on-error") === undefined ||
                    on_error_function[formTag.attr("td-ajax-on-error")] === undefined
                )
            ) {
                if (errorMessage === "" && allowResponse === true) {
                    alert(response);
                }
                else if (errorMessage !== "" && allowResponse === true) {
                    alert(errorMessage + ": " + response);
                }
                else {
                    alert(errorMessage);
                }
            }

            if ( formTag.attr("td-ajax-on-error") !== undefined && formTag.attr("td-ajax-on-error") in on_error_functions ) {
                on_error_functions[formTag.attr("td-ajax-on-error")].function(response);
            }
        }
    });
});