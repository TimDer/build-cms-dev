Dies ist der hallo welt pagina<br><br>

<h1><a href="<?php echo config_url::BASE("/admin"); ?>">Admin</a></h1>

<br><br><br><br>

<div>
    <?php
    if (class_exists("pluginClass_build_cms_menus_template")) {
        pluginClass_build_cms_menus_template::get_menu("Root");
    }
    ?>
</div>

<div>
    <?php
    if (class_exists("build_cms_page_builder_template_loader")) {
        build_cms_page_builder_template_loader::get_page("content");
    }
    ?>
</div>