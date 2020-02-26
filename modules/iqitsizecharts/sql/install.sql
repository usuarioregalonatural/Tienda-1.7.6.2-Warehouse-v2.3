CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart` (
  `id_iqitsizechart` int(10) unsigned NOT NULL auto_increment,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart_lang` (
  `id_iqitsizechart` int(10) unsigned NOT NULL auto_increment,
  `id_lang` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`, `id_lang`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart_shop` (
  `id_iqitsizechart` int(10) unsigned NOT NULL auto_increment,
  `id_shop` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`, `id_shop`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart_product` (
  `id_iqitsizechart` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`, `id_product`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart_category` (
  `id_iqitsizechart` int(10) unsigned NOT NULL,
  `id_category` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`, `id_category`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqitsizechart_brand` (
  `id_iqitsizechart` int(10) unsigned NOT NULL,
  `id_manufacturer` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_iqitsizechart`, `id_manufacturer`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;