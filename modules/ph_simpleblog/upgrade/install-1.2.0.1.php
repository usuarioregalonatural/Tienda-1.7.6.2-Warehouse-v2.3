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

function upgrade_module_1_2_0_1($object)
{
    Configuration::updateGlobalValue('PH_CATEGORY_IMAGE_X', '535');
    Configuration::updateGlobalValue('PH_CATEGORY_IMAGE_Y', '150');

    return true;
}
