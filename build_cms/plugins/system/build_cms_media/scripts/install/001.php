<?php

$query_array = array(
    "CREATE TABLE `media` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `the_file_name` varchar(255) NOT NULL,
        `media_type` varchar(500) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",

    "CREATE TABLE `page_img_block` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `page_blocks_id` int(20) NOT NULL,
        `page_id` int(20) NOT NULL,
        `block_id` int(20) NOT NULL,
        `image` varchar(256) NOT NULL,
        `img_size_mode` varchar(10) NOT NULL,
        `img_width` int(11) NOT NULL,
        `img_height` int(11) NOT NULL,
        `image_align` varchar(10) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
);

foreach ($query_array AS $query) {
    database::query($query);
}