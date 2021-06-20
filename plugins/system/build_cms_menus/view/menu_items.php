<div class="menu_item"<?php
        ?> the_name="<?php echo build_cms_menus_subPluginModal::$the_name; ?>"<?php
        ?> the_url="<?php echo build_cms_menus_subPluginModal::$the_url; ?>"<?php
        ?> item_id="<?php echo build_cms_menus_subPluginModal::$the_id; ?>"<?php
        ?> type="<?php echo build_cms_menus_subPluginModal::$type; ?>">

    <div class="header">
        <?php
        if (isset( pluginClass_build_cms_menus_customItems::$custom_item[build_cms_menus_subPluginModal::$type]["function_name"] )) {
            echo pluginClass_build_cms_menus_customItems::$custom_item[build_cms_menus_subPluginModal::$type]["function_name"]->__invoke(
                build_cms_menus_subPluginModal::$the_id,
                build_cms_menus_subPluginModal::$the_name,
                build_cms_menus_subPluginModal::$the_url,
                build_cms_menus_subPluginModal::$type,
                build_cms_menus_subPluginModal::$parent_id
            );
        }
        else {
            echo build_cms_menus_subPluginModal::$the_name;
        }
        ?>
    </div>

    <div class="content" style="display: none;">
        <button class="delete_the_item_from_the_menu">Delete</button>
        <?php
        if (isset(pluginClass_build_cms_menus_customItems::$custom_item[ build_cms_menus_subPluginModal::$type ]["function"])) {
            ?>
            <div class="item_content">
                <?php pluginClass_build_cms_menus_customItems::$custom_item[build_cms_menus_subPluginModal::$type]["function"]->__invoke(
                    build_cms_menus_subPluginModal::$the_id,
                    build_cms_menus_subPluginModal::$the_name,
                    build_cms_menus_subPluginModal::$the_url,
                    build_cms_menus_subPluginModal::$type,
                    build_cms_menus_subPluginModal::$parent_id
                ); ?>
            </div>
            <?php
        }
        ?>
        <div class="edit_menu_area menus_area_container" parent_id="<?php echo build_cms_menus_subPluginModal::$the_id ?>">
            <?php
                build_cms_menus_menus_pluginSubController::get_menu_items(
                    build_cms_menus_subPluginModal::$the_array,
                    build_cms_menus_subPluginModal::$the_array_key
                );
            ?>
        </div>
    </div>
</div>