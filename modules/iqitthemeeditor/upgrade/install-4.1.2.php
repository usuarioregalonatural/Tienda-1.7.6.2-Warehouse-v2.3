<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_1_2($object)
{
    Configuration::updateValue($object->cfgName . 'cw_index_padding_tb', Configuration::get($object->cfgName . 'cw_padding_tb'));
    $object->setCachedOptions();
    $object::clearAssetsCache();

    $hook_name = 'displayHeaderButtons';

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
