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

function upgrade_module_1_9_0($module)
{
    try {
        Db::getInstance()->Execute(
            'alter table `'._DB_PREFIX_.'whatsappchatblock`
                change position pos varchar(150) null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add display_on int(2) unsigned default 0 null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add display_on_selection text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add filter_by_customer tinyint(1) unsigned default 0 null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add customers text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add countries text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add zones text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add languages text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add currencies text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add position int(4) unsigned default 0 null;
            alter table `'._DB_PREFIX_.'whatsappchatblock`
                add positions text null;
            alter table `'._DB_PREFIX_.'whatsappchatblock_agent`
                add schedule varchar(500) default "" null;'
        );
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $module->registerHook('displayProductButtons');
        } else {
            $module->registerHook('displayProductActions');
        }
        $module->registerHook('displayWhatsAppProductSocialButtons');
    } catch (Exception $e) {
        return true;
    }
    return $module;
}
