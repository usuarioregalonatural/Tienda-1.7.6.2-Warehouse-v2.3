CREATE TABLE IF NOT EXISTS `PREFIXiqitreviews_products` (
  `id_review` int(10) NOT NULL auto_increment,
  `id_product` int(10) unsigned NOT NULL,
  `id_customer` int(10) unsigned NULL,
  `id_guest` int(10) unsigned NULL,
  `customer_name` varchar(64) NULL,
  `title` varchar(64) NULL,
  `comment` text NOT NULL,
  `rating` float unsigned  NULL,
  `status` tinyint(1) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_review`),
  KEY `id_product` (`id_product`),
  KEY `id_customer` (`id_customer`),
  KEY `id_guest` (`id_guest`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;
