<div class="main_header">
    <h1>Edit: <?php echo usersModal::$allUsers[0]["user"] ?></h1>
</div>


<div class="main_content_area">
    <form action="/admin_submit/settings/users" method="post" class="td-ajax form-control">
        <p>Select a user icon:</p>
        <label for="user_icon" class="btn btn-green btn-green-affect btn-block">select a file</label>
        <input type="file" id="user_icon" name="user-icon">
        <p>Username:</p>
        <input type="text" name="username" required value="<?php echo usersModal::$allUsers[0]["user"] ?>">
        <p>Password:</p>
        <input type="password" name="password">
        <p>Password confirm:</p>
        <input type="password" name="passwordConfirm">
        <p>User type:</p>
        <select name="user_type">
            <option value="user" <?php echo usersModal::$htmlUserOption; ?>>User</option>
            <option value="author" <?php echo usersModal::$htmlAuthorOption; ?>>Author</option>
            <option value="admin" <?php echo usersModal::$htmlAdminOption; ?>>Admin</option>
        </select>
        <input type="hidden" name="id" value="<?php echo user_url::$new_uri[0]; ?>">
        <input type="submit" value="Save">
    </form>
</div>