<?php

routes::set("/admin/settings/td_template_loader", function () {
    controller::getAdminTemplateView();
}, "user_id", "admin");