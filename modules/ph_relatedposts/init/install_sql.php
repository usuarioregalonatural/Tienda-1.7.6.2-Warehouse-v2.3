<?php
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_related_post` (
            `id_simpleblog_related_post` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_simpleblog_post` INT( 11 ) unsigned NOT NULL,
            `id_product` INT( 11 ) unsigned NOT NULL,
            PRIMARY KEY (`id_simpleblog_related_post`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';



