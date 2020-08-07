<div class="main_header">
    <h1>Edit users</h1>
</div>


<div class="main_content_area">
    <button class="btn btn-green btn-green-affect btn-block" id="add_new_user_btn" onclick="window.location.href = '<?php echo config_url::BASE('/admin/settings/users/add_new'); ?>';">Add a new user</button>
    <table class="table">
        <thead>
            <tr>
                <th>User-icon:</th>
                <th>User-name:</th>
                <th>User-type:</th>
                <th>Action:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (usersModal::$allUsers AS $user) { ?>
                <tr>
                    <td>
                        <?php if ($user["user_icon"] === "") { ?>
                            <img src="<?php echo config_url::BASE("/admin_files/dashboard/default_user_icon.png"); ?>" height="30">
                        <?php } else { ?>
                            <img src="<?php echo config_url::BASE("/admin_files/dashboard/user_icons/" . $user["user_icon"]); ?>" height="30">
                        <?php } ?>
                    </td>
                    <td><?php echo $user["user"] ?></td>
                    <td><?php echo $user["user_type"] ?></td>
                    <td>
                        <a href="<?php echo config_url::BASE('/admin/settings/users/edit/' . $user["id"]); ?>">Edit</a>, 
                        <a href="<?php echo config_url::BASE('/admin_submit/settings/users/delete/' . $user["id"]); ?>" class="delete_link">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>