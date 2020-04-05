<div class="img_btn_container">
    <label for="image_id_<?php echo image_modalModal::$image_id; ?>" class="img_btn" style="background-image: url('<?php echo config_url::BASE("/images/" . image_modalModal::$image_url); ?>');">
        <input type="radio" name="image_id" id="image_id_<?php echo image_modalModal::$image_id; ?>" class="img_btn_radio" img_url="<?php echo image_modalModal::$image_url ?>">
    </label>
</div>
