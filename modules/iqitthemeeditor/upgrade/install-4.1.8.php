<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_8($object)
{
    Configuration::updateValue($object->cfgName . 'typo_material', 0);

    $font = Configuration::get($object->cfgName . 'typo_bfont_size');
    Configuration::updateValue($object->cfgName . 'msm_typo', '{"size":"'.$font.'","bold":null,"italic":null,"uppercase":null,"spacing":"0"}');
    return true;
}
