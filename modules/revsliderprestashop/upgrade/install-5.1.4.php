<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.4
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_5_1_4()
{
    $revmodule = Module::getInstanceByName('revsliderprestashop');
    $revmodule->moduleControllerRegistration();
    return true;
}
