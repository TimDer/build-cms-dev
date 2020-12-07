<?php

database::query("CREATE TABLE `page` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `pagename` varchar(100) NOT NULL,
    `status` varchar(50) NOT NULL,
    `home_page` varchar(10) NOT NULL,
    `choose_template` varchar(255) NOT NULL,
    `url` varchar(6000) NOT NULL,
    `pagetitle` varchar(6000) NOT NULL,
    `author` varchar(6000) NOT NULL,
    `keywords` varchar(6000) NOT NULL,
    `description` varchar(6000) NOT NULL,
    `post_page` varchar(6000) NOT NULL,
    `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;");

database::query("CREATE TABLE `page_blocks` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_id` bigint NOT NULL,
    `block_type` varchar(100) NOT NULL,
    `block_id` bigint NOT NULL,
    `building_blocks_area` varchar(6000) NOT NULL,
    `the_order` bigint NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");

database::query("CREATE TABLE `page_cc_block` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_id` bigint NOT NULL,
    `block_id` bigint NOT NULL,
    `column_id` int NOT NULL,
    `width` decimal(65,30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");

database::query("CREATE TABLE `page_img_block` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_blocks_id` int NOT NULL,
    `page_id` int NOT NULL,
    `block_id` int NOT NULL,
    `image` varchar(256) NOT NULL,
    `img_size_mode` varchar(10) NOT NULL,
    `img_width` int NOT NULL,
    `img_height` int NOT NULL,
    `image_align` varchar(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

database::query("CREATE TABLE `page_plain_text` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_blocks_id` bigint NOT NULL,
    `page_id` bigint NOT NULL,
    `block_id` bigint NOT NULL,
    `data` longtext NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

database::query("CREATE TABLE `page_sub_cat` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_blocks_id` bigint NOT NULL,
    `page_id` bigint NOT NULL,
    `block_id` bigint NOT NULL,
    `limit_type` varchar(10) NOT NULL,
    `the_limit` bigint NOT NULL,
    `sort` varchar(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;");

database::query("CREATE TABLE `page_wysiwyg` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `page_blocks_id` bigint NOT NULL,
    `page_id` bigint NOT NULL,
    `block_id` bigint NOT NULL,
    `data` longtext NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;");