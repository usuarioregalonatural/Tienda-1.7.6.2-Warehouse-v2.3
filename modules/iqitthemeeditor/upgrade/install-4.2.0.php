<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_4_2_0($object)
{	
	Configuration::updateValue($object->cfgName . 'lp_alert_s_bg', '');
    Configuration::updateValue($object->cfgName . 'lp_alert_s_txt', '');

    Configuration::updateValue($object->cfgName . 'lp_alert_i_bg', '');
    Configuration::updateValue($object->cfgName . 'lp_alert_i_txt', '');

    Configuration::updateValue($object->cfgName . 'lp_alert_w_bg', '');
    Configuration::updateValue($object->cfgName . 'lp_alert_w_txt', '');

    Configuration::updateValue($object->cfgName . 'lp_alert_d_bg', '');
    Configuration::updateValue($object->cfgName . 'lp_alert_d_txt', '');

    return true;
}
