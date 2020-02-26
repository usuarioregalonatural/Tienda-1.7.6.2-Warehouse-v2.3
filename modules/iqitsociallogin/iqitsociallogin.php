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

class IqitSocialLogin extends Module implements WidgetInterface
{
    protected $templateFile;
    public $cfgName;
    public $defaults;

    public function __construct()
    {
        $this->name = 'iqitsociallogin';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->controllers = array('authenticate');
        $this->bootstrap = true;

        $this->cfgName = 'iqitsociall_';
        $this->defaults = array(

            'type' => 0,
            'btn_colors' => 'theme',

            'facebook_status' => 0,
            'facebook_key' => '',
            'facebook_secret' => '',

            'google_status' => 0,
            'google_key' => '',
            'google_secret' => '',

            'twitter_status' => 0,
            'twitter_key' => '',
            'twitter_secret' => '',

            'instagram_status' => 0,
            'instagram_key' => '',
            'instagram_secret' => '',

        );

        parent::__construct();


        $this->displayName = $this->l('IQITSOCIALLOGIN - allow customers to login with social account');
        $this->description = $this->l('Social login with Facebook, Google, Twitter');

        $this->templateFile = 'module:' . $this->name . '/views/templates/hook/';
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

    }

    public function install()
    {
        if (parent::install() && $this->registerHook('displayHeader') && $this->registerHook('displayCustomerLoginFormAfter')  && $this->registerHook('displayRegistrationBeforeForm') && $this->registerHook('displayCheckoutLoginFormAfter')) {
            foreach ($this->defaults as $default => $value) {
                    Configuration::updateValue($this->cfgName . $default, $value);
            }
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }
        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';

        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return $this->getWarningMultishopHtml();
        }

