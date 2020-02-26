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

/** @noinspection PhpUndefinedClassInspection */

/**
 * Class Order
 */
class Order extends OrderCore
{
    /**
     * @var string Link to order draft on Packlink.
     */
    public $packlink_order_draft;

    /**
     * @inheritdoc
     */
    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);

        $this->initializePacklinkHandler();
    }

    /**
     * Initializes Packlink module handler for extending order details page.
     */
    private function initializePacklinkHandler()
    {
        /** @noinspection PhpIncludeInspection */
        require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

        $column = Packlink\PrestaShop\Classes\Repositories\OrderRepository::PACKLINK_ORDER_DRAFT_FIELD;

        self::$definition['fields'][$column] = array(
            'type' => self::TYPE_STRING,
            'validate' => 'isUrl',
        );
        $this->webserviceParameters['fields'][$column] = array();
    }
}
