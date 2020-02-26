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

function upgrade_module_1_0_9($object)
{
    return Configuration::updateValue('PH_BLOG_THUMB_METHOD', '1')
            && Configuration::updateValue('PH_BLOG_THUMB_X', '400')
            && Configuration::updateValue('PH_BLOG_THUMB_Y', '200')
            && Configuration::updateValue('PH_BLOG_THUMB_X_WIDE', '800')
            && Configuration::updateValue('PH_BLOG_THUMB_Y_WIDE', '250');
}
