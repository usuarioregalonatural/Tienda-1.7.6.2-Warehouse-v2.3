<?php
/**
 * 2007-2015 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2007-2015 IQIT-COMMERCE.COM
 *  @license   GNU General Public License version 2
 *
 * You can not resell or redistribute this software.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_1_5($object)
{

    $object->registerHook('registerGDPRConsent');
    $object->registerHook('isJustElementor');

    $colExist = Db::getInstance()->executeS("SHOW COLUMNS FROM `"._DB_PREFIX_."iqit_elementor_category` LIKE 'just_elementor'");

    if(!$colExist){
        Db::getInstance()->execute('ALTER TABLE '._DB_PREFIX_.'iqit_elementor_category ADD `just_elementor` int(10) UNSIGNED default NULL AFTER `id_category`');
    }

    Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqit_elementor_category` (
  `id_elementor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` int(10) UNSIGNED NOT NULL,
  `just_elementor` int(10) UNSIGNED default NULL,
  PRIMARY KEY (`id_elementor`, `id_category`)
  ) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;
    ');


    Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqit_elementor_category_lang` (
  `id_elementor` int(10) UNSIGNED NOT NULL,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `data` longtext default NULL,
  PRIMARY KEY (`id_elementor`, `id_lang`)
  ) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;');


    $sql = "DROP TABLE IF EXISTS
			`PREFIXiqit_elementor_category`,
			`PREFIXiqit_elementor_category_lang`";

   Db::getInstance()->execute($sql);


    return true;
}
