<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_2_2($object)
{
    Configuration::updateValue($object->cfgName . 'sm_og_logo', '');
    Configuration::updateValue($object->cfgName . 'pl_faceted_slider_color', '');

    return true;
}
