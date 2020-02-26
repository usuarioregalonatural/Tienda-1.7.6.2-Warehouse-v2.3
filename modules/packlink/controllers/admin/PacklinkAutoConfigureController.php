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

use Packlink\BusinessLogic\Controllers\AutoConfigurationController;
use Packlink\PrestaShop\Classes\Utility\PacklinkPrestaShopUtility;

/** @noinspection PhpIncludeInspection */
require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

/**
 * Class PacklinkAutoConfigureController.
 */
class PacklinkAutoConfigureController extends PacklinkBaseController
{
    /**
     * Starts the auto-configuration.
     */
    public function initContent()
    {
        $controller = new AutoConfigurationController();

        PacklinkPrestaShopUtility::dieJson(array('success' => $controller->start(true)));
    }
}
