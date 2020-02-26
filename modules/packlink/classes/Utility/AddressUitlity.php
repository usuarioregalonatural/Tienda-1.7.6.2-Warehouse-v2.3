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

namespace Packlink\PrestaShop\Classes\Utility;

class AddressUitlity
{
    /**
     * Creates drop-off address for a specific order based on the provided drop-off data.
     *
     * @param \Order $order
     * @param array $dropOffData
     *
     * @throws \PrestaShopException
     */
    public static function createDropOffAddress($order, $dropOffData)
    {
        $address = new \Address($order->id_address_delivery);
        $clone = clone $address;
        $clone->id = null;
        $clone->id_customer = null;
        $clone->address1 = $dropOffData['address'];
        $clone->postcode = $dropOffData['zip'];
        $clone->city = $dropOffData['city'];
        $clone->company = $dropOffData['name'];
        $clone->alias = TranslationUtility::__('Drop-Off delivery address');
        $clone->other = TranslationUtility::__('Drop-Off delivery address');
        $clone->save();
        $order->id_address_delivery = $clone->id;

        $order->update();
    }
}
