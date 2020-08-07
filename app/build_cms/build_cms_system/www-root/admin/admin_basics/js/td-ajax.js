/*

TD-AJAX Version 1.1

Other required files:
  1. jQuery (tested with version: v3.3.1)

*/

// configs
var successMessage  = "";
var errorMessage    = "";
var allowResponse   = true;
var BASE_URL        = $("#build_cms_base_url").attr("base_url");

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
            if (successMessage === "" && allowResponse === true) {
                alert(response);
            }
            else if (successMessage !== "" && allowResponse === true) {
                alert(successMessage + ": " + response);
            }
            else {
                alert(successMessage);
            }
        },
        error: function (response) {
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
    });
});