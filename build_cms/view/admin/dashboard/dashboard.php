<div class="main_header">
    <h1>Dashboard - Thanks for using Build-CMS</h1>
</div>


<div class="main_container">
    <div class="sidebar text-center">
        <?php if (empty(dashboardModal::$user_icon)) { ?>
            <img src="<?php echo config_url::BASE("/admin_files/dashboard/default_user_icon.png"); ?>" alt="user icon">
        <?php } else { ?>
            <img src="<?php echo config_url::BASE("/admin_files/dashboard/user_icons/" . dashboardModal::$user_icon); ?>" alt="user icon">
        <?php } ?>
        <button class="user_icon_btn">Edit/Add a user icon</button>
        <button class="user_icon_btn red_btn">Delete user icon</button>
    </div>
    <div class="main_content">
        <div class="form_container">
            <form action="/admin_submit/dashboard/user_profile" method="post" class="td-ajax" id="login_credentials_form">
                <input type="hidden" name="user_id" value="<?php echo dashboardModal::$user_id; ?>">
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
    </div>
</div>