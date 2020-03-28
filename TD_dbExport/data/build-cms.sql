-- table dump with TD_dbExport by Tim Derksen
-- Download url: https://www.github.com/TimDer/TD_dbExport

-- plugins
CREATE TABLE `plugins` (
  `pluginID` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `directory_name` varchar(1000) NOT NULL,
  `description` varchar(8000) NOT NULL,
  PRIMARY KEY (`pluginID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
ALTER TABLE `plugins` ADD PRIMARY KEY (`pluginID`);

-- settings
CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sidetitle` varchar(6000) NOT NULL,
  `sideslogan` varchar(6000) NOT NULL,
  `membership` int(1) NOT NULL,
  `new_user_default_role` varchar(20) NOT NULL,
  `tamplateLoaderID` bigint(20) NOT NULL,
  `cms_version` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
ALTER TABLE `settings` ADD PRIMARY KEY (`id`);

-- templates
CREATE TABLE `templates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `active_template` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
ALTER TABLE `templates` ADD PRIMARY KEY (`id`);

-- users
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` varchar(6000) NOT NULL,
  `password` varchar(150) NOT NULL,
  `password_salt` varchar(10000) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `user_icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
ALTER TABLE `users` ADD PRIMARY KEY (`id`);