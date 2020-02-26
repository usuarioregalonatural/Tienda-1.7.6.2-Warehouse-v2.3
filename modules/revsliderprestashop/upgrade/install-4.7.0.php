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

function upgrade_module_4_7_0($object)
{
    //	$sql1 ='ALTER TABLE `'._DB_PREFIX_.'revslider_sliders` ADD `settings` MEDIUMTEXT NOT NULL AFTER `params`, ADD `type` VARCHAR(191) NOT NULL AFTER `settings`;';
//
//        Db::getInstance()->execute($sql1);
//        $sql2 ='CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'revslider_navigations` (
//	  `id` int(9) NOT NULL,
//	  `name` varchar(191) NOT NULL,
//	  `handle` varchar(191) NOT NULL,
//	  `css` longtext NOT NULL,
//	  `markup` longtext NOT NULL,
//	  `settings` longtext NOT NULL
//	) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;';
//
//	Db::getInstance()->execute($sql2);

    
    return true;
}
