<div class="page_builder_root_container">
    <div class="page_builder_page_loader">
        <div class="loader_container">
            <h1 id="loading_page_text">Loading Page builder...</h1>
            <div id="page_builder_loading_progressbar"></div>
        </div>
    </div>
    <div class="page_builder_the_page" style="display: none;">
        <div class="save_massage" id="save_massage_success">
            <h2>success</h2>
        </div>

        <div class="title">
            <h1 id="build_cms-page_title"><?php echo build_cms_page_builder_add_page_pluginModal::$edit_page_name; ?></h1>
        </div>

        <input type="hidden" value="<?php echo build_cms_page_builder_add_page_pluginModal::$highest_block_id; ?>" id="block_id_start">

        <div class="page-content">
            <div class="build">
                <div class="all_building_blocks_area">
                    <?php foreach (build_cms_page_builder_template_loader::$building_blocks_area AS $building_blocks_area) { ?>
                        <div class="building-blocks-area-container">
                            <div class="header">
                                <?php if ( !empty($building_blocks_area["display_name"]) ): ?>
                                    <h2><?php echo $building_blocks_area["display_name"]; ?></h2>
                                <?php else: ?>
                                    <h2><?php echo $building_blocks_area["name"]; ?></h2>
                                <?php endif; ?>
                            </div>
                            <div class="content" style="display: <?php echo $building_blocks_area["css_display"]; ?>">
                                <div class="sortable-building-blocks" building_blocks_area="<?php echo $building_blocks_area["name"]; ?>">
                                    <?php build_cms_page_builder_load_page_pluginSubController::load_blocks($building_blocks_area["name"]); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="build_custom_area">
                    <?php foreach (build_cms_page_builder_page_functions::$build_custom_area AS $area) { ?>
                        <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                            <?php $area["function"]->__invoke(build_cms_page_builder_add_page_pluginModal::$page_id); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="sidebar">
                <!-- ============================== general ============================== -->
                <div class="general">
                    <h2>General:</h2>
                    <p>Pagename:</p>
                    <input type="text" name="pagename" value="<?php echo build_cms_page_builder_add_page_pluginModal::$page_name_imput; ?>">
                    <p>URL name</p>
                    <input type="text" name="url" value="<?php echo build_cms_page_builder_add_page_pluginModal::$page_url_imput; ?>">
                    <p>Status</p>
                    <select name="status">
                        <option value="not-published"<?php echo build_cms_page_builder_add_page_pluginModal::$status_not_published; ?>>Not published</option>
                        <option value="published"<?php echo build_cms_page_builder_add_page_pluginModal::$status_published; ?>>Published</option>
                    </select>

                    <p>Choose a template</p>
                    <select name="choose_template">
                        <option value="default"<?php echo build_cms_page_builder_add_page_pluginModal::$default_template; ?>>Default</option>
                        <?php foreach (build_cms_page_builder_add_page_pluginModal::$index_the_template AS $template_file): ?>
                            <option value="<?php echo $template_file["template"]; ?>"<?php echo $template_file["active"]; ?>>
                                <?php echo $template_file["template"]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <p>Homepage: <input type="checkbox" name="homepage" <?php echo build_cms_page_builder_add_page_pluginModal::$page_home; ?>></p>

                    <input type="submit" value="Save" id="add_btn">

                    <input type="hidden" name="page_id" value="<?php echo build_cms_page_builder_add_page_pluginModal::$page_id; ?>">
                    <input type="hidden" name="time_stamp" value="<?php echo build_cms_page_builder_add_page_pluginModal::$time_stamp; ?>">
                </div>
                <!-- ============================== /general ============================== -->

                <!-- ============================== all-building-blocks ============================== -->
                <div class="all-building-blocks" id="all-building-blocks">
                    <div class="header">
                        All building blocks
                    </div>
                    <div class="content">
                        <?php foreach (build_cms_page_builder_page_functions::$define_block AS $define_block) { ?>
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
                            <input type="radio" name="page_category" id="root" value="" <?php echo build_cms_page_builder_add_page_pluginSubController::select_root_category(); ?>><label for="root">Root</label>
                        </div>
                        <hr>
                        <?php echo build_cms_page_builder_add_page_pluginSubController::get_category(); ?>
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
                        <input type="text" name="pagetitle" value="<?php echo build_cms_page_builder_add_page_pluginModal::$seo_pagetitle; ?>">
                        <p>Author</p>
                        <input type="text" name="author" value="<?php echo build_cms_page_builder_add_page_pluginModal::$seo_author; ?>">
                        <p>Keywords</p>
                        <input type="text" name="keywords" value="<?php echo build_cms_page_builder_add_page_pluginModal::$seo_keywords; ?>">
                        <p>Description</p>
                        <input type="text" name="description" value="<?php echo build_cms_page_builder_add_page_pluginModal::$seo_description; ?>">
                    </div>
                </div>
                <!-- ============================== /SEO ============================== -->

                <!-- ============================== sidebar custom area ============================== -->
                <div class="sidebar_custom_area">
                    <?php foreach (build_cms_page_builder_page_functions::$sidebar_custom_area AS $area) { ?>
                        <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                            <?php $area["function"]->__invoke(build_cms_page_builder_add_page_pluginModal::$page_id); ?>
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
                <?php foreach (build_cms_page_builder_page_functions::$bottom_custom_area AS $area) { ?>
                    <div class="custom_area_container" id="custom_area_<?php echo $area["area"]; ?>">
                        <?php $area["function"]->__invoke(build_cms_page_builder_add_page_pluginModal::$page_id); ?>
                    </div>
                <?php } ?>
            </div>

        <!-- ============================== /bottom custom area ============================== -->
    </div>
</div>