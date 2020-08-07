<div class="create-columns" block_type="create_columns">
    <div class="header">create-columns</div>
    <div class="content">
        <button class="delete_block" delete_id="block_id_<?php echo build_cms_page_builder_loadCreateColumns_pluginSubModal::$block_id; ?>">Delete</button>
        <p>Number of columns</p>
        <input type="number" name="create-columns-number" class="create-columns-number" value="<?php echo build_cms_page_builder_loadCreateColumns_pluginSubModal::$create_columns_number; ?>" min="1" max="12">
        <div class="columns">

            <?php foreach (build_cms_page_builder_loadCreateColumns_pluginSubModal::$array AS $key => $value) {?>
                <div class="the_column" column="<?php echo $key + 1 ?>" style="flex: <?php echo $value["width"]; ?>;" flex="<?php echo $value["width"]; ?>">
                    <input type="number" name="column-width" value="<?php echo (float)rtrim((string)$value["width"], "0"); ?>" min="0" max="100" class="column-width-number">%
                    <div class="column-building-blocks-area sortable-building-blocks" building_blocks_area="<?php echo build_cms_page_builder_loadCreateColumns_pluginSubModal::$block_id; ?>-<?php echo $value["column_id"]; ?>">
                        <?php build_cms_page_builder_load_page_pluginSubController::load_blocks(build_cms_page_builder_loadCreateColumns_pluginSubModal::$block_id . "-" . $value["column_id"]); ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>