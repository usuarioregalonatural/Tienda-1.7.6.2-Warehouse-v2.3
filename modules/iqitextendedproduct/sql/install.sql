CREATE TABLE IF NOT EXISTS `PREFIXiqit_threesixty` (
  `id_threesixty` int(10) unsigned NOT NULL auto_increment,
  `id_product` INT(10) unsigned NOT NULL,
  `content` text default NULL,
  PRIMARY KEY (`id_threesixty`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIXiqit_productvideo` (
  `id_productvideo` int(10) unsigned NOT NULL auto_increment,
  `id_product` INT(10) unsigned NOT NULL,
  `content` text default NULL,
  PRIMARY KEY (`id_productvideo`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;
