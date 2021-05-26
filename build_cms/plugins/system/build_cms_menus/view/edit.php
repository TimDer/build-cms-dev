<input type="submit" value="Save the menu" class="save_btn" id="saveTheMenuBtn">

<div class="edit_saved_container" id="saved-container-message">
    Saved
</div>

<div class="edit_grid">
    <div class="edit_sidebar">
        <?php if (isset($_GET["editMenuId"])) { ?>
            <!-- ============================== add page area ============================== -->
            <div class="add_item_area">
                <div class="header">
                    Custom URL
                </div>
                <div class="main">
                    <p>Name:</p>
                    <input type="text" name="add_name_custom_url">
                    <p>Url:</p>
                    <input type="text" name="add_url_custom_url">
                </div>
                <div class="footer">
                    <input type="submit" name="add_url" id="add_custom_item" value="Add url">
                </div>
            </div>

            <div class="custom-area">
                <?php
                if (is_array(pluginClass_build_cms_menus_customAreas::$custom_area) && !empty(pluginClass_build_cms_menus_customAreas::$custom_area)) {
                    foreach (pluginClass_build_cms_menus_customAreas::$custom_area AS $value) {
                        ?>
                        <div class="area-<?php echo $value["name"]; ?>">
                            <?php $value["area"]->__invoke(); ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <!-- ============================== /add page area ============================== -->
        <?php } else { ?>
            <h1>Select a menu</h1>
        <?php } ?>
    </div>
    <div class="main_edit_container">
        <!-- ============================== select a menu ============================== -->
        <select name="menu_name" id="select_edit_menu">
            <option value="0" disabled<?php echo (isset(user_url::$get_var["editMenuId"])) ? "" : " selected"; ?>>Select a menu</option>
            <?php foreach (build_cms_menus_pluginModal::$menus_names_array AS $name): ?>
                <option value="<?php echo $name["id"]; ?>"<?php echo (isset(user_url::$get_var["editMenuId"]) AND user_url::$get_var["editMenuId"] === $name["id"]) ? " selected" : ""; ?>>
                    <?php echo $name["menu_name"]; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- ============================== /select a menu ============================== -->

        <?php if (isset($_GET["editMenuId"])) { ?>
            <!-- ============================== Menu name ============================== -->
            <input type="text" name="rename_menu_name" id="rename_menu_name">
            <!-- ============================== /Menu name ============================== -->

            <!-- ============================== edit menu area ============================== -->
            <div class="edit_menu_area" parent_id="0">
                <?php build_cms_menus_menus_pluginSubController::get_menu_items(build_cms_menus_pluginModal::$menus_data_array, 0); ?>
            </div>
            <!-- ============================== /edit menu area ============================== -->

            <!-- ============================== delete menu area ============================== -->
            <div class="delete_menu_area" id="delete_menu_area"></div>
            <!-- ============================== /delete menu area ============================== -->
        <?php } ?>
    </div>
</div>