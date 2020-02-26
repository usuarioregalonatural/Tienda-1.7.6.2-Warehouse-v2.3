<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2_0($object)
{
    Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitsizechart_brand` (
				`id_iqitsizechart` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_manufacturer` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_iqitsizechart`, `id_manufacturer`)
				) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

    $charts = IqitSizeChart::getCharts();

    foreach ($charts as $key => $chart) {
       Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'iqitsizechart_brand` (`id_iqitsizechart`, `id_manufacturer`)
			VALUES(' . (int)$chart['id_iqitsizechart']. ', 0)');
    }

	return true;
}
