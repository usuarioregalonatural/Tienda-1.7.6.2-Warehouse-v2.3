<?php
/**
 * 2020 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2020 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 */

use Packlink\PrestaShop\Classes\Bootstrap;
use Packlink\PrestaShop\Classes\Utility\PacklinkInstaller;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrades module to version 2.0.5.
 *
 * @param \Packlink $module
 *
 * @return bool
 *
 * @throws \PrestaShopException
 * @throws \PrestaShop\PrestaShop\Adapter\CoreException
 */
function upgrade_module_2_0_5($module)
{
    $previousShopContext = \Shop::getContext();
    \Shop::setContext(\Shop::CONTEXT_ALL);

    Bootstrap::init();

    $installer = new PacklinkInstaller($module);
    $installer->addController('PacklinkAutoTest');
    $installer->addController('PacklinkAutoConfigure');

    $module->enable();

    \Shop::setContext($previousShopContext);

    return true;
}
