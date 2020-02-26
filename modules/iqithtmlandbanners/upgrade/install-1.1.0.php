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

function upgrade_module_1_1_0($object)
{
    $sql = 'SELECT bc.`id_iqit_htmlandbanner` FROM `' . _DB_PREFIX_ . 'iqit_htmlandbanner` bc';
    $blocks = Db::getInstance()->executeS($sql);


    foreach ($blocks as $block){
        foreach (Shop::getShopsCollection() as $shop) {
            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'iqit_htmlandbanner_shop` (`id_iqit_htmlandbanner`, `id_shop`) 
            VALUES ('. $block['id_iqit_htmlandbanner'] .', ' . (int)$shop->id . ')');
        }
    }

    return true;
}
