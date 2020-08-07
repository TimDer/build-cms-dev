<div class="root_container">
    <div class="loader_root_container">
        <div class="loading_box">
            <h1>Loading <?php echo build_cms_media_pluginModal::$display_name_plural ?>...</h1>
            <img src="<?php echo config_url::BASE("/admin_files/plugin/media/loading_page.gif"); ?>">
        </div>
    </div>
    <div class="content_root_container" style="visibility: hidden;">
        <div class="main_header">
            <h1><?php echo build_cms_media_pluginModal::$display_name_plural ?></h1>
        </div>

        <div class="main_container">
            <div class="upload_container bootstrap">
                <div class="container-fluid">
                    <form action="<?php echo config_url::BASE("/admin/media/" . build_cms_media_pluginModal::$name . "/upload"); ?>" method="post" enctype="multipart/form-data" id="data_upload_form">
                        <div class="row">
                            <div class="col-6">
                                <label for="files_uploader" class="label_files_uploader form-control btn btn-primary">Select file(s)</label>
                                <input type="file" name="files[]" id="files_uploader" class="file_input" multiple>
                            </div>
                            <div class="col-6">
                                <input type="submit" class="form-control btn btn-primary" max_files="<?php echo ini_get("max_file_uploads"); ?>" id="data_upload_submit" value="Upload">
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
            </div>

            <div class="data_container">
                <?php echo build_cms_media_pluginModal::$data_html; ?>
            </div>
        </div>
    </div>
</div>

<div class="data_modal_container bootstrap">

    <!-- ============================== data modal ============================== -->
    <div class="modal fade" id="data_modal" tabindex="-1" role="dialog" aria-labelledby="Data" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="data_modal_title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body content_p" id="data_modal_content">
                    <?php if (build_cms_media_pluginModal::$name === "images"): ?>
                        <img src="" image_id="" id="load_image">
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <?php if (build_cms_media_pluginModal::$name === "images"): ?>
                        <button type="button" id="delete_image_btn" class="btn btn-primary">Delete Image</button>
                    <?php else: ?>
                        <button type="button" id="delete_download_btn" class="btn btn-primary" delete_id="">Delete</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================== /data modal ============================== -->

    <!-- ============================== error modal ============================== -->
    <div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="Error" aria-hidden="true" open_modal="<?php echo build_cms_media_pluginModal::$open_error_modal; ?>">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="error_modal_title">Something went wrong</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body content_p" id="error_content">
                    <?php foreach (build_cms_media_pluginModal::$get_var AS $error_key => $error): ?>
                        <?php if ($error_key === "error"): ?>
                            <?php foreach ($error AS $error_value): ?>
                                <p>
                                    <?php echo $error_value["data"]; ?> - 
                                    ( <?php echo files::$file_error_list[ $error_value["error"] ]; ?> )
                                </p>
                            <?php endforeach; ?>
                        <?php elseif ($error_key === "files_allowed"): ?>
                            <p>
                                The only files that are allowed are: 
                                ( <?php echo implode(", ", $error); ?> )
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================== /error modal ============================== -->

</div>