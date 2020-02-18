<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo config_url::VIEW("/admin/admin_basics/css/main.css"); ?>">
    <?php controller::get_head(); ?>
    <title>Build-CMS Admin</title>
</head>
<body>
    
<header>
    <div>
        <p>Build-CMS 1.0 beta 1</p>
    </div>
    <div>
        <ul id="dropdown_user_menu">
            <li>
                HI,<?php echo user_session::return_user_name("user_id"); ?>
                <ul class="main_user_menu" id="main_user_menu">
                    <li><a href="<?php echo config_url::BASE("/admin_submit/logout"); ?>">Logout</a></li>
                    <li><a href="<?php echo config_url::BASE("/admin/dashboard"); ?>">Profile</a></li>
                    <li><a href="<?php echo config_url::BASE(); ?>">Homepage</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<div class="admin_basics_content">

    <aside>
        <ul class="main-menu">
            <li class="parent main-menu-parent" id="main_menu_dashboard">
                <a href="<?php echo config_url::BASE("/admin/dashboard"); ?>">Dashboard</a>
            </li>
            <li class="parent main-menu-parent main-menu-click-event" id="main_menu_plugins">
                Plugins
                <ul class="parent-menu">
                    <li class="child">
                        <a href="<?php echo config_url::BASE("/admin/plugins/install"); ?>">Install a plugin</a>
                    </li>
                    <li class="child">
                        <a href="<?php echo config_url::BASE("/admin/plugins/create"); ?>">Create a new plugin</a>
                    </li>
                    <li class="child">
                        <a href="<?php echo config_url::BASE("/admin/plugins"); ?>">Plugins</a>
                    </li>
                </ul>
            </li>
            <li class="parent main-menu-parent main-menu-click-event" id="main_menu_settings">
                Settings
                <ul class="parent-menu">
                    <li class="child">
                        <a href="<?php echo config_url::BASE("/admin/settings/general"); ?>">General</a>
                    </li>
                    <li class="child">
                        <a href="<?php echo config_url::BASE("/admin/settings/users"); ?>">Users</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <main>
