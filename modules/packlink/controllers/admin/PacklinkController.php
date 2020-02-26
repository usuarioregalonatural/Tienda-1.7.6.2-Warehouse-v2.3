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

/**
 * Class PacklinkController
 *
 * This controller is used to add Packlink PRO menu item to admin dashboard.
 */
class PacklinkController extends ModuleAdminController
{
    /**
     * PacklinkController constructor.
     *
     * @throws \PrestaShopException
     */
    public function __construct()
    {
        parent::__construct();

        Tools::redirectAdmin(
            Context::getContext()->link->getAdminLink('AdminModules')
            . '&configure=' . $this->module->name . '&tab_module=shipping_logistics&module_name=' . $this->module->name
        );
    }
}
