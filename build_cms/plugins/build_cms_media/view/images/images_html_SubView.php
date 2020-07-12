<?php foreach (build_cms_media_pluginModal::$images_array AS $image): ?>
    <div class="image_container">
        <button class="image_btn" id="image_btn_<?php echo $image["id"] ?>" image_id="<?php echo $image["id"] ?>" img_filename="<?php echo $image["the_file_name"]; ?>">
            <img class="image_img" id="image_img_<?php echo $image["id"] ?>" src="<?php echo config_url::BASE("/images/" . $image["the_file_name"]); ?>">
        </button>
    </div>
<?php endforeach; ?>