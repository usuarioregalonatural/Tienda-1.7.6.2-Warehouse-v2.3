<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_0_3($object)
{
	$idTabs = array();
    $idTabs[] = Tab::getIdFromClassName('AdminSimpleBlogRelatedPosts');

    foreach ($idTabs as $idTab) {
        if ($idTab) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
    }
	return true;
}