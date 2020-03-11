<?php

// set template loader link in settings menu
plugins::set_settings_item("/admin/settings/td_template_loader", "template loader", "user");

// query the template folder name from the database
templateLoaderFiles::set_template_base_dir();

//templateLoaderFiles::set_template_file("td_website");