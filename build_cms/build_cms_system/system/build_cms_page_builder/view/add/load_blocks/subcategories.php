<div class="subcategories" block_status="saved" id="subcategories_block_<?php echo pageBuilder_loadSubcategoriesSubModal::$block_id ?>" subcategories_block_id="<?php echo pageBuilder_loadSubcategoriesSubModal::$block_id ?>" block_type="subcategories">
    <div class="header">subcategories</div>
    <div class="content">
        <button class="delete_block" delete_id="block_id_<?php echo pageBuilder_loadSubcategoriesSubModal::$block_id ?>">Delete</button>
        <select name="subcategories_limit">
            <option value="no-limit"<?php echo pageBuilder_loadSubcategoriesSubModal::$no_limit ?>>No limit</option>
            <option value="limited"<?php echo pageBuilder_loadSubcategoriesSubModal::$limited ?>>Limited</option>
        </select>
        <input type="number" name="subcategories_limit_number" min="0" value="<?php echo pageBuilder_loadSubcategoriesSubModal::$the_limit ?>">
        <select name="subcategories_order">
            <option value="DESC"<?php echo pageBuilder_loadSubcategoriesSubModal::$latest ?>>Latest page first</option>
            <option value="ASC"<?php echo pageBuilder_loadSubcategoriesSubModal::$first ?>>First page first</option>
        </select>
    </div>
</div>