<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_4($object)
{
    Configuration::updateValue($object->cfgName . 'pl_infinity', 0);
    Configuration::updateValue($object->cfgName . 'pl_grid_brand', 0);
    Configuration::updateValue($object->cfgName . 'rm_address_bg', '');
    Configuration::updateValue($object->cfgName . 'rm_address_bg', '');
    Configuration::updateValue($object->cfgName . 'bread_bg_category', 0);
    $object->setCachedOptions();

	return true;
}
