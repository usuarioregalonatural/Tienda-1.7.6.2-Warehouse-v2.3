<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_6($object)
{
    Configuration::updateValue($object->cfgName . 'pp_reference', 'details');
    Configuration::updateValue($object->cfgName . 'pp_man_desc', 0);
    Configuration::updateValue($object->cfgName . 'pp_preloader', 0);
    Configuration::updateValue($object->cfgName . 'rm_icon_apple', '');
    Configuration::updateValue($object->cfgName . 'rm_icon_android', '');

    $object->setCachedOptions();

    $hook_name = 'displayHeaderButtonsMobile';

    $id_hook = Hook::getIdByName($hook_name);
    // If hook does not exist, we create it
    if (!$id_hook) {
        $new_hook = new Hook();
        $new_hook->name = pSQL($hook_name);
        $new_hook->title = pSQL($hook_name);
        $new_hook->position = 1;
        $new_hook->add();
    }


	return true;
}
