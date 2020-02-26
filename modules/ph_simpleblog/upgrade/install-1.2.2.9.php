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

function upgrade_module_1_2_2_9($object)
{
    // Make sure that posts for logged only are properly assigned to new access system:
    $posts = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'simpleblog_post`');
    $available_groups = Group::getGroups(Context::getContext()->language->id);

    foreach ($posts as $post) {
        $post_access = array();

        if ($post['logged'] == 1) {
            foreach ($available_groups as $group) {
                if ($group['id_group'] == Configuration::get('PS_UNIDENTIFIED_GROUP') || $group['id_group'] == Configuration::get('PS_GUEST_GROUP')) {
                    $post_access[$group['id_group']] = false;
                } else {
                    $post_access[$group['id_group']] = true;
                }
            }
        } else {
            foreach ($available_groups as $group) {
                $post_access[$group['id_group']] = true;
            }
        }
        Db::getInstance()->update('simpleblog_post', array('access' => serialize($post_access)), 'id_simpleblog_post = '.$post['id_simpleblog_post']);
    }

    return true;
}
