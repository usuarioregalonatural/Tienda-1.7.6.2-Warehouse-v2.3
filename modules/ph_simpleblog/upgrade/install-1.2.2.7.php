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

function upgrade_module_1_2_2_7($object)
{
    Shop::setContext(Shop::CONTEXT_ALL);

    /*
        
        Possibility to set meta_title other then title

    **/

    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'simpleblog_post_lang` ADD title VARCHAR(255) NOT NULL AFTER id_lang');

    Db::getInstance()->query('UPDATE `'._DB_PREFIX_.'simpleblog_post_lang` spl, `'._DB_PREFIX_.'simpleblog_post_lang` spl2 SET spl.title = spl2.meta_title WHERE spl.id_simpleblog_post = spl2.id_simpleblog_post');

    return true;
}
