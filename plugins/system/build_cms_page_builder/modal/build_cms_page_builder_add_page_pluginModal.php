<?php

class build_cms_page_builder_add_page_pluginModal {
    // page id
    public static $page_id = "new";
    // highest block id
    public static $highest_block_id = 1;
    // template
    public static $index_the_template   = array();
    public static $default_template     = " selected";
    public static $old_category         = "";

    /* ==================== General ==================== */
    // edit: page name
    public static $edit_page_name       = "Add page";
    // page name
    public static $page_name_imput      = "";
    // url name
    public static $page_url_imput       = "";
    // status (published / not published)
    public static $status_not_published = "";
    public static $status_published     = "";
    // if (page home)
    public static $page_home            = "";
    // time stamp
    public static $time_stamp           = "";
    /* ==================== /General ==================== */

    /* ==================== SEO ==================== */
    public static $seo_pagetitle    = "";
    public static $seo_author       = "";
    public static $seo_keywords     = "";
    public static $seo_description  = "";
    /* ==================== /SEO ==================== */
}