<div class="wysiwyg block" block_status="saved">
    <div class="header">Visual Editor</div>
    <div class="content">
        <button class="delete_block">Delete</button>
        <textarea name="text-editer" class="wysiwyg-text-editer" id="wysiwyg_id-<?php echo pageBuilder_loadWysiwygSubModal::$block_id; ?>" wysiwyg_id="<?php echo pageBuilder_loadWysiwygSubModal::$block_id; ?>" rows="10"><?php echo pageBuilder_loadWysiwygSubModal::$sql_data; ?></textarea>
    </div>
</div>