<div class="plugins_header">
    <h1>Plugins</h1>
</div>

<div class="plugins_main_container">
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
                    <td>Delete</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>