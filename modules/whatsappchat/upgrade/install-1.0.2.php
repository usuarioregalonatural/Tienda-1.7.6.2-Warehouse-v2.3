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

function upgrade_module_1_0_2($module)
{
    $result = true;

    $result &= Db::getInstance()->execute(
        'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock` (
          `id_whatsappchatblock` int(11) NOT NULL AUTO_INCREMENT,
          `id_shop` int(10) NOT NULL,
          `id_hook` varchar(150) NOT NULL,
          `open_chat` tinyint(1) NOT NULL,
          `position` varchar(150) NOT NULL,
          PRIMARY KEY (`id_whatsappchatblock`),
          KEY `id_shop_id_hook` (`id_shop`,`id_hook`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );

    $result &= Db::getInstance()->execute(
        'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_lang` (
          `id_whatsappchatblock` int(11) NOT NULL,
          `id_lang` int(11) NOT NULL,
          `message` text,
          PRIMARY KEY (`id_whatsappchatblock`,`id_lang`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );

     $result &= $module->registerHook('header')
        && $module->registerHook('footer')
        && $module->registerHook('leftColumn')
        && $module->registerHook('rightColumn')
        && $module->registerHook('top')
        && $module->registerHook('home')
        && $module->registerHook('shoppingCart')
        && $module->registerHook('shoppingCartExtra')
        && $module->registerHook('paymentTop')
        && $module->registerHook('beforeCarrier')
        && $module->registerHook('customerAccount')
        && $module->registerHook('myAccountBlock')
        && $module->registerHook('orderConfirmation')
        && $module->registerHook('orderDetail');

    if (version_compare(_PS_VERSION_, '1.5', '>=')) {
        $result &= $module->registerHook('displayBanner')
            && $module->registerHook('displayTopColumn')
            && $module->registerHook('displayNav')
            && $module->registerHook('displayproductButtons')
            && $module->registerHook('displayLeftColumnProduct')
            && $module->registerHook('displayRightColumnProduct')
            && $module->registerHook('displayFooterProduct')
            && $module->registerHook('displayShoppingCartFooter')
            && $module->registerHook('displayCustomerAccountForm')
            && $module->registerHook('displayCustomerAccountFormTop')
            && $module->registerHook('displayCustomerIdentityForm')
            && $module->registerHook('displayMyAccountBlockfooter')
            && $module->registerHook('displayMaintenance');
    } else {
        $result &= $module->registerHook('extraLeft')
            && $module->registerHook('extraRight')
            && $module->registerHook('productActions')
            && $module->registerHook('productfooter');
    }

    $result &= Db::getInstance()->execute(
        "INSERT INTO `"._DB_PREFIX_."whatsappchatblock` (`id_whatsappchatblock`, `id_shop`, `id_hook`, `open_chat`, `position`)
        VALUES (1, 1, 'badge', 1, 'bottom-right')"
    );

    $languages = Language::getLanguages(false);
    foreach ($languages as $lang) {
        if (Configuration::get('WHATSAPP_TAB_MESSAGE', $lang['id_lang'])) {
            $result &= Db::getInstance()->execute(
                "INSERT INTO `"._DB_PREFIX_."whatsappchatblock_lang` (`id_whatsappchatblock`, `id_lang`, `message`)
                VALUES (1, ".(int)$lang['id_lang'].", '".pSQL(Configuration::get('WHATSAPP_TAB_MESSAGE', $lang['id_lang']))."');"
            );
        }

        $result &= Db::getInstance()->execute(
            "UPDATE `"._DB_PREFIX_."configuration`
            SET `name` = 'WA_CHAT_MESSAGE'
            WHERE `name` = 'WHATSAPP_CHAT_MESSAGE'"
        );

        $result &= Db::getInstance()->execute(
            "UPDATE `"._DB_PREFIX_."configuration`
            SET `name` = 'WA_CHAT_MOBILE'
            WHERE `name` = 'WHATSAPP_CHAT_MOBILE'"
        );

        $result &= Db::getInstance()->execute(
            "UPDATE `"._DB_PREFIX_."configuration`
            SET `name` = 'WA_FONT_AWESOME'
            WHERE `name` = 'WHATSAPP_FONT_AWESOME'"
        );
    }

    $result &= $module->installTabs();

    return $result;
}
