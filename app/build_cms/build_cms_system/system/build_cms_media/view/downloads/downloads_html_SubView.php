<div class="downloads_container bootstrap">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">File-name:</th>
                <th scope="col">Url:</th>
                <th scope="col">Action:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (build_cms_media_pluginModal::$data_array AS $download): ?>
                <tr>
                    <td><?php echo $download["the_file_name"] ?></td>
                    <td><?php echo config::get_config()["domainDir"]; ?>/downloads/<?php echo $download["the_file_name"]; ?></td>
                    <td>
                        <button class="btn btn-primary download_open_btn" download_filename="<?php echo $download["the_file_name"]; ?>" download_id="<?php echo $download["id"]; ?>">
                            Delete
                        </button>
                        <a href="<?php echo config_url::BASE("/downloads/" . $download["the_file_name"]); ?>" target="_blank" class="btn btn-primary">
                            Download
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>