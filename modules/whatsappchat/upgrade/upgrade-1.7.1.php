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

function upgrade_module_1_7_1($module)
{
    $moduleTab = array(
        'tabClassName' => 'AdminWhatsappChatAgent',
        'tabParentName' => '',
        'tabName' => $module->l('WhatsApp Chat Agents'),
    );

    $id_tab = Tab::getIdFromClassName($moduleTab['tabClassName']);
    if (!$id_tab) {
        $tab = new Tab();
        $tab->class_name = $moduleTab['tabClassName'];
        if ($moduleTab['tabParentName']) {
            $tab->id_parent = Tab::getIdFromClassName($moduleTab['tabParentName']);
        } else {
            $tab->id_parent = -1;
        }

        $tab->module = $module->name;

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $moduleTab['tabName'];
        }

        $tab->add();
    }
    return $module;
}
