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

use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class IqitFreeDeliveryCount extends Module implements WidgetInterface
{
    protected $config_form = false;


    public function __construct()
    {
        $this->name = 'iqitfreedeliverycount';
        $this->tab = 'administration';
        $this->version = '1.4.1';
        $this->author = 'iqit-commerce.com';
        $this->need_instance = 0;
        $this->module_key = '834065271d1b45780b9a539963f2b3d7';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IQITFREEDELIVERYCOUNT - Amount Left to free shipping');
        $this->description = $this->l('Module countdown amount which left to free shipping');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->cfgName = 'iqitfdc_';
        $this->defaults = array(
            'custom_status' => 0,
            'custom_amount' => 450,
            'txt_color' => '#ffffff',
            'bg_color' => '#E7692A',
            'border_color' => '#AB3E07',
            'txt' => 'IQITFREEDELIVERYCOUNT - module, you can put own text in configuration',
        );
    }

    public function install()
    {
        parent::install();
        $this->setDefaults();
        $this->registerHook('displayCartAjaxInfo');
        $this->registerHook('header');
        return true;
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }
        return parent::uninstall();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'txt') {
                $message_trads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $message_trads[(int) $lang['id_lang']] = $value;
                }
                Configuration::updateValue($this->cfgName . $default, $message_trads, true);
            } else {
                Configuration::updateValue($this->cfgName . $default, $value);
            }
        }
    }

    public function getContent()
    {
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return $this->getWarningMultishopHtml();
        }
        if (Tools::isSubmit('submitModule')) {
            $this->postProcess();
        }
        $this->context->smarty->assign('module_dir', $this->_path);
        return $this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
        . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Custom free shipping amount status'),
                        'name' => 'custom_status',
                        'is_bool' => true,
                        'desc' => $this->l('By default module use free shipping value definien in Shipping >
                        preferences, but if you set free shipping price indvidual per carrier,
                        then you put same value here'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Custom free shipping amount value'),
                        'name' => 'custom_amount',
                        'desc' => $this->l('Put price with tax '),
                        'size' => 20,
                        'suffix' => $this->context->currency->getSign(), 3,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Additional info'),
                        'desc' => $this->l('For example if you only offer free shipping for one carrier and you want to inform about that'),
                        'name' => 'txt',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }


    protected function getConfigFormValues()
    {
        $var = array();
        foreach ($this->defaults as $default => $value) {
            if ($default == 'txt') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$default][(int) $lang['id_lang']] = Configuration::get($this->cfgName . $default, (int) $lang['id_lang']);
                }
            } else {
                $var[$default] = Configuration::get($this->cfgName  . $default);
            }
        }
        return $var;
    }

    protected function postProcess()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'txt') {
                $message_trads = array();
                foreach ($_POST as $key => $value) {
                    if (preg_match('/txt_/i', $key)) {
                        $id_lang = preg_split('/txt_/i', $key);
                        $message_trads[(int) $id_lang[1]] = $value;
                    }
                }
                Configuration::updateValue($this->cfgName . $default, $message_trads, true);
            } else {
                Configuration::updateValue($this->cfgName . $default, (Tools::getValue($default)));
            }
        }
    }

    public function hookHeader()
    {
        if (Configuration::get($this->cfgName . 'custom_status')) {
            $free_ship_from = Tools::convertPrice(
                (float) Configuration::get($this->cfgName . 'custom_amount'),
                Currency::getCurrencyInstance((int) Context::getContext()->currency->id)
            );
        } else {
            $free_ship_from = Tools::convertPrice(
                (float) Configuration::get('PS_SHIPPING_FREE_PRICE'),
                Currency::getCurrencyInstance((int) Context::getContext()->currency->id)
            );
        }

        Media::addJsDef(array('iqitfdc_from' => $free_ship_from));
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if ($this->context->cart->isVirtualCart()){
            return;
        }

        if (preg_match('/^displayCartAjaxInfo\d*$/', $hookName)) {
            $templateFile = 'iqitfreedeliverycount.tpl';
        }

        $assign = $this->getWidgetVariables($hookName, $configuration);

        if ($assign) {
            $this->smarty->assign($assign);
            return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile);
        } else {
            return;
        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }
        $hide = false;

        if (Configuration::get($this->cfgName . 'custom_status')) {
            $free_ship_from = Tools::convertPrice(
                (float) Configuration::get($this->cfgName . 'custom_amount'),
                Currency::getCurrencyInstance((int) Context::getContext()->currency->id)
            );
        } else {
            $free_ship_from = Tools::convertPrice(
                (float) Configuration::get('PS_SHIPPING_FREE_PRICE'),
                Currency::getCurrencyInstance((int) Context::getContext()->currency->id)
            );
        }

        $tax_excluded_display = Group::getPriceDisplayMethod(Group::getCurrent()->id);

        if ($tax_excluded_display ){
            $total = Context::getContext()->cart->getOrderTotal(false, Cart::BOTH_WITHOUT_SHIPPING);
        } else{
            $total = Context::getContext()->cart->getOrderTotal(true, Cart::BOTH_WITHOUT_SHIPPING);
        }

        if ($free_ship_from == 0) {
            return;
        }

        if (count(Context::getContext()->cart->getOrderedCartRulesIds(CartRule::FILTER_ACTION_SHIPPING))) {
            return;
        }

        $priceFormatter = new PriceFormatter();

        if (($free_ship_from - $total) <= 0) {
            $free_ship_remaining = 0;
            $hide = true;
        } else {
            $free_ship_remaining = $priceFormatter->format($free_ship_from - $total);
        }

        $free_ship_from = $priceFormatter->format($free_ship_from);

        return array(
            'free_ship_remaining' => $free_ship_remaining,
            'free_ship_from' => $free_ship_from,
            'hide' => $hide,
            'txt' => Configuration::get($this->cfgName . 'txt', $this->context->language->id),
        );
    }

    protected function getWarningMultishopHtml()
    {
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return '<p class="alert alert-warning">' .
            $this->l('You cannot manage module from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit') .
                '</p>';
        } else {
            return '';
        }
    }
}
