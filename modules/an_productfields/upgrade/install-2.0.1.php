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

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_2_0_1($object, $install = false)
{
    $sql = array();

    $sql[] = '
      ALTER TABLE `' . _DB_PREFIX_ . 'an_productfields`
        ADD (`categories` text);
    ';

    $sql[] = '
      ALTER TABLE `' . _DB_PREFIX_ . 'an_productfields_cart`
        ADD (
          `field_name` varchar(50) NOT NULL,
          `field_type` varchar(50) NOT NULL,
          `price` varchar(50) NOT NULL);
    ';

    foreach ($sql as $_sql) {
        Db::getInstance()->Execute($_sql);
    }

    $sql = '
			SELECT pf.id_an_productfields, pf.code ,pf.type ,pf.price
			FROM `' . _DB_PREFIX_ . 'an_productfields_cart` pfc
			INNER JOIN `' . _DB_PREFIX_ . 'an_productfields` pf ON (pfc.`id_an_productfields` = pf.`id_an_productfields`)
			ORDER BY pf.`id_an_productfields`';

    $rows = Db::getInstance()->executeS($sql);

    foreach ($rows as $row) {
        Db::getInstance()->update(
            'an_productfields_cart',
            array('field_name' => pSQL($row['code']), 'field_type' => pSQL($row['type']), 'price' => (int)$row['price']),
            'id_an_productfields = \'' . (int)$row['id_an_productfields'] . '\''
        );
    }
    return true;
}
