<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_5($object)
{
    Configuration::updateValue($object->cfgName . 'pl_grid_discount_value', 0);
    $object->setCachedOptions();

    $moduleDash = Module::getInstanceByName('iqitdashboardnews');
    if ($moduleDash instanceof Module) {
        $moduleDash->install();
    }

	return true;
}
