<?php

database::query("CREATE TABLE `menu_content` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `the_name` varchar(6000) NOT NULL,
    `the_url` varchar(6000) NOT NULL,
    `type` varchar(50) NOT NULL,
    `the_order` bigint NOT NULL,
    `parent_id` bigint NOT NULL,
    `menu_name_id` bigint NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1");

database::query("CREATE TABLE `menu_name` (
    `id` bigint NOT NULL AUTO_INCREMENT,
    `menu_name` varchar(6000) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1");