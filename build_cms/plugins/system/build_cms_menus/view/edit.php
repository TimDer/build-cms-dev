<div class="edit_saved_container">
    Saved
</div>

<div class="edit_grid">
    <div class="edit_sidebar">
        <!-- ============================== add page area ============================== -->
        <div class="add_page_area">
            <div class="header">
                Add page
            </div>
            <div class="main">
                content
            </div>
            <div class="footer">
                <input type="submit" name="add_pages" value="Add pages">
            </div>
        </div>
        <div class="add_page_area">
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
                <input type="submit" name="add_url" value="Add url">
            </div>
        </div>
        <!-- ============================== /add page area ============================== -->
    </div>
    <div class="main_edit_container">
        <!-- ============================== select a menu ============================== -->
        <select name="menu_name">
            <option value="0" disabled<?php echo (isset(user_url::$get_var["editMenuId"])) ? "" : " selected"; ?>>Select a menu</option>
            <?php foreach (build_cms_menus_pluginModal::$menus_names_array AS $name): ?>
                <option value="<?php echo $name["id"]; ?>"<?php echo (isset(user_url::$get_var["editMenuId"]) AND user_url::$get_var["editMenuId"] === $name["id"]) ? " selected" : ""; ?>>
                    <?php echo $name["menu_name"]; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- ============================== /select a menu ============================== -->

        <!-- ============================== Menu name ============================== -->
        <input type="text" name="rename_menu_name">
        <!-- ============================== /Menu name ============================== -->

        <!-- ============================== edit menu area ============================== -->
        <div class="edit_menu_area">
            <?php build_cms_menus_menus_pluginSubController::get_menu_items(build_cms_menus_pluginModal::$menus_data_array, 0); ?>
        </div>
        <!-- ============================== /edit menu area ============================== -->
    </div>
</div>