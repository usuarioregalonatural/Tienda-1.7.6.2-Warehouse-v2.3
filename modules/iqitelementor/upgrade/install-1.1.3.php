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

function upgrade_module_1_1_3($object)
{
    $object->registerHook('actionObjectSimpleBlogPostUpdateAfter');

    $id_tab = (int)Tab::getIdFromClassName('IqitElementorEditor');
    $tab = new Tab($id_tab);
    $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
    $tab->active = 0;
    $tab->update();
    return true;
}
