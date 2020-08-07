<div class="main_header">
    <h1>Dashboard - Thanks for using Build-CMS</h1>
</div>


<div class="main_container">
    <div class="sidebar text-center">
        <?php if (empty(dashboardModal::$user_icon)) { ?>
            <img id="image_user_icon" src="<?php echo config_url::BASE("/admin_files/dashboard/default_user_icon.png"); ?>" alt="user icon">
        <?php } else { ?>
            <img id="image_user_icon" src="<?php echo config_url::BASE("/admin_files/dashboard/user_icons/" . dashboardModal::$user_icon); ?>" alt="user icon">
        <?php } ?>
        <button class="user_icon_btn" id="add_icon_btn">Edit/Add a user icon</button>
        <button class="user_icon_btn red_btn" id="delete_icon_btn">Delete user icon</button>

        <!-- ============================== Add/Edit/Delete forms ============================== -->
        <form action="/admin_submit/dashboard/add_icon" method="post" class="td-ajax" enctype="multipart/form-data" id="add_icon_form">
            <!-- Edit/Add -->
            <input type="file" name="add_icon" id="add_icon_input">
        </form>
        <form action="/admin_submit/dashboard/delete_icon" method="post" class="td-ajax">
            <!-- delete -->
            <input type="submit" name="add_icon" id="delete_icon_input">
        </form>
        <!-- ============================== /Add/Edit/Delete forms ============================== -->
    </div>
    <div class="main_content">
        <div class="user_credentials_form_container">
            <form action="/admin_submit/dashboard/user_profile" method="post" class="td-ajax" id="login_credentials_form">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo dashboardModal::$user_id; ?>">
                <h1>Reset your login credentials</h1>
                <p>Username:</p>
                <input type="text" name="username" value="<?php echo dashboardModal::$user; ?>" required>
                <p>Password:</p>
                <input type="password" name="password" required>
                <p>Password confirm:</p>
                <input type="password" name="password_confirm" required>
                <input type="submit">
            </form>
            <button class="save-btn" id="login_credentials_save_btn">Reset</button>
        </div>

        <?php // ======================================== widgets area ======================================== ?>
            <?php foreach (plugins::$dashboard_widgets AS $widgets) { ?>
                <div id="<?php echo $widgets["id"] ?>" class="main_plugin_widget">
                    <?php echo $widgets["function"]->__invoke(); ?>
                </div>
            <?php } ?>
        <?php // ======================================== /widgets area ======================================== ?>
    </div>
</div>