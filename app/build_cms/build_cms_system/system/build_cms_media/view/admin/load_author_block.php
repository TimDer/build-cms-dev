<div class="image" block_status="saved" block_type="image">
    <div class="header">image</div>
    <div class="content">
        <button class="delete_block" delete_id="block_id_<?php echo media_loadImageBlock_pluginModal::$block_id ?>">Delete</button>
        <button class="image-open-modal-btn">Select an image</button>
        <img src="<?php echo config_url::BASE("/images/" . media_loadImageBlock_pluginModal::$image); ?>" alt="Select an image" class="img_data<?php echo media_loadImageBlock_pluginModal::$image_content_align ?>" id="image-<?php echo media_loadImageBlock_pluginModal::$block_id ?>" image_id="<?php echo media_loadImageBlock_pluginModal::$block_id ?>" img_filename="<?php echo media_loadImageBlock_pluginModal::$image ?>" img_size_mode="<?php echo media_loadImageBlock_pluginModal::$img_size_mode ?>" img_width="<?php echo media_loadImageBlock_pluginModal::$img_width; ?>" img_height="<?php echo media_loadImageBlock_pluginModal::$img_height; ?>" <?php echo media_loadImageBlock_pluginModal::$img_size ?>>
    </div>
</div>