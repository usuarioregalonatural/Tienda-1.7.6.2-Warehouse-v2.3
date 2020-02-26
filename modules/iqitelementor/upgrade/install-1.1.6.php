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

function upgrade_module_1_1_6($object)
{


    $object->registerHook('actionObjectSimpleBlogPostAddAfter');

    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'iqit_elementor_landing`
	CHANGE COLUMN `id_page` `id_iqit_elementor_landing` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST');

    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'iqit_elementor_landing_lang`
	CHANGE COLUMN `id_page` `id_iqit_elementor_landing` INT(10) UNSIGNED NOT NULL FIRST');


    return true;
}
