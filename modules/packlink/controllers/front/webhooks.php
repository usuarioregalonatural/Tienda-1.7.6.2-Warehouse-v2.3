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

use Packlink\BusinessLogic\WebHook\WebHookEventHandler;
use Packlink\PrestaShop\Classes\Bootstrap;
use Packlink\PrestaShop\Classes\Utility\PacklinkPrestaShopUtility;

/** @noinspection AutoloadingIssuesInspection */

/**
 * Class PacklinkWebhooksModuleFrontController
 */
class PacklinkWebhooksModuleFrontController extends ModuleFrontController
{
    /**
     * PacklinkAsyncProcessModuleFrontController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        Bootstrap::init();
    }

    /**
     * Handles incoming Packlink webhook events.
     */
    public function initContent()
    {
        $input = \Tools::file_get_contents('php://input');

        $webhookHandler = WebHookEventHandler::getInstance();

        if (!$webhookHandler->handle($input)) {
            PacklinkPrestaShopUtility::die400(array('message' => 'Invalid payload'));
        }

        PacklinkPrestaShopUtility::dieJson(array('success' => true));
    }

    /**
     * Displays maintenance page if shop is closed.
     */
    public function displayMaintenancePage()
    {
        // allow async process in maintenance mode
    }

    /**
     * Displays 'country restricted' page if user's country is not allowed.
     */
    protected function displayRestrictedCountryPage()
    {
        // allow async process
    }
}
