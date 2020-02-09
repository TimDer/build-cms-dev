
    </main>
</div>

<!-- hidden base_url for js -->
<div id="build_cms_base_url" base_url="<?php echo config_url::BASE(); ?>"></div>
<!-- /hidden base_url for js -->

<!-- jquery -->
<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/jquery.js"); ?>"></script>
<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/jquery-ui.min.js"); ?>"></script>
<!-- /jquery -->

<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/main-menu.js"); ?>"></script>
<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/user_dropdown_menu.js"); ?>"></script>
<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/td-ajax.js"); ?>"></script>
<script src="<?php echo config_url::VIEW("/admin/admin_basics/js/keep_user_loggedin.js"); ?>"></script>
<?php controller::get_footer(); ?>


</body>
</html>