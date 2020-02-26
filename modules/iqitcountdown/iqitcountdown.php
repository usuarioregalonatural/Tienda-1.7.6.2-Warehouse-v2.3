<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2017 IQIT-COMMERCE.COM
 * @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class IqitCountDown extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'iqitcountdown';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->cfgName = 'iqitct_';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IQITCOUNTDOWN - Special price countdown');
        $this->description = $this->l('Show timer for special price with definied time limit');
    }

    public function install()
    {
        parent::install();
        $this->registerHook('displayHeader');
        $this->registerHook('displayCountDown');
        return true;
    }


    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $templateFile = 'product.tpl';

        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile);
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }


        if (isset($configuration['smarty']->tpl_vars['product']->value['specific_prices']['to'])) {
            return array(
                'to' => $configuration['smarty']->tpl_vars['product']->value['specific_prices']['to'],
            );
        }
    }

    public function hookdisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');
        Media::addJsDef(array('iqitcountdown_days' => $this->l('d.')));
        $this->context->controller->addJS($this->_path . 'views/js/front.js');
    }
}
