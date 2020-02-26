<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

include(dirname(__FILE__).'/../../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../../init.php');
include(dirname(__FILE__).'/../../whatsappchat.php');

if (Tools::isSubmit('method')) {
    switch (Tools::getValue('method')) {
        case 'getCustomerMobilePhone':
            if (Tools::getIsset('id_order') && $id_order = Tools::getValue('id_order')) {
                $order = new Order((int)$id_order);
                $id_customer = $order->id_customer;
            } else {
                $id_customer = Tools::getValue('id_customer');
            }
            $address_id = Address::getFirstCustomerAddressId((int)$id_customer, true);
            if ($address_id > 0) {
                $address = new Address((int)$address_id);
                $phone = $address->phone_mobile;
                if (!Validate::isPhoneNumber($phone) || $phone == '') {
                    $phone = $address->phone;
                    if (!Validate::isPhoneNumber($phone) || $phone == '') {
                        die(Tools::jsonEncode(array('whatsappchat_response' => array(
                            'code' => 'NOK',
                            'url'  => '',
                            'msg'  => 'Not a valid phone number or this customer has no mobile phone.'
                        )
                        )));
                    }
                }
                $module = new WhatsAppChat();
                $phone = $module->formatMobilePhoneForWhatsapp($phone, $address->id_country);
                die(Tools::jsonEncode(array('whatsappchat_response' => array(
                    'code' => 'OK',
                    'url'  => $module->getWhatsappUrl($phone),
                    'msg'  => ''
                )
                )));
            } else {
                die(Tools::jsonEncode(array('whatsappchat_response' => array(
                    'code' => 'NOK',
                    'url'  => '',
                    'msg'  => 'Not a valid phone number or this customer has no mobile phone.'
                )
                )));
            }
            break;
        default:
            break;
    }
}
