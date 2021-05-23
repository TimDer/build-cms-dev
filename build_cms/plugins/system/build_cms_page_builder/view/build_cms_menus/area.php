<div class="add_item_area">
    <div class="header">
        Add page
    </div>
    <div class="main">
        <?php
        foreach (build_cms_page_builder_menus_pluginSubModal::$pages_array AS $page) {
            ?>
            <div class="page_builder-checkbox-area">
                <input type="checkbox" name="page-<?php echo $page["id"]; ?>" page-id="<?php echo $page["id"]; ?>" class="page_builder-add-page-checkbox">
                <?php echo $page["pagename"]; ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="footer">
        <input type="submit" name="add_pages" value="Add pages">
    </div>
</div>