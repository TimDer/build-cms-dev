<div class="message_container">
    <div class="message<?php echo (empty(pluginsModal::$message_class)) ? "" : " " . pluginsModal::$message_class; ?>">
        <h4><?php echo pluginsModal::$display_message; ?></h4>
    </div>
</div>

<div class="plugins_header">
    <h1>Plugins</h1>
</div>

<div class="plugins_main_container">
    <div class="plugin_install">
        <form action="<?php echo config_url::BASE("/admin_submit/plugins/install"); ?>" method="post" enctype="multipart/form-data">
            <div class="form_row">
                <div class="col">
                    <label for="plugin_zip_file" class="plugin_upload_label">Select a plugin</label>
                    <input type="file" name="file" id="plugin_zip_file">
                </div>
                <div class="col">
                    <input type="submit" value="Install the plugin" class="upload_submit_btn">
                </div>
            </div>
        </form>
    </div>
    <div class="plugins_all">
        <table class="table">
            <thead>
                <tr>
                    <th>Plugin name:</th>
                    <th>Plugin description:</th>
                    <th>Action:</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (pluginsModal::$plugins_array AS $plugins) { ?>
                    <tr>
                        <td><?php echo $plugins["json_file"]["name"] ?></td>
                        <td><?php echo $plugins["json_file"]["description"] ?></td>
                        <td>
                            <button delete_dir="<?php echo $plugins["json_file"]["directory_name"]; ?>" class="delete_btn plugin_btn">Delete</button>
                            <?php if (users::is_developer()): ?>
                                / <a href="<?php echo config_url::BASE("/admin_submit/plugins/download/" . $plugins["json_file"]["directory_name"] . ".bcpi"); ?>" class="create_installer_btn plugin_btn">Create-installer (<?php echo $plugins["json_file"]["name"] ?>)</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>