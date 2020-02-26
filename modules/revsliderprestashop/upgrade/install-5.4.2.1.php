<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.4.2
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_5_4_2_1($object)
{
     
    $revmodule = Module::getInstanceByName('revsliderprestashop'); 
     update_option('revslider-valid', 'true');
     $code = Configuration::get('revslider-code');
     update_option('revslider-code', $code); 
    return true;
}
