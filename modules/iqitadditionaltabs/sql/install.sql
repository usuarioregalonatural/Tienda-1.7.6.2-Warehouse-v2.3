CREATE TABLE IF NOT EXISTS `PREFIXiqitadditionaltab` (
  `id_iqitadditionaltab` int(10) unsigned NOT NULL auto_increment,
  `id_product` INT(10) unsigned NOT NULL,
  `position` INT(10) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitadditionaltab`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitadditionaltab_lang` (
  `id_iqitadditionaltab` int(10) unsigned NOT NULL auto_increment,
  `id_lang` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_iqitadditionaltab`, `id_lang`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitadditionaltab_shop` (
  `id_iqitadditionaltab` int(10) unsigned NOT NULL auto_increment,
  `id_shop` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitadditionaltab`, `id_shop`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;
