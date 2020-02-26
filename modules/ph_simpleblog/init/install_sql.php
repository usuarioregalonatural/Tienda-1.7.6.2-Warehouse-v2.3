<?php
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post` (
            `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_simpleblog_category` INT( 11 ) UNSIGNED NOT NULL,
            `id_simpleblog_post_type` INT( 11 ) UNSIGNED NOT NULL,
            `id_simpleblog_author` INT( 11 ) UNSIGNED NOT NULL DEFAULT 0,
            `author` VARCHAR(60) NOT NULL,
            `likes` INT( 11 ) UNSIGNED NOT NULL DEFAULT 0,
            `views` INT( 11 ) UNSIGNED NOT NULL DEFAULT 0,
            `allow_comments` tinyint(1) UNSIGNED NOT NULL DEFAULT 3,
            `is_featured` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
            `access` TEXT NOT NULL,
            `cover` TEXT NOT NULL,
            `featured` TEXT NOT NULL,
            `id_product` TEXT NOT NULL,
            `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_simpleblog_post`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_lang` (
            `id_simpleblog_post` int(10) UNSIGNED NOT NULL,
            `id_lang` int(10) UNSIGNED NOT NULL,
            `title` varchar(255) NOT NULL,
            `meta_title` varchar(255) NOT NULL,
            `meta_description` varchar(255) NOT NULL,
            `meta_keywords` varchar(255) NOT NULL,
            `canonical` text NOT NULL,
            `short_content` longtext,
            `content` longtext,
            `video_code` text,
            `external_url` text,
            `link_rewrite` varchar(255) NOT NULL,
            PRIMARY KEY (`id_simpleblog_post`,`id_lang`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_shop` (
            `id_simpleblog_post` int(11) UNSIGNED NOT NULL,
            `id_shop` int(11) UNSIGNED NOT NULL,
            PRIMARY KEY (`id_simpleblog_post`,`id_shop`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_image` (
            `id_simpleblog_post_image` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL,
            `position` int(10) UNSIGNED NOT NULL,
            `image` varchar(255) NOT NULL,
            PRIMARY KEY (`id_simpleblog_post_image`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_product` (
            `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL,
            `id_product` INT( 11 ) UNSIGNED NOT NULL,
            PRIMARY KEY (`id_simpleblog_post`,`id_product`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_type` (
        `id_simpleblog_post_type` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255),
        `slug` VARCHAR(255),
        `description` TEXT,
        PRIMARY KEY (`id_simpleblog_post_type`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

# categories

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_category` (
            `id_simpleblog_category` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `cover` VARCHAR(5) NOT NULL,
            `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_parent` int(10) UNSIGNED NOT NULL DEFAULT 0,
            `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_simpleblog_category`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_category_lang` (
            `id_simpleblog_category` int(10) UNSIGNED NOT NULL,
            `id_lang` int(10) UNSIGNED NOT NULL,
            `name` varchar(128) NOT NULL,
            `description` text,
            `link_rewrite` varchar(128) NOT NULL,
            `meta_title` varchar(128) NOT NULL,
            `meta_keywords` varchar(255) NOT NULL,
            `canonical` text NOT NULL,
            `meta_description` varchar(255) NOT NULL,
            PRIMARY KEY (`id_simpleblog_category`,`id_lang`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_category_shop` (
            `id_simpleblog_category` int(11) UNSIGNED NOT NULL,
            `id_shop` int(11) UNSIGNED NOT NULL,
            PRIMARY KEY (`id_simpleblog_category`,`id_shop`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

# tags

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_tag` (
            `id_simpleblog_tag` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_lang` INT( 11 ) UNSIGNED NOT NULL,
            `name` VARCHAR(60) NOT NULL,
            PRIMARY KEY (`id_simpleblog_tag`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_tag` (
        `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL,
        `id_simpleblog_tag` INT( 11 ) UNSIGNED NOT NULL,
        PRIMARY KEY (`id_simpleblog_post`, `id_simpleblog_tag`),
        KEY (`id_simpleblog_tag`)
    ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_comment` (
        `id_simpleblog_comment` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
        `id_simpleblog_post` INT( 11 ) DEFAULT NULL,
        `id_parent` INT( 11 ) DEFAULT NULL,
        `id_customer` INT( 11 ) DEFAULT NULL,
        `id_guest` INT( 11 ) DEFAULT NULL,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `comment` text NOT NULL,
        `active` tinyint(1) unsigned NOT NULL,
        `ip` varchar(255) NOT NULL,
        `date_add` datetime NOT NULL,
        `date_upd` datetime NOT NULL,
        PRIMARY KEY (`id_simpleblog_comment`)
    ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_author` (
            `id_simpleblog_author` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `firstname` VARCHAR(60) NOT NULL,
            `lastname` VARCHAR(60) NOT NULL,
            `photo` TEXT NOT NULL,
            `email` VARCHAR(130) NOT NULL,
            `facebook` TEXT NOT NULL,
            `google` TEXT NOT NULL,
            `linkedin` TEXT NOT NULL,
            `twitter` TEXT NOT NULL,
            `instagram` TEXT NOT NULL,
            `phone` TEXT NOT NULL,
            `www` VARCHAR(255) NOT NULL,
            `active` tinyint(1) unsigned NOT NULL,
            PRIMARY KEY (`id_simpleblog_author`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_author_lang` (
            `id_simpleblog_author` int(10) UNSIGNED NOT NULL,
            `id_lang` INT( 11 ) UNSIGNED NOT NULL,
            `bio` TEXT NOT NULL,
            `additional_info` TEXT NOT NULL,
            PRIMARY KEY (`id_simpleblog_author`,`id_lang`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';
