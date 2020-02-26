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

function upgrade_module_1_7_0($module)
{
    try {
        Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent` (
              `id_whatsappchatblock_agent` int(11) NOT NULL AUTO_INCREMENT,
              `id_whatsappchatblock` int(11) NOT NULL,
              `name` varchar(150) NOT NULL,
              `mobile_phone` varchar(32) NULL DEFAULT "",
              `image` varchar(150) NULL,
              `position` INT(5) NULL DEFAULT "0",
              `active` int(1) NOT NULL DEFAULT 0,
              PRIMARY KEY (`id_whatsappchatblock_agent`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );
        Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent_lang` (
              `id_whatsappchatblock_agent` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `department` text,
              KEY `id_whatsappchatblock_id_lang` (`id_whatsappchatblock_agent`,`id_lang`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );
    } catch (Exception $e) {
        return true;
    }
    return $module;
}
