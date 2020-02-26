<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_3_2($object)
{

    Configuration::updateValue($object->cfgName . 'pp_price_position', 'below-title');

    $object->setCachedOptions();

    return true;
}
