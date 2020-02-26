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
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class IqitSearch extends Module implements WidgetInterface
{
    private $templateFile;

    public function __construct()
    {
        $this->name = 'iqitsearch';
        $this->version = '1.0.0';
        $this->author = 'iqit-commerce.com';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('IQITSEARCH');
        $this->description = $this->l('Adds a quick search field to your website.');

        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);

        $this->templateFile =  'module:' . $this->name . '/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displaySearch')
        ;
    }

    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'search_controller_url' => $this->context->link->getPageLink('search', null, null, null, false, null, true),
        );

        if (!array_key_exists('search_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['search_string'] = '';
        }

        return $widgetVariables;
    }

    public function renderWidget($hookName, array $configuration = [])
    {
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->fetch($this->templateFile);
    }
}
