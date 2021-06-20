<div class="subcategories" block_status="saved" id="subcategories_block_<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$block_id ?>" subcategories_block_id="<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$block_id ?>" block_type="subcategories">
    <div class="header">subcategories</div>
    <div class="content">
        <button class="delete_block" delete_id="block_id_<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$block_id ?>">Delete</button>
        <select name="subcategories_limit">
            <option value="no-limit"<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$no_limit ?>>No limit</option>
            <option value="limited"<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$limited ?>>Limited</option>
        </select>
        <input type="number" name="subcategories_limit_number" min="0" value="<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$the_limit ?>">
        <select name="subcategories_order">
            <option value="DESC"<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$latest ?>>Latest page first</option>
            <option value="ASC"<?php echo build_cms_page_builder_loadSubcategories_pluginSubModal::$first ?>>First page first</option>
        </select>
    </div>
</div>