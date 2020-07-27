<div class="content">
    <h1>Genaral</h1>

    <form action="/admin_submit/settings/general" method="POST" class="td-ajax">
        <table>
            <!-- Site title -->
            <tr class="row-setting">
                <th class="label">Site title</th>
                <td class="option">
                    <input type="text" name="site-title" value="<?php echo generalModal::$sidetitle; ?>">
                </td>
            </tr>
            <!-- /Site title -->
            <!-- Site slogan -->
            <tr class="row-setting">
                <th class="label">Site slogan</th>
                <td class="option">
                    <input type="text" name="site-slogan" value="<?php echo generalModal::$sideslogan; ?>">
                </td>
            </tr>
            <!-- /Site slogan -->
            <!-- Membership -->
            <tr class="row-setting">
                <th class="label">Membership</th>
                <td class="option text-checkbox">
                    <input type="checkbox" name="membership" value="1" <?php echo generalModal::$membership; ?>>
                    Anyone can register
                </td>
            </tr>
            <!-- /Membership -->
            <!-- new user default role -->
            <tr class="row-setting">
                <th class="label">New user default role</th>
                <td class="option">
                    <select name="new-user-default-role">
                        <option value="user" <?php echo generalModal::$new_user_default_role_user; ?>>user</option>
                        <option value="author"<?php echo generalModal::$new_user_default_role_author; ?>>author</option>
                        <option value="admin" <?php echo generalModal::$new_user_default_role_admin; ?>>admin</option>
                    </select>
                </td>
            </tr>
            <!-- /new user default role -->
            <!-- Set a template loader -->
            <tr class="row-setting">
                <th class="label">Set a template loader</th>
                <td class="option">
                    <select name="set-a-template-loader">
                        <?php foreach (generalModal::$templateLoader AS $templateLoader) { ?>
                            <?php if (generalModal::$templateLoaderSelectedID === $templateLoader["id"]) { ?>
                                <option value="<?php echo $templateLoader["id"] ?>" selected><?php echo $templateLoader["displayName"] ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $templateLoader["id"] ?>"><?php echo $templateLoader["displayName"] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <!-- /Set a template loader -->
        </table>
        
        <input type="submit" value="submit" class="submit">
    </form>
</div>