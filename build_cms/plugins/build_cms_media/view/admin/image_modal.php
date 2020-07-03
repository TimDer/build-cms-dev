<div class="modal" id="image_modal">
    <div class="header">
        <div class="modal-title">
            <h1>image</h1>
        </div>
        <div class="modal-close" id="close-image-modal">
            &#x2573;
        </div>
    </div>
    <div class="body">
        <div class="content">
            <?php echo image_modalSubController::get_images_modal(); ?>
        </div>
        <div class="sidebar">
            <div class="selected_image">
                <img src="" alt="select an image">
            </div>
            <h4>Select image size</h4>
            <select name="img_size_mode" class="img_size_mode">
                <option value="auto">Auto</option>
                <option value="custom">Custom pixels</option>
            </select>
            <div class="form_group_img">
                <input type="number" name="img_width" min="0" disabled> <p>X</p> <input type="number" name="img_height" min="0" disabled>
            </div>
            <h4>Align image</h4>
            <select name="align_image" class="align_image_modal" disabled>
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="center">Center</option>
            </select>
        </div>
    </div>
</div>