<?php

class install_build_cms_001 {
    private static $install_querys = array(
        "CREATE TABLE `installer_migrations` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `version` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",

        "CREATE TABLE `settings` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `sidetitle` varchar(6000) NOT NULL,
            `sideslogan` varchar(6000) NOT NULL,
            `membership` int NOT NULL,
            `new_user_default_role` varchar(20) NOT NULL,
            `tamplateLoaderID` varchar(1024) NOT NULL,
            `cms_version` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1",

        "INSERT INTO `settings` (`id`,
                                `sidetitle`,
                                `sideslogan`,
                                `membership`,
                                `new_user_default_role`,
                                `tamplateLoaderID`,
                                `cms_version`)
        VALUES (1,
                '',
                '',
                0,
                'author',
                '0',
                '1.0.0'
        );",

        "CREATE TABLE `templates` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `active_template` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1",

        "CREATE TABLE `users` (
            `id` bigint NOT NULL AUTO_INCREMENT,
            `user` varchar(6000) NOT NULL,
            `password` varchar(150) NOT NULL,
            `password_salt` varchar(10000) NOT NULL,
            `user_type` varchar(30) NOT NULL,
            `user_icon` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1"
    );

    public static function init() {
        foreach (self::$install_querys AS $query) {
            database::query($query);
        }
    }
}

install_build_cms_001::init();