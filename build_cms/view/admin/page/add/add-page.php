<div class="save_massage" id="save_massage_success">
    <h2>success</h2>
</div>

<div class="title">
    <h1 id="td_cms-page_title"><?php echo add_pageModal::$edit_page_name; ?></h1>
</div>

<input type="hidden" value="<?php echo add_pageModal::$highest_block_id; ?>" id="block_id_start">

<div class="page-content">
    <div class="build">
        <div class="all_building_blocks_area">
            <?php foreach (plugins::$building_blocks_area AS $building_blocks_area) { ?>
                <div class="building-blocks-area-container">
                    <div class="header">
                        <h2><?php echo $building_blocks_area["display_name"]; ?></h2>
                    </div>
                    <div class="content" style="display: <?php echo $building_blocks_area["css_display"]; ?>">
                        <div id="<?php echo $building_blocks_area["id"]; ?>" class="sortable-building-blocks" building_blocks_area="<?php echo $building_blocks_area["name"]; ?>">
                            <?php load_pageSubController::load_blocks($building_blocks_area["name"]); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="build_custom_area">
            <?php foreach (page_functions::$build_custom_area AS $area) { ?>
                <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                    <?php $area["function"]->__invoke(); ?>
                </div>
            <?php } ?>
        </div>
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
        <div class="all-building-blocks" id="all-building-blocks">
            <div class="header">
                All building blocks
            </div>
            <div class="content">
                <?php foreach (page_functions::$define_block AS $define_block) { ?>
                    <div class="create_block" block_type="<?php echo $define_block["name"]; ?>">
                        <?php echo $define_block["display_name"] ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- ============================== /all-building-blocks ============================== -->

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

        <!-- ============================== sidebar custom area ============================== -->
        <div class="sidebar_custom_area">
            <?php foreach (page_functions::$sidebar_custom_area AS $area) { ?>
                <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                    <?php $area["function"]->__invoke(); ?>
                </div>
            <?php } ?>
        </div>
        <!-- ============================== sidebar custom area ============================== -->
    </div>
</div>

<!-- ============================== del_area ============================== -->

    <div id="del_area_blocks"></div>

<!-- ============================== /del_area ============================== -->

<!-- ============================== bottom custom area ============================== -->

    <div class="bottom_custom_area">
        <?php foreach (page_functions::$bottom_custom_area AS $area) { ?>
            <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                <?php $area["function"]->__invoke(); ?>
            </div>
        <?php } ?>
    </div>

<!-- ============================== /bottom custom area ============================== -->