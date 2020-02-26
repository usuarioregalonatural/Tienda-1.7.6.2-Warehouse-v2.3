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

function upgrade_module_1_3_2_8()
{
    Configuration::updateGlobalValue('PH_BLOG_COMMENT_ALLOW_GUEST', false);
    Configuration::updateGlobalValue('PH_BLOG_COMMENTS_RECAPTCHA', true);
    Configuration::updateGlobalValue('PH_BLOG_COMMENTS_RECAPTCHA_SITE_KEY', '');
    Configuration::updateGlobalValue('PH_BLOG_COMMENTS_RECAPTCHA_SECRET_KEY', '');
    Configuration::updateGlobalValue('PH_BLOG_COMMENTS_RECAPTCHA_THEME', 'light');

    return true;
}
