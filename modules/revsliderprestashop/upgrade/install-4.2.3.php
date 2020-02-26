<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}
// @codingStandardsIgnoreStart
//UPDATE `PREFIX_quick_access` SET `link` = 'index.php?controller=AdminCartRules&addcart_rule' WHERE `link` = 'index.php?tab=AdminDiscounts&adddiscount';
//index.php?controller=AdminModules&configure=revsliderprestashop&tab_module=front_office_features&module_name=revsliderprestashop
function upgrade_module_4_2_3($object)
{
    $qick_access = new QuickAccess();

    /* echo"<pre>";
      print_r($qick_access);
     */
    $qick_access->link = 'index.php?controller=AdminModules&configure=revsliderprestashop&tab_module=front_office_features&module_name=revsliderprestashop';
    $qick_access->new_window = false;

    $languages = Language::getLanguages(false);
    foreach ($languages as $language) {
        $qick_access->name[$language['id_lang']] = 'Revolution Slider';
    }
    $qick_access->add();
    moduleControllerRegistration();
    return true;
}

function moduleControllerRegistration()
{
    $tab = new Tab(null, Configuration::get('PS_LANG_DEAFULT'), Configuration::get('PS_SHOP_DEAFULT'));
    $tab->class_name = 'Revolutionslider_ajax';
    $tab->id_parent = 0;
    $tab->module = 'revsliderprestashop';
    $tab->name = "Revolutionslider Ajax Controller";
    $tab->position = 10;
    $tab->active = 0;
    $tab->add();
    if (!$tab->id) {
        return false;
    }
    Configuration::updateValue('REVOLUTION_CONTROLLER_TABS', Tools::jsonEncode(array($tab->id)));
    return true;
}
// @codingStandardsIgnoreEnd
