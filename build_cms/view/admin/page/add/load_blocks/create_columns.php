<div class="create-columns" block_type="create_columns">
    <div class="header">create-columns</div>
    <div class="content">
        <button class="delete_block">Delete</button>
        <p>Number of columns</p>
        <input type="number" name="create-columns-number" class="create-columns-number" value="<?php echo pageBuilder_loadCreateColumnsSubModal::$create_columns_number; ?>" min="1" max="12">
        <div class="columns">

            <?php foreach (pageBuilder_loadCreateColumnsSubModal::$array AS $key => $value) {?>
                <div class="the_column" column="<?php echo $key + 1 ?>" style="flex: <?php echo $value["width"]; ?>;" flex="<?php echo $value["width"]; ?>">
                    <input type="number" name="column-width" value="<?php echo (float)rtrim((string)$value["width"], "0"); ?>" min="0" max="100" class="column-width-number">%
                    <div class="column-building-blocks-area sortable-building-blocks" building_blocks_area="<?php echo pageBuilder_loadCreateColumnsSubModal::$block_id; ?>-<?php echo $value["column_id"]; ?>">
                        <?php load_pageSubController::load_blocks(pageBuilder_loadCreateColumnsSubModal::$block_id . "-" . $value["column_id"]); ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>