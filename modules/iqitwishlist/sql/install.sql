CREATE TABLE IF NOT EXISTS `PREFIXiqitwishlist_product` (
  `id_iqitwishlist_product` int(10) NOT NULL auto_increment,
  `id_product` int(10) unsigned NOT NULL,
  `id_product_attribute` int(10) unsigned NOT NULL,
  `id_customer` int(10) unsigned NOT NULL,
  `id_shop` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_iqitwishlist_product`, `id_product` ,`id_product_attribute`, `id_customer`, `id_shop`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

