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

function upgrade_module_1_3_0_1($object)
{
    @unlink(_PS_MODULE_DIR_.'ph_simpleblog/assets/index.php');
    @unlink(_PS_MODULE_DIR_.'ph_simpleblog/assets/phpthumb/index.php');
    @unlink(_PS_MODULE_DIR_.'ph_simpleblog/assets/phpthumb/thumb_plugins/index.php');

    return true;
}
