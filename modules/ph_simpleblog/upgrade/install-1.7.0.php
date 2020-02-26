<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_7_0($module)
{
    // migrate tabs for PrestaShop 1.7 new way (fix permission issues)
    if ($module->is_17) {
        $module->myDeleteModuleTabs();
        $module->createAllModuleTabs();
    }

    if ($module->is_16) {
        $module->myInstallModuleTab(
            $module->l('Authors'),
            'AdminSimpleBlogAuthors',
            (int) Tab::getIdFromClassName('AdminSimpleBlog')
        );
    }

    $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_author` (
            `id_simpleblog_author` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `firstname` VARCHAR(60) NOT NULL,
            `lastname` VARCHAR(60) NOT NULL,
            `photo` TEXT NOT NULL,
            `email` VARCHAR(130) NOT NULL,
            `facebook` TEXT NOT NULL,
            `google` TEXT NOT NULL,
            `linkedin` TEXT NOT NULL,
            `twitter` TEXT NOT NULL,
            `instagram` TEXT NOT NULL,
            `phone` TEXT NOT NULL,
            `www` VARCHAR(255) NOT NULL,
            `active` tinyint(1) unsigned NOT NULL,
            PRIMARY KEY (`id_simpleblog_author`)
        ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

    $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'simpleblog_author_lang` (
                `id_simpleblog_author` int(10) UNSIGNED NOT NULL,
                `id_lang` INT( 11 ) UNSIGNED NOT NULL,
                `bio` TEXT NOT NULL,
                `additional_info` TEXT NOT NULL,
                PRIMARY KEY (`id_simpleblog_author`,`id_lang`)
            ) ENGINE = ' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

    foreach ($sql as $s) {
        if (!Db::getInstance()->Execute($s)) {
            return false;
        }
    }

    Configuration::updateGlobalValue('PH_BLOG_NEW_AUTHORS', '0');
    Configuration::updateGlobalValue('PH_BLOG_AUTHOR_INFO', '1');

    if ($module->is_16) {
        $themes = Theme::getThemes();
        $theme_meta_value = array();
        foreach ($module->controllers as $controller) {
            $page = 'module-'.$module->name.'-'.$controller;
            $result = Db::getInstance()->getValue('SELECT * FROM '._DB_PREFIX_.'meta WHERE page="'.pSQL($page).'"');
            if ((int) $result > 0) {
                continue;
            }

            $meta = new Meta();
            $meta->page = $page;
            $meta->configurable = 0;
            $meta->save();
            if ((int) $meta->id > 0) {
                foreach ($themes as $theme) {
                    $theme_meta_value[] = array(
                        'id_theme' => $theme->id,
                        'id_meta' => $meta->id,
                        'left_column' => false,
                        'right_column' => false,
                    );
                }
            } else {
                $module->_errors[] = sprintf(Tools::displayError('Unable to install controller: %s'), $controller);
            }
        }
        if (count($theme_meta_value) > 0) {
            return Db::getInstance()->insert('theme_meta', $theme_meta_value);
        }
    } else {
        foreach ($module->controllers as $controller) {
            $page = 'module-' . $module->name . '-' . $controller;
            $result = Db::getInstance()->getValue('SELECT * FROM ' . _DB_PREFIX_ . 'meta WHERE page="' . pSQL($page) . '"');
            if ((int) $result > 0) {
                continue;
            }

            $meta = new Meta();
            $meta->page = $page;
            $meta->configurable = 0;
            $meta->save();
        }
    } 

    return true;
}
