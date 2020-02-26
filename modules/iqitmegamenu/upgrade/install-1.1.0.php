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
    Configuration::updateValue('iqitmegamenu_hor_hook', 0);
    $object->registerHook('displayIqitMenu');

    Db::getInstance()->execute('ALTER TABLE `' . _DB_PREFIX_ . 'iqitmegamenu_tabs` ADD group_access TEXT NOT NULL AFTER submenu_border_i');

    $groups = Group::getGroups(Context::getContext()->language->id);

    $group_access = array();

    foreach ($groups as $group) {
        $group_access[$group['id_group']] = true;
    }
    $group_access = serialize($group_access);

    Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'iqitmegamenu_tabs` SET group_access = "' . $group_access . '" WHERE 1');
    Db::getInstance()->execute('RENAME TABLE  `' . _DB_PREFIX_ . 'iqitmegamenu` TO  `' . _DB_PREFIX_ . 'iqitmegamenu_tabs_shop`');

    return true;
}
