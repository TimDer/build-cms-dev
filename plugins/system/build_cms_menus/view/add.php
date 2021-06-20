<form action="/admin_submit/settings/add-menu" method="post" class="td-ajax" td-ajax-on-success="add-menu" td-ajax-on-error="add-menu">
    <h1>Add a menu:</h1>
    <input type="text" name="menu_name" id="add_menu_name" placeholder="Menu name...">
    <input type="submit" value="Add the menu">
</form>

<hr>

<form action="<?php echo config_url::BASE("/admin_submit/settings/delete-menu"); ?>" method="post" id="delete-menu-form">
    <h1>Delete a menu:</h1>
    <select name="menu_id" id="select_delete_menu">
        <option value="0" disabled selected>Select a menu</option>
        <?php foreach (build_cms_menus_pluginModal::$menus_names_array AS $name): ?>
            <option value="<?php echo $name["id"]; ?>">
                <?php echo $name["menu_name"]; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Delete the selected menu" id="delete-menu-btn">
</form>