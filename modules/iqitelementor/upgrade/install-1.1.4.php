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

function upgrade_module_1_1_4($object)
{
    Configuration::updateValue('iqit_elementor_cache', 0);

    $object->registerHook('actionObjectManufacturerUpdateAfter');
    $object->registerHook('actionObjectManufacturerDeleteAfter');
    $object->registerHook('actionObjectManufacturerAddAfter');
    $object->registerHook('actionObjectProductUpdateAfter');
    $object->registerHook('actionObjectProductDeleteAfter');
    $object->registerHook('actionObjectProductAddAfter');
    $object->registerHook('displayCategoryElementor');
    $object->registerHook('actionObjectCategoryUpdateAfter');
    $object->registerHook('actionObjectCategoryAddAfter');
    $object->registerHook('actionObjectCategoryDeleteAfter');


    Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqit_elementor_category` (
  `id_elementor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_elementor`, `id_category`)
  ) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;
    ');


    Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqit_elementor_category_lang` (
  `id_elementor` int(10) UNSIGNED NOT NULL,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `data` longtext default NULL,
  PRIMARY KEY (`id_elementor`, `id_lang`)
  ) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;');


    return true;
}
