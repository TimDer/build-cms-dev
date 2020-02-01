<div class="save_massage" id="save_massage_success">
    <h2>success</h2>
</div>

<div class="title">
    <h1 id="td_cms-page_title"><?php echo add_pageModal::$edit_page_name; ?></h1>
</div>

<input type="hidden" value="<?php echo add_pageModal::$highest_block_id; ?>" id="block_id_start">

<div class="page-content">
    <div class="build">
        <h2>Content</h2>
        <!-- ============================== building-blocks-area ============================== -->
        <div id="building-blocks-area" class="sortable-building-blocks">

        </div>
        <!-- ============================== /building-blocks-area ============================== -->
        <!-- ============================== building-blocks-area sidebars ============================== -->
        <div class="building-blocks-area-sidebars">
            <div class="header">
                Left and Right sidebar
            </div>
            <div class="content left-and-right-sidebar">
                <div>
                    <h3>Left sidebar</h3>
                    <div class="sortable-building-blocks" id="sortable-building-blocks-left"></div>
                </div>
                <div>
                    <h3>Right sidebar</h3>
                    <div class="sortable-building-blocks" id="sortable-building-blocks-right"></div>
                </div>
            </div>
        </div>
        <!-- ============================== building-blocks-area sidebars ============================== -->
    </div>
    <div class="sidebar">
        <!-- ============================== general ============================== -->
        <div class="general">
            <h2>General:</h2>
            <p>Pagename:</p>
            <input type="text" name="pagename" value="<?php echo add_pageModal::$page_name_imput; ?>">
            <p>URL name</p>
            <input type="text" name="url" value="<?php echo add_pageModal::$page_url_imput; ?>">
            <p>Status</p>
            <select name="status">
                <option value="not-published"<?php echo add_pageModal::$status_not_published; ?>>Not published</option>
                <option value="published"<?php echo add_pageModal::$status_published; ?>>Published</option>
            </select>
            <p>Homepage: <input type="checkbox" name="homepage" <?php echo add_pageModal::$page_home; ?>></p>

            <input type="submit" value="Save" id="add_btn">

            <input type="hidden" name="page_id" value="<?php echo add_pageModal::$page_id; ?>">
            <input type="hidden" name="time_stamp" value="<?php echo add_pageModal::$time_stamp; ?>">
        </div>
        <!-- ============================== /general ============================== -->

        <!-- ============================== all-building-blocks ============================== -->
        <div class="all-building-blocks">
            <div class="header">
                All building blocks
            </div>
            <div class="content">
                <!-- wysiwyg -->
                <div class="wysiwyg" id="wysiwyg_block">
                    <div class="header">
                        Visual Editor
                    </div>
                    <div class="content">
                        <textarea name="new-text-editer" class="wysiwyg-text-editer" rows="10"></textarea>
                    </div>
                </div>
                <!-- /wysiwyg -->
                <!-- plain text -->
                <div class="plain-text" id="plain-text_block">
                    <div class="header">
                        plain text
                    </div>
                    <div class="content">
                        <textarea name="new-text-editer" class="plain-text-editer" rows="10"></textarea>
                    </div>
                </div>
                <!-- /plain text -->
                <!-- image -->
                <div class="image" id="image_block">
                    <div class="header">
                        image
                    </div>
                    <div class="content">
                        <button>Select an image</button>
                        <img src="" alt="Select an image">
                        <input type="hidden" name="new-image">
                    </div>
                </div>
                <!-- /image -->
                <!-- create columns -->
                <div class="create-columns" id="create-columns_block">
                    <div class="header">
                        create-columns
                    </div>
                    <div class="content">
                        <p>Number of columns</p>
                        <input type="number" name="new-create-columns-number" value="1" min="1" max="12" disabled class="number-of-columns">
                        <div class="columns">
                            <div column="1">
                                <input type="number" name="new-column-width" value="100" min="0" max="100" disabled class="column-width-number">%
                                <div class="new-column-building-blocks-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /create columns -->
                <!-- subcategories -->
                <div class="subcategories" id="subcategories_block">
                    <div class="header">
                        subcategories
                    </div>
                    <div class="content">
                        <select name="subcategories_limit" disabled>
                            <option value="no-limit">No limit</option>
                            <option value="limited">Limited</option>
                        </select>
                        <input type="number" name="subcategories_limit_number" min="0" value="1" disabled>
                        <select name="subcategories_order" disabled>
                            <option value="latest">Latest page first</option>
                            <option value="first">First page first</option>
                        </select>
                    </div>
                </div>
                <!-- /subcategories -->
            </div>
        </div>
        <!-- ============================== /all-building-blocks ============================== -->

        <!-- ============================== SEO ============================== -->
        <div class="search-engine-optimization">
            <div class="header">
                SEO
            </div>
            <div class="content">
                <p>Page title</p>
                <input type="text" name="pagetitle" value="<?php echo add_pageModal::$seo_pagetitle; ?>">
                <p>Author</p>
                <input type="text" name="author" value="<?php echo add_pageModal::$seo_author; ?>">
                <p>Keywords</p>
                <input type="text" name="keywords" value="<?php echo add_pageModal::$seo_keywords; ?>">
                <p>Description</p>
                <input type="text" name="description" value="<?php echo add_pageModal::$seo_description; ?>">
            </div>
        </div>
        <!-- ============================== /SEO ============================== -->

        <!-- ============================== category_image ============================== -->
        <div class="category_image">
            <div class="header">
                Category info
            </div>
            <div class="content">
                <button class="image-open-modal-btn">Select an image</button>
                <img src="<?php echo add_pageSubController::get_category_image_src(); ?>" alt="Select an image" class="img_data" id="category_image" img_filename="<?php echo add_pageSubController::get_category_image(); ?>" category_image>
                <textarea id="category_text" class="wysiwyg-text-editer" rows="10"><?php echo add_pageSubController::get_category_text(); ?></textarea>
            </div>
        </div>
        <!-- ============================== /category_image ============================== -->

        <!-- ============================== category ============================== -->
        <div class="page-category">
            <div class="header">
                Category
            </div>
            <div class="content" id="page-category">
                <div class="category_container">
                    <input type="radio" name="page_category" id="root" value="" <?php echo add_pageSubController::select_root_category(); ?>><label for="root">Root</label>
                </div>
                <hr>
                <?php echo add_pageSubController::get_category(); ?>
            </div>
        </div>
        <!-- ============================== /category ============================== -->
    </div>
</div>

<!-- ============================== del_area ============================== -->

    <div id="del_area_blocks"></div>

<!-- ============================== del_area ============================== -->

<!-- ============================== image modal ============================== -->

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

<!-- ============================== image modal ============================== -->