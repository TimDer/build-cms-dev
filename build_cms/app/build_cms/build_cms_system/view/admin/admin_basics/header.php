<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo config_url::VIEW("/admin/admin_basics/css/jquery-ui.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo config_url::VIEW("/admin/admin_basics/css/main.css"); ?>">
    <?php controller::get_head(); ?>
    <title>Build-CMS Admin</title>
</head>
<body>
    
<header>
    <div>
        <p>Build-CMS <?php echo admin_basicsModal::$version; ?></p>
    </div>
    <div>
        <ul id="dropdown_user_menu">
            <li>
                HI,<?php echo user_session::return_user_name("user_id"); ?>
                <ul class="main_user_menu" id="main_user_menu">
                    <li><a href="<?php echo config_url::BASE("/admin_submit/logout"); ?>">Logout</a></li>
                    <li><a href="<?php echo config_url::BASE("/admin/dashboard"); ?>">Profile</a></li>
                    <li><a href="<?php echo config_url::BASE("/admin/iframes/root"); ?>">Homepage</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<div class="admin_basics_content">

    <aside>
        <ul class="main-menu">
            <?php foreach (plugins::$main_menu_items AS $value) { ?>
                <?php if ($value["url"] !== "" || isset($value["sub_menu_items"])) { ?>
                    <li class="parent main-menu-parent<?php echo $value["class_event"]; ?>" id="<?php echo $value["id"]; ?>">
                        <?php if ($value["url"] === "") { ?>
                            <?php echo $value["name"]; ?>
                            <?php if ( isset( $value["sub_menu_items"] ) ) { ?>
                                <ul class="parent-menu">
                                    <?php foreach ($value["sub_menu_items"] AS $sub_value) { ?>
                                        <li class="child">
                                            <a href="<?php echo config_url::BASE($sub_value["url"]); ?>"><?php echo $sub_value["name"]; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="<?php echo config_url::BASE($value["url"]); ?>"><?php echo $value["name"]; ?></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </aside>

    <main>
