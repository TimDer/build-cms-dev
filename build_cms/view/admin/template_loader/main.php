<div class="templates_header">
    <h1>Templates</h1>
</div>

<div class="main_area">
    <div class="row">
        <?php if ( extension_loaded("zip") ) { ?>
            <div class="col-1">
                <form action="<?php echo config_url::BASE("/admin_submit/template_loader/new_template"); ?>" enctype="multipart/form-data" id="upload_template" method="post">
                    <label for="new_template" class="btn">Select a template</label>
                    <input type="file" name="new_template" class="hide fileSubmit" submit_form="#upload_template" id="new_template">
                </form>
            </div>
        <?php } ?>
        <div class="col-1">
            <button class="btn btn-block toggle_modal" toggle="#create_new_template">Build a new template</button>
        </div>
    </div>

    <hr>

    <div class="grid grid-3 grid-gap-20">
        <?php foreach (build_cms_template_loaderModal::$all_templates AS $value) { ?>
            <div id="template_preview_<?php echo $value["id"]; ?>">
                <div class="template">
                    <div class="header"><?php echo $value["config"]["tem_name"] ?></div>
                    <div class="body">
                        <?php if (file_exists(config_dir::BASE("/view/templates/" . $value["config"]["folder_name"] . "/template_info/template_img.png"))) { ?>
                            <img src="<?php echo config_url::BASE("/admin/template_loader/" . $value["config"]["folder_name"] . "/template_info/template_img.png"); ?>">
                        <?php } else { ?>
                            <img src="<?php echo config_url::BASE("/admin_files/template_loader/template_img.png"); ?>">
                        <?php } ?>
                    </div>
                    <div class="footer"><button class="btn toggle_modal" toggle="#template_edit_modal_<?php echo $value["id"]; ?>">Manage</button></div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="modals">
        <?php foreach (build_cms_template_loaderModal::$all_templates AS $value) { ?>
            <div class="template_modal" id="template_edit_modal_<?php echo $value["id"]; ?>">
                <div class="template_modal_header">
                    <div class="row header">
                        <div class="col-1 title">Manage: <?php echo $value["config"]["tem_name"]; ?></div>
                        <div class="col-0 close">&#x2573;</div>
                    </div>
                </div>
                <div class="row template_modal_content">
                    <div class="col-1 sidebar">
                        <h1>Template screenshot:</h1>
                        <?php if (file_exists(config_dir::BASE("/view/templates/" . $value["config"]["folder_name"] . "/template_info/template_img.png"))) { ?>
                            <img src="<?php echo config_url::BASE("/admin/template_loader/" . $value["config"]["folder_name"] . "/template_info/template_img.png"); ?>">
                        <?php } else { ?>
                            <img src="<?php echo config_url::BASE("/admin_files/template_loader/template_img.png"); ?>">
                        <?php } ?>
                    </div>
                    <div class="col-1 content">
                        <div>
                            <div class="accordion">
                                <section>
                                    <h2 class="title accordion_toggle" toggle="#general_<?php echo $value["id"] ?>">General</h2>
                                    <div class="content" id="general_<?php echo $value["id"] ?>" style="display: block;">
                                        <div class="grid grid-2 grid-gap-10">
                                            <?php foreach ($value["config"] AS $config_key => $config_value) { ?>
                                                <div>
                                                    <?php 
                                                        echo ucfirst(preg_replace(array("/_/", "/tem/"), array(" ", "template"), $config_key));
                                                    ?>: 
                                                    <?php if (filter_var($config_value, FILTER_VALIDATE_URL)) { ?>
                                                        <a href="<?php echo $config_value; ?>" target="_blank"><?php echo $config_value; ?></a>
                                                    <?php } else { ?>
                                                        <?php echo $config_value; ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="title accordion_toggle" toggle="#description_<?php echo $value["id"] ?>">Description</h2>
                                    <div class="content" id="description_<?php echo $value["id"] ?>">
                                        <?php echo $value["info"]; ?>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="title accordion_toggle" toggle="#license_<?php echo $value["id"] ?>">License</h2>
                                    <div class="content" id="license_<?php echo $value["id"] ?>">
                                        <?php echo preg_replace(array("/\\\\n/", "/\\\\r/", '/\\\\"/'), array("<br>", "", '"'), $value["license"]); ?>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="title accordion_toggle" toggle="#actions_<?php echo $value["id"] ?>">Actions</h2>
                                    <div class="content" id="actions_<?php echo $value["id"] ?>">
                                        <div class="row">
                                            <div class="col-1">
                                                <a href="<?php echo config_url::BASE("/admin_submit/template_loader/delete_template/" . $value["config"]["folder_name"]); ?>" modal_id="#template_edit_modal_<?php echo $value["id"]; ?>" preview_id="#template_preview_<?php echo $value["id"]; ?>" class="btn btn-block btn-red delete_this_template">
                                                    Delete this template
                                                </a>
                                            </div>
                                            <form action="/admin_submit/template_loader/activate" method="post" class="td-ajax col-1">
                                                <input class="btn btn-block" name="activate" type="submit" value="Activate">
                                                <input type="hidden" name="dir" value="<?php echo $value["config"]["folder_name"]; ?>">
                                            </form>
                                            <?php if ( extension_loaded("zip") && count(scandir(config_dir::BASE("/view/templates/" . $value["config"]["folder_name"]))) > 2 ) { ?>
                                                <div class="col-1">
                                                    <a href="<?php echo config_url::BASE("/admin_submit/template_loader/download_template/" . $value["config"]["folder_name"] . "/" . $value["config"]["folder_name"] . ".zip"); ?>" class="btn btn-block">
                                                        Download (<?php echo $value["config"]["tem_name"]; ?>)
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="create_new_template" id="create_new_template">
            <div>
                <div class="header">
                    <h3>Add a new template folder</h3>
                </div>
                <div class="content">
                    <form action="<?php echo config_url::BASE("/admin_submit/template_loader/create_new_template"); ?>" method="POST" class="form_control">
                        <p>Template name:</p>
                        <input type="text" name="template_name" required>
                        <p>Template folder name:</p>
                        <input type="text" name="template_dir" maxlength="255" required>
                        <p>Template Author:</p>
                        <input type="text" name="Author" required>
                        <p>Template Author_url:</p>
                        <input type="text" name="Author_url" required>
                        <div class="row padding-top">
                            <div class="col-1">
                                <p>Template Description:</p>
                                <textarea name="Description" rows="10" required></textarea>
                            </div>
                            <div class="col-1">
                                <p>Template license:</p>
                                <textarea name="license" rows="10" required></textarea>
                            </div>
                        </div>
                        <p>Activate this template: <input type="checkbox" name="activate"></p>
                        <input type="submit" value="Create this template" class="btn">
                    </form>
                </div>
                <div class="footer">
                    <button class="btn btn-block btn-red close">Close</button>
                </div>
            </div>
        </div>
        <div class="background"></div>
    </div>
</div>