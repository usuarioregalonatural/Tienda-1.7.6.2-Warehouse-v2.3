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

function upgrade_module_1_2_2_0($object)
{
    Shop::setContext(Shop::CONTEXT_ALL);

    $sql = array();

    /*
        
        AUTHORS

    **/
    // $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_author` (
 //            `id_simpleblog_author` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
 //            `firstname` VARCHAR(60) NOT NULL,
 //            `lastname` VARCHAR(60) NOT NULL,
 //            `email` VARCHAR(60) NOT NULL,
 //            `bio` TEXT NOT NULL,
 //            `www` VARCHAR(255) NOT NULL,
 //            `facebook` TEXT NOT NULL,
 //            `google` TEXT NOT NULL,
 //            `linkedin` TEXT NOT NULL,
 //            `twitter` TEXT NOT NULL,
 //            PRIMARY KEY (`id_simpleblog_author`)
 //        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

    // Only for PrestaShop 1.6...
    // $tab = new Tab()

    // $tab->name = array();
    // foreach (Language::getLanguages(true) as $lang)
    //     $tab->name[$lang['id_lang']] = $object->l('Authors');

    // $tab->class_name = 'AdminSimpleBlogAuthors';
    // $tab->id_parent = Tab::getIdFromClassName('AdminSimpleBlog');
    // $tab->module = $object->name;
    // $tab->add();

    Configuration::updateGlobalValue('PH_BLOG_NEW_AUTHORS', '0');
    Configuration::updateGlobalValue('PH_BLOG_AUTHOR_INFO', '1');

    /*
        
        COMMENTS

    **/
    $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'simpleblog_comment` (
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
        ) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

    $tab = new Tab();

    $tab->name = array();
    foreach (Language::getLanguages(true) as $lang) {
        $tab->name[$lang['id_lang']] = $object->l('Comments');
    }

    $tab->class_name = 'AdminSimpleBlogComments';
    $tab->id_parent = Tab::getIdFromClassName('AdminSimpleBlog');
    $tab->module = $object->name;
    $tab->add();

    Configuration::updateGlobalValue('PH_BLOG_NATIVE_COMMENTS', '0');
    Configuration::updateGlobalValue('PH_BLOG_COMMENT_NOTIFICATIONS', '0');

    /*
        
        NEW STYLE OF POSTS ACCESS

    **/
    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'simpleblog_post` ADD access TEXT NOT NULL AFTER is_featured');
    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'simpleblog_post` ADD id_simpleblog_author INT( 11 ) UNSIGNED NOT NULL DEFAULT 0 AFTER id_simpleblog_category');

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
