<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_1_1($object)
{
    $object->registerHook('registerGDPRConsent');

	return true;
}
