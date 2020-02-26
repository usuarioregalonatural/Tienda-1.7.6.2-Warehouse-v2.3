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

function upgrade_module_1_0_7($object)
{
    Configuration::updateValue('PH_BLOG_COLUMNS', 'prestashop');
    Configuration::updateValue('PH_BLOG_LAYOUT', 'left_sidebar');
    Configuration::updateValue('PH_BLOG_LIST_LAYOUT', 'grid');
    Configuration::updateValue('PH_BLOG_GRID_COLUMNS', '2');
    Configuration::updateValue('PH_BLOG_MAIN_TITLE', 'Blog - what\'s new?');
    $object->registerHook('displayHeader');

    return true;
}
