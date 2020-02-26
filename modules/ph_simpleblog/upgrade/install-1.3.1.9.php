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

function upgrade_module_1_3_1_9($object)
{
    Configuration::updateGlobalValue('PH_BLOG_LOAD_FONT_AWESOME', 1);
    Configuration::updateGlobalValue('PH_BLOG_LOAD_BXSLIDER', 1);
    Configuration::updateGlobalValue('PH_BLOG_LOAD_MASONRY', 1);
    Configuration::updateGlobalValue('PH_BLOG_LOAD_FITVIDS', 1);

    return true;
}