        if (Tools::isSubmit('submitModule')) {
            foreach ($this->defaults as $default => $value) {
                    Configuration::updateValue($this->cfgName . $default, Tools::getValue($default));
            }

            if (Tools::getValue('facebook_status')) {
                if (Tools::getValue('facebook_key') == '' || Tools::getValue('facebook_secret') == '') {
                    Configuration::updateValue($this->cfgName . 'facebook_status', 0);
                    $output .= $this->displayError($this->l('To enable Facebook login you need to fill API key an secret'));
                }
            }

            if (Tools::getValue('google_status')) {
                if (Tools::getValue('google_key') == '' || Tools::getValue('google_secret') == '') {
                    Configuration::updateValue($this->cfgName . 'google_status', 0);
                    $output .= $this->displayError($this->l('To enable Google login you need to fill API key an secret'));
                }
            }

            if (Tools::getValue('twitter_status')) {
                if (Tools::getValue('twitter_key') == '' || Tools::getValue('twitter_secret') == '') {
                    Configuration::updateValue($this->cfgName . 'twitter_status', 0);
                    $output .= $this->displayError($this->l('To enable Twitter login you need to fill API key an secret'));
                }
            }

            if (Tools::getValue('instagram_status')){
                if (Tools::getValue('instagram_key') == '' || Tools::getValue('instagram_secret') == ''){
                    Configuration::updateValue($this->cfgName . 'instagram_status', 0);
                    $output .= $this->displayError($this->l('To enable Instagram login you need to fill API key an secret'));
                }
            }

            $output .= $this->displayConfirmation($this->l('Configuration updated'));
            $this->_clearCache($this->templateFile . 'social-login.tpl');
        }
        $output .= $this->renderForm();
        return $output;
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Login type'),
                        'desc' => $this->l('If popup enabled new window will be open for asking of permissions from social network'),
                        'name' => 'type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Redirect'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Popup'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Button colors'),
                        'name' => 'btn_colors',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'theme',
                                    'name' => $this->l('Theme btn secondary'),
                                ),
                                array(
                                    'id_option' => 'native',
                                    'name' => $this->l('Native colors of social pages'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'info',
                        'label' => $this->l(''),
                        'infoTitle' => 'Facebook',
                        'info' => 'http://iqit-commerce.com/xdocs/warehouse-theme-documentation/#iqitsociallogin-facebook',
                        'name' => 'info',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Facebook login'),
                        'name' => 'facebook_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook API ID'),
                        'name' => 'facebook_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook API secret'),
                        'name' => 'facebook_secret',
                    ),
                    array(
                        'type' => 'separator',
                        'label' => $this->l(''),
                        'name' => 'separator',
                    ),
                    array(
                        'type' => 'info',
                        'label' => $this->l(''),
                        'infoTitle' => 'Google',
                        'info' => 'http://iqit-commerce.com/xdocs/warehouse-theme-documentation/#iqitsociallogin-google',
                        'name' => 'info',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Google login'),
                        'name' => 'google_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google API client ID'),
                        'name' => 'google_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google API secret'),
                        'name' => 'google_secret',
                    ),
                    array(
                        'type' => 'separator',
                        'label' => $this->l(''),
                        'name' => 'separator',
                    ),
                    array(
                        'type' => 'info',
                        'label' => $this->l(''),
                        'infoTitle' => 'Twitter',
                        'info' => 'http://iqit-commerce.com/xdocs/warehouse-theme-documentation/#iqitsociallogin-twitter',
                        'name' => 'info',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Twitter login'),
                        'name' => 'twitter_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter API key'),
                        'name' => 'twitter_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter API secret'),
                        'name' => 'twitter_secret',
                    ),
                    array(
                        'type' => 'separator',
                        'label' => $this->l(''),
                        'name' => 'separator',
                    ),
                    /*
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Instagram login'),
                        'name' => 'instagram_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram API key'),
                        'name' => 'instagram_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram API secret'),
                        'name' => 'instagram_secret',
                    ),
                    */
                ),
                'submit' => array(
                    'name' => 'submitModule',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        if (Shop::isFeatureActive()) {
            $fields_form['form']['description'] = $this->l('The modifications will be applied to') . ' ' . (Shop::getContext() == Shop::CONTEXT_SHOP ? $this->l('shop') . ' ' . $this->context->shop->name : $this->l('all shops'));
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues(){
        $var = array();
        foreach ($this->defaults as $default => $value) {
                $var[$default] = Configuration::get($this->cfgName . $default);
        }
        return $var;
    }

    public function hookDisplayHeader(){
        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style',
            'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayCustomerLoginFormAfter\d*$/', $hookName)) {
            $templateFile = 'authentication.tpl';
        } elseif (preg_match('/^displayCheckoutLoginFormAfter\d*$/', $hookName)){
            $templateFile = 'checkout.tpl';
        } elseif (preg_match('/^displayRegistrationBeforeForm\d*$/', $hookName)){
            $templateFile = 'checkout.tpl';
        }

        if (!$this->isCached($this->templateFile . $templateFile, $this->getCacheId())) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch($this->templateFile . $templateFile, $this->getCacheId());
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $page = 'authentication';

        if (preg_match('/^displayCustomerLoginFormAfter\d*$/', $hookName)) {
            $page = 'authentication';
        } elseif (preg_match('/^displayCheckoutLoginFormAfter\d*$/', $hookName)){
            $page = 'checkout';
        } elseif (preg_match('/^displayRegistrationBeforeForm\d*$/', $hookName)){
            $page = 'authentication';
        }

        return array(
                'page' => $page,
                'type' => Configuration::get($this->cfgName . 'type'),
                'btn_colors' => Configuration::get($this->cfgName . 'btn_colors'),
                'facebook_status' => Configuration::get($this->cfgName . 'facebook_status'),
                'google_status' => Configuration::get($this->cfgName . 'google_status'),
                'twitter_status' => Configuration::get($this->cfgName . 'twitter_status'),
                'instagram_status' => Configuration::get($this->cfgName . 'instagram_status'),
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
