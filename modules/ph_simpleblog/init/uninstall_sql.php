<?php
$sql = array();

# posts
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_lang`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_shop`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_image`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_product`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_type`';

# categories
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_category`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_category_lang`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_category_shop`';

# tags
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_tag`';

$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_post_tag`';

# comments
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_comment`';

# authors
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_author`';
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'simpleblog_author_lang`';
