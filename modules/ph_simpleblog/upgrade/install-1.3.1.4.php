<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2016 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_1_4($object)
{
    $posts = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'simpleblog_post`');

    foreach ($posts as $post) {
        Db::getInstance()->update('simpleblog_post', array('id_simpleblog_post_type' => 1), 'id_simpleblog_post = '.$post['id_simpleblog_post']);
    }

    return true;
}
