<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_1($object)
{
    Configuration::updateValue($object->cfgName . 'pp_man_logo', 'tab');
    Configuration::updateValue($object->cfgName . 'pl_grid_name_line', 0);
    $object->setCachedOptions();
    $object::clearAssetsCache();
	return true;
}
