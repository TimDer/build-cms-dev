<div class="plugins_header">
    <h1>Plugins</h1>
</div>

<div class="plugins_main_container">
    <div class="plugin_install">
        <form action="<?php echo config_url::BASE("/admin_submit/plugins/install"); ?>" method="post">
            <div class="form_row">
                <div class="col">
                    <label for="plugin_zip_file" class="plugin_upload_label">Install a plugin</label>
                    <input type="file" name="file" id="plugin_zip_file">
                </div>
                <div class="col">
                    <input type="submit" value="Upload" class="upload_submit_btn">
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
                        <td><?php echo $plugins["name"] ?></td>
                        <td><?php echo $plugins["description"] ?></td>
                        <td>
                            <button delete_id="<?php echo $plugins["pluginID"]; ?>" class="delete_btn plugin_btn">Delete</button>
                            <?php if (users::is_developer()): ?>
                                / <button create_installer_id="<?php echo $plugins["pluginID"]; ?>" class="create_installer_btn plugin_btn">Create-installer</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>