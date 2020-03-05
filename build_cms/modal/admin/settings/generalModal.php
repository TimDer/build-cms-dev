<?php

class generalModal {
    // form data
    public static $sidetitle    = "";
    public static $sideslogan   = "";

    // user role
    public static $new_user_default_role_admin  = "";
    public static $new_user_default_role_author = "";
    public static $new_user_default_role_user   = "";

    // membership
    public static $membership = "";

    // template loader
    public static $templateLoader = array(
        array(
            "id" => 0,
            "displayName" => "Do not load a templateLoader"
        )
    );
    public static $templateLoaderSelectedID = 0;
}