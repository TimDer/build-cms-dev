system_area_save_function("basics", function () {
    var data = {};

    // General
    data.general_pagename    = $('input[name="pagename"]').val();
    data.general_url         = $('input[name="url"]').val();
    data.general_status      = $('select[name="status"]').val();
    data.general_homepage    = $('input[name="homepage"]').attr("checked");
    data.general_page_id     = $('input[name="page_id"]').attr("value");
    data.general_time_stamp  = $('input[name="time_stamp"]').attr("value");

    // SEO
    data.seo_pagetitle       = $('input[name="pagetitle"]').val();
    data.seo_author          = $('input[name="author"]').val();
    data.seo_keywords        = $('input[name="keywords"]').val();
    data.seo_description     = $('input[name="description"]').val();

    // category
    data.page_category = $("#page-category").find('input[checked="checked"]').val();

    return data;
});