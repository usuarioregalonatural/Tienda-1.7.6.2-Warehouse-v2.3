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

function upgrade_module_1_1_0($module)
{
    try {
        $blocks = Db::getInstance()->executeS(
            "SELECT `id_whatsappchatblock`, `mobile_phone` FROM `"._DB_PREFIX_."whatsappchatblock`;"
        );
        Db::getInstance()->execute(
            'ALTER TABLE `'._DB_PREFIX_.'whatsappchatblock_lang`
            ADD `mobile_phone` varchar(15) COLLATE "utf8_general_ci" NULL DEFAULT "";'
        );
        $languages = Language::getLanguages(false);
        foreach ($blocks as $block) {
            foreach ($languages as $lang) {
                Db::getInstance()->execute(
                    "UPDATE `"._DB_PREFIX_."whatsappchatblock_lang` SET `mobile_phone` = '".pSQL($block['mobile_phone'])."'
                    WHERE `id_whatsappchatblock` = ".(int)$block['id_whatsappchatblock']."
                    AND `id_lang` = ".(int)$lang['id_lang'].";"
                );
            }
        }
        Db::getInstance()->execute(
            'ALTER TABLE `'._DB_PREFIX_.'whatsappchatblock`
            ADD `customer_groups` varchar(60) COLLATE "utf8_general_ci" NULL DEFAULT "all",
            ADD `only_home` int(1) NOT NULL DEFAULT 0,
            ADD `chat_group` varchar(60) COLLATE "utf8_general_ci" NULL DEFAULT "",
            ADD `badge_width` int(3) NULL,
            DROP `mobile_phone`;'
        );
    } catch (Exception $e) {
        return true;
    }
    return $module;
}
