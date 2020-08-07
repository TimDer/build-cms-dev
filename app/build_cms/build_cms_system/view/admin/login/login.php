<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo config_url::VIEW("/admin/login/css/login.css"); ?>">
    <title>Login to Build-CMS</title>
</head>
<body>
    <div class="login-container">
        <div class="img-container">
            <img src="<?php echo config_url::VIEW("/admin/login/images/login.png"); ?>" alt="login image">
        </div>
        
        <form action="<?php echo config_url::BASE("/admin_submit/login"); ?>" method="post">
            <input type="text" name="username" placeholder="Username..." required value="<?php echo loginModal::$user_error_display_username; ?>">
            <input type="password" name="password" placeholder="Password..." required>
            <input type="submit" name="submit" value="Login">
        </form>

        <a href="<?php echo config_url::BASE(); ?>" class="go-back">
            Go back to the home page
        </a>
        <?php echo loginModal::$user_error; ?>
    </div>
</body>
</html>