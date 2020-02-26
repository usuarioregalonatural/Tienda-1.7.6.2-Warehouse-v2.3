<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2016 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_1_0($object)
{
    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'simpleblog_post_lang` ADD video_code TEXT AFTER content');
    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'simpleblog_post_lang` ADD external_url TEXT AFTER video_code');

    $sql = array();

    $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'simpleblog_post_image` (
        `id_simpleblog_post_image` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
        `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL,
        `position` int(10) UNSIGNED NOT NULL,
        `image` varchar(255) NOT NULL,
        PRIMARY KEY (`id_simpleblog_post_image`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

    $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'simpleblog_post_product` (
        `id_simpleblog_post` INT( 11 ) UNSIGNED NOT NULL,
        `id_product` INT( 11 ) UNSIGNED NOT NULL,
        PRIMARY KEY (`id_simpleblog_post`,`id_product`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

    /*
        
        DB

    **/
    foreach ($sql as $s) {
        if (!Db::getInstance()->Execute($s)) {
            return false;
        }
    }

    return true;
}
