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

use Logeecom\Infrastructure\Configuration\Configuration;
use Logeecom\Infrastructure\ServiceRegister;
use Packlink\PrestaShop\Classes\Utility\PacklinkPrestaShopUtility;

/** @noinspection PhpIncludeInspection */
require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

class OrderStateMappingController extends PacklinkBaseController
{
    /**
     * Retrieves order status mappings.
     */
    public function displayAjaxGetMappings()
    {
        /** @var \Packlink\PrestaShop\Classes\BusinessLogicServices\ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $mappings = $configService->getOrderStatusMappings();

        $mappings = $mappings ?: array();

        PacklinkPrestaShopUtility::dieJson($mappings);
    }

    /**
     * Saves order status mappings.
     */
    public function displayAjaxSaveMappings()
    {
        $data = PacklinkPrestaShopUtility::getPacklinkPostData();
        /** @var \Packlink\PrestaShop\Classes\BusinessLogicServices\ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $configService->setOrderStatusMappings($data);

        PacklinkPrestaShopUtility::dieJson();
    }

    /**
     * Retrieves all order statuses that are present in Prestashop.
     */
    public function displayAjaxGetSystemOrderStatuses()
    {
        $result = array();
        $states = OrderState::getOrderStates($this->context->language->id);

        foreach ($states as $state) {
            $result[] = array('code' => $state['id_order_state'], 'label' => $state['name']);
        }

        PacklinkPrestaShopUtility::dieJson($result);
    }
}
