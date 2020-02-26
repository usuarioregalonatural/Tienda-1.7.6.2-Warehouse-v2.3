<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';

if (version_compare(_PS_VERSION_, '1.7', '>=')) {
    include_once _PS_MODULE_DIR_.'ph_simpleblog/controllers/front/list-v17.php';
} else {
    include_once _PS_MODULE_DIR_.'ph_simpleblog/controllers/front/list-v16.php';
}
