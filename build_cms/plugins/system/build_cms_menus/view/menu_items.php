<div class="menu_item"<?php
        ?> the_name="<?php echo build_cms_menus_subPluginModal::$the_name; ?>"<?php
        ?> the_url="<?php echo build_cms_menus_subPluginModal::$the_url; ?>"<?php
        ?> id="<?php echo build_cms_menus_subPluginModal::$the_id; ?>"<?php
        ?> parent_id="<?php echo build_cms_menus_subPluginModal::$parent_id; ?>"<?php
        ?> type="<?php echo build_cms_menus_subPluginModal::$type; ?>">

    <div class="header">
        <?php echo build_cms_menus_subPluginModal::$the_name; ?>
    </div>

    <div class="content">
        <button>Delete</button>
        <?php if (build_cms_menus_subPluginModal::$type === "custom"): ?>
            <h3>Name:</h3>
            <input type="text" name="">
            <h3>Url:</h3>
            <input type="text" name="">
        <?php endif; ?>
        <div class="menus_area_container">
            <?php
                build_cms_menus_menus_pluginSubController::get_menu_items(
                    build_cms_menus_subPluginModal::$the_array,
                    build_cms_menus_subPluginModal::$the_array_key
                );
            ?>
        </div>
    </div>
</div>