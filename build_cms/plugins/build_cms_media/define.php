<?php

load_pageSubController::set_block_type("image", function ($data) { media_loadImageBlock_pluginController::author_get_image_block($data); });