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

function upgrade_module_1_3_2_11($object)
{
    $themes = Theme::getThemes();
    $theme_meta_value = array();
    foreach ($object->controllers as $controller) {
        $page = 'module-'.$object->name.'-'.$controller;
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
                    'left_column' => (int) $theme->default_left_column,
                    'right_column' => (int) $theme->default_right_column,
                );
            }
        } else {
            $object->_errors[] = sprintf(Tools::displayError('Unable to install controller: %s'), $controller);
        }
    }
    if (count($theme_meta_value) > 0) {
        return Db::getInstance()->insert('theme_meta', $theme_meta_value);
    }

    return true;
}
