<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2017 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';
require_once _PS_MODULE_DIR_.'ph_simpleblog/controllers/front/list.php';

class ph_simpleblogpageModuleFrontController extends ph_simplebloglistModuleFrontController
{
    public function __construct()
    {
        parent::__construct();

        if (!version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->display_column_left = (is_object(Context::getContext()->theme) ? Context::getContext()->theme->hasLeftColumn('module-ph_simpleblog-list') : true);
            $this->display_column_right = (is_object(Context::getContext()->theme) ? Context::getContext()->theme->hasRightColumn('module-ph_simpleblog-list') : true);
        }
    }
}
