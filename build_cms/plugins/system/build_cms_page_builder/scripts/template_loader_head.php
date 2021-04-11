<?php

templateLoader::set_default_head(function ($array) {
    $default = (isset($array["page_builder"]["default"]) && is_bool($array["page_builder"]["default"])) ? $array["page_builder"]["default"] : true;
    $id_loop = (isset($array["page_builder"]["id_loop"]) && is_array($array["page_builder"]["id_loop"])) ? $array["page_builder"]["id_loop"] : array();

    $return = "";

    if ($default === true) {
        if (user_url::uri_string() !== "/" && user_url::uri_string() !== "") {
            $page_css = "?page=" . user_url::uri_string();
        }
        else {
            $page_css = "";
        }
        $return .= '<link rel="stylesheet" href="' . config_url::BASE("/files/page_builder/load_blocks.css" . $page_css) . '">';
    }

    foreach ($id_loop AS $page_id) {
        if (is_numeric($page_id)) {
            $return .= '<link rel="stylesheet" href="' . config_url::BASE("/files/page_builder/load_blocks.css?page_id=" . $page_id) . '">';
        }
    }

    $return .= build_cms_page_builder_template_loader::get_seo();

    return $return;
});