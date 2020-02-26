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

namespace Packlink\PrestaShop\Classes;

/** @noinspection PhpIncludeInspection */
require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

use Logeecom\Infrastructure\Configuration\ConfigEntity;
use Logeecom\Infrastructure\Http\CurlHttpClient;
use Logeecom\Infrastructure\Http\HttpClient;
use Logeecom\Infrastructure\Logger\Interfaces\ShopLoggerAdapter;
use Logeecom\Infrastructure\Logger\LogData;
use Logeecom\Infrastructure\ORM\RepositoryRegistry;
use Logeecom\Infrastructure\Serializer\Concrete\NativeSerializer;
use Logeecom\Infrastructure\Serializer\Serializer;
use Logeecom\Infrastructure\ServiceRegister;
use Logeecom\Infrastructure\TaskExecution\Process;
use Logeecom\Infrastructure\TaskExecution\QueueItem;
use Packlink\BusinessLogic\BootstrapComponent;
use Packlink\BusinessLogic\Configuration;
use Packlink\BusinessLogic\Order\Interfaces\OrderRepository as OrderRepositoryInterface;
use Packlink\BusinessLogic\Order\Models\OrderShipmentDetails;
use Packlink\BusinessLogic\Scheduler\Models\Schedule;
use Packlink\BusinessLogic\ShippingMethod\Interfaces\ShopShippingMethodService;
use Packlink\BusinessLogic\ShippingMethod\Models\ShippingMethod;
use Packlink\PrestaShop\Classes\BusinessLogicServices\CarrierService;
use Packlink\PrestaShop\Classes\BusinessLogicServices\ConfigurationService;
use Packlink\PrestaShop\Classes\Entities\CarrierServiceMapping;
use Packlink\PrestaShop\Classes\Entities\CartCarrierDropOffMapping;
use Packlink\PrestaShop\Classes\InfrastructureServices\LoggerService;
use Packlink\PrestaShop\Classes\Repositories\BaseRepository;
use Packlink\PrestaShop\Classes\Repositories\OrderRepository;
use Packlink\PrestaShop\Classes\Repositories\QueueItemRepository;

/**
 * Class Bootstrap
 *
 * @package Packlink\PrestaShop\Classes
 */
class Bootstrap extends BootstrapComponent
{
    /**
     * Initializes infrastructure services and utilities.
     */
    protected static function initServices()
    {
        parent::initServices();

        ServiceRegister::registerService(
            Serializer::CLASS_NAME,
            function () {
                return new NativeSerializer();
            }
        );

        ServiceRegister::registerService(
            ShopLoggerAdapter::CLASS_NAME,
            function () {
                return LoggerService::getInstance();
            }
        );

        ServiceRegister::registerService(
            Configuration::CLASS_NAME,
            function () {
                return ConfigurationService::getInstance();
            }
        );

        ServiceRegister::registerService(
            ShopShippingMethodService::CLASS_NAME,
            function () {
                return new CarrierService();
            }
        );

        ServiceRegister::registerService(
            HttpClient::CLASS_NAME,
            function () {
                return new CurlHttpClient();
            }
        );

        ServiceRegister::registerService(
            OrderRepositoryInterface::CLASS_NAME,
            function () {
                return new OrderRepository();
            }
        );
    }

    /**
     * Initializes repositories.
     *
     * @throws \Logeecom\Infrastructure\ORM\Exceptions\RepositoryClassException
     */
    protected static function initRepositories()
    {
        RepositoryRegistry::registerRepository(Process::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(ConfigEntity::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(QueueItem::CLASS_NAME, QueueItemRepository::getClassName());
        RepositoryRegistry::registerRepository(ShippingMethod::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(CarrierServiceMapping::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(OrderShipmentDetails::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(Schedule::CLASS_NAME, BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(
            CartCarrierDropOffMapping::getClassName(),
            BaseRepository::getClassName()
        );
        RepositoryRegistry::registerRepository(LogData::CLASS_NAME, BaseRepository::getClassName());
    }
}
