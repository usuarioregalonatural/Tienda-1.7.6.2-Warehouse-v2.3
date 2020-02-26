<?php
/**
 * 2019 Anvanto
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author Anvanto (anvantoco@gmail.com)
 *  @copyright  2019 anvanto.com

 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

$sql = array();

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields` (
      `id_an_productfields` int(10) unsigned NOT NULL auto_increment,
      `code` varchar(255) NOT NULL,
      `placeholder` varchar(255) NOT NULL,
      `price` decimal(12,2) NOT NULL,
      `type` enum("' . implode('", "', AnProductFields::getTypes()) . '") NOT NULL,
      `is_enabled` int(10) NOT NULL default "0",
      `apply_for_all_products` int(1) NOT NULL default "0",
      `sort_order` int(10) NOT NULL default "0",
      `required` int(1) NOT NULL default "0",
      `validation` varchar(255) NOT NULL,
      `groups` text NOT NULL,
      `categories` text,
      `max_text_length` int(10) NOT NULL,
      `date_add` datetime NOT NULL,
      `date_upd` datetime NOT NULL,
      PRIMARY KEY  (`id_an_productfields`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields_lang` (
      `id_an_productfields` int(10) unsigned NOT NULL,
      `id_lang` int(10) unsigned NOT NULL,
      `name` varchar(255) NOT NULL,
      `values` text NOT NULL,
      PRIMARY KEY (`id_an_productfields`,`id_lang`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields_shop` (
      `id_an_productfields` int(10) unsigned NOT NULL,
      `id_shop` int(10) unsigned NOT NULL,
      PRIMARY KEY (`id_an_productfields`, `id_shop`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields_product` (
      `id_an_productfields` int(10) unsigned NOT NULL,
      `id_product` int(10) unsigned NOT NULL,
      `position` int(10) unsigned NOT NULL,
      `is_enabled` int(10) unsigned NOT NULL,
      PRIMARY KEY (`id_an_productfields`,`id_product`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields_cart` (
      `id_an_productfields` int(10) unsigned NOT NULL,
      `id_cart` int(10) unsigned NOT NULL,
      `id_product` int(10) unsigned NOT NULL,
      `id_product_attribute` int(10) unsigned NOT NULL,
      `values_hash` varchar(50) NOT NULL,
      `field_name` varchar(50) NOT NULL,
      `field_type` varchar(50) NOT NULL,
      `price` varchar(50) NOT NULL,
      `value` text NOT NULL,
      PRIMARY KEY (`id_an_productfields`, `id_cart`, `id_product`, `id_product_attribute`, `values_hash`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

$sql[] = '
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_productfields_cart_values` (
      `values_hash` varchar(50) NOT NULL,
      `qty` int(10) unsigned NOT NULL,
      PRIMARY KEY (`values_hash`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';
