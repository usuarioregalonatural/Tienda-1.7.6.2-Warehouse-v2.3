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

use Packlink\PrestaShop\Classes\Utility\PacklinkPrestaShopUtility;
use Packlink\PrestaShop\Classes\Utility\SystemInfoUtility;

/** @noinspection PhpIncludeInspection */
require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

class DebugController extends PacklinkBaseController
{
    const SYSTEM_INFO_FILE_NAME = 'packlink-debug-data.zip';

    /**
     * Downloads system info zip file.
     *
     * @throws \PrestaShopException
     */
    public function displayAjaxGetSystemInfo()
    {
        $file = SystemInfoUtility::getSystemInfo();

        PacklinkPrestaShopUtility::dieFile($file, self::SYSTEM_INFO_FILE_NAME);
    }

    /**
     * Retrieves debug mode status.
     */
    public function displayAjaxGetStatus()
    {
        PacklinkPrestaShopUtility::dieJson(array('status' => $this->getConfigService()->isDebugModeEnabled()));
    }

    /**
     * Sets debug mode status.
     */
    public function displayAjaxSetStatus()
    {
        $data = PacklinkPrestaShopUtility::getPacklinkPostData();
        if (!isset($data['status']) || !is_bool($data['status'])) {
            PacklinkPrestaShopUtility::die400();
        }

        $this->getConfigService()->setDebugModeEnabled($data['status']);

        PacklinkPrestaShopUtility::dieJson(array('status' => $data['status']));
    }
}
