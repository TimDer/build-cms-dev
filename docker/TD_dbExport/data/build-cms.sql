-- table dump with TD_dbExport by Tim Derksen
-- Download url: https://www.github.com/TimDer/TD_dbExport

-- media
CREATE TABLE `media` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `the_file_name` varchar(255) NOT NULL,
  `media_type` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `media` ADD PRIMARY KEY (`id`);

-- menu_content
CREATE TABLE `menu_content` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `the_name` varchar(6000) NOT NULL,
  `the_url` varchar(6000) NOT NULL,
  `the_order` bigint NOT NULL,
  `parent_id` bigint NOT NULL,
  `menu_name` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
ALTER TABLE `menu_content` ADD PRIMARY KEY (`id`);

-- menu_name
CREATE TABLE `menu_name` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(6000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
ALTER TABLE `menu_name` ADD PRIMARY KEY (`id`);

-- page
CREATE TABLE `page` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
ALTER TABLE `page` ADD PRIMARY KEY (`id`);

-- page_blocks
CREATE TABLE `page_blocks` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `page_id` bigint NOT NULL,
  `block_type` varchar(100) NOT NULL,
  `block_id` bigint NOT NULL,
  `building_blocks_area` varchar(6000) NOT NULL,
  `the_order` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
ALTER TABLE `page_blocks` ADD PRIMARY KEY (`id`);

-- page_cc_block
CREATE TABLE `page_cc_block` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `page_id` bigint NOT NULL,
  `block_id` bigint NOT NULL,
  `column_id` int NOT NULL,
  `width` decimal(65,30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
ALTER TABLE `page_cc_block` ADD PRIMARY KEY (`id`);

-- page_img_block
CREATE TABLE `page_img_block` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `page_img_block` ADD PRIMARY KEY (`id`);

-- page_plain_text
CREATE TABLE `page_plain_text` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `page_blocks_id` bigint NOT NULL,
  `page_id` bigint NOT NULL,
  `block_id` bigint NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `page_plain_text` ADD PRIMARY KEY (`id`);

-- page_sub_cat
CREATE TABLE `page_sub_cat` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `page_blocks_id` bigint NOT NULL,
  `page_id` bigint NOT NULL,
  `block_id` bigint NOT NULL,
  `limit_type` varchar(10) NOT NULL,
  `the_limit` bigint NOT NULL,
  `sort` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
ALTER TABLE `page_sub_cat` ADD PRIMARY KEY (`id`);

-- page_wysiwyg
CREATE TABLE `page_wysiwyg` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `page_blocks_id` bigint NOT NULL,
  `page_id` bigint NOT NULL,
  `block_id` bigint NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
ALTER TABLE `page_wysiwyg` ADD PRIMARY KEY (`id`);

-- settings
CREATE TABLE `settings` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sidetitle` varchar(6000) NOT NULL,
  `sideslogan` varchar(6000) NOT NULL,
  `membership` int NOT NULL,
  `new_user_default_role` varchar(20) NOT NULL,
  `tamplateLoaderID` varchar(20000) NOT NULL,
  `cms_version` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
ALTER TABLE `settings` ADD PRIMARY KEY (`id`);

-- templates
CREATE TABLE `templates` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `active_template` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
ALTER TABLE `templates` ADD PRIMARY KEY (`id`);

-- users
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user` varchar(6000) NOT NULL,
  `password` varchar(150) NOT NULL,
  `password_salt` varchar(10000) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `user_icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
ALTER TABLE `users` ADD PRIMARY KEY (`id`);