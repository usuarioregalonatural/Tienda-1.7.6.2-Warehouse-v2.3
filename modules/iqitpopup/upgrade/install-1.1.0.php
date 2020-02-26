<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_1_0($object)
{

    $delay = 0;
    $delay = (int)Configuration::get($object->config_name . '_pop_delay');


    Configuration::updateValue($object->config_name . '_pop_delay', $delay * 1000);
    $object->generateCss(true);

	return true;
}
