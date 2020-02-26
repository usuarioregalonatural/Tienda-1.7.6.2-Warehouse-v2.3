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

class IqitContactPage extends Module implements WidgetInterface
{
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitcontactpage';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;

        $this->cfgName = 'iqitcontactp_';
        $this->defaults = array(
            'company' => 'Your company',
            'address' => 'Your address',
            'latitude' => '25.948969',
            'longitude' => '-80.226439',
            'show_map' => 1,
            'phone' => '777 777 777',
            'mail' => 'yourmail@com.com',
            'content' => '<p>iqitcontactpage - module, you can put own text in configuration</p>',
        );

        parent::__construct();

        $this->displayName = $this->l('IQITCONTACTPAGE - Custom contact page with map + contact block on footer');
        $this->description = $this->l('Contacts information and map on contact form page');

        $this->templateFile = 'module:' . $this->name . '/views/templates/hook/';
    }

    public function install()
    {
        $this->_clearCache($this->templateFile . 'iqitcontactpage-map.tpl');
        $this->_clearCache($this->templateFile . 'iqitcontactpage-info.tpl');
        if (parent::install() && $this->registerHook('displayHeader') && $this->registerHook('displayContactMap') && $this->registerHook('displayFooter')) {
            foreach ($this->defaults as $default => $value) {
                if ($default == 'content') {
                    $message_trads = array();
                    foreach (Language::getLanguages(false) as $lang) {
                        $message_trads[(int)$lang['id_lang']] = $value;
                    }
                    Configuration::updateValue($this->cfgName . $default, $message_trads, true);
                } else {
                    Configuration::updateValue($this->cfgName . $default, $value);
                }
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
                if ($default == 'content') {
                    $message_trads = array();
                    foreach ($_POST as $key => $value) {
                        if (preg_match('/content_/i', $key)) {
                            $id_lang = preg_split('/content_/i', $key);
                            $message_trads[(int)$id_lang[1]] = $value;
                        }
                    }
                    Configuration::updateValue($this->cfgName . $default, $message_trads, true);
                } else {
                    Configuration::updateValue($this->cfgName . $default, Tools::getValue($default));
                }
            }
            $output .= $this->displayConfirmation($this->l('Configuration updated'));
            $this->_clearCache($this->templateFile . 'iqitcontactpage-map.tpl');
            $this->_clearCache($this->templateFile . 'iqitcontactpage-info.tpl');
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
                        'type' => 'switch',
                        'label' => $this->l('Show map'),
                        'name' => 'show_map',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Show map'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Show map'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Map marker latitude'),
                        'name' => 'latitude',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Map marker longitude'),
                        'name' => 'longitude',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Company name'),
                        'name' => 'company',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Address'),
                        'name' => 'address',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Phone number'),
                        'name' => 'phone',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('E-mail'),
                        'name' => 'mail',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Custom text'),
                        'name' => 'content',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
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

    public function getConfigFieldsValues()
    {
        $var = array();
        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$default][(int)$lang['id_lang']] = Configuration::get($this->cfgName . $default,
                        (int)$lang['id_lang']);
                }
            } else {
                $var[$default] = Configuration::get($this->cfgName . $default);
            }
        }
        return $var;
    }

    public function hookDisplayHeader()
    {
        if ($this->context->controller->php_self != 'contact') {
            return;
        }

        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style',
            'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayContactMap\d*$/', $hookName)) {
            $templateFile = 'iqitcontactpage-map.tpl';
        } elseif (preg_match('/^displayFooter\d*$/', $hookName)) {
            $templateFile = 'iqitcontactpage-block.tpl';
        } else {
            $templateFile = 'iqitcontactpage-info.tpl';
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

        if (preg_match('/^displayContactMap\d*$/', $hookName)) {
            $showMap = Configuration::get($this->cfgName . 'show_map');
            $point['latitude'] = (float)Configuration::get($this->cfgName . 'latitude');
            $point['longitude'] = (float)Configuration::get($this->cfgName . 'longitude');

            return array(
                'show_map' => $showMap,
                'point' => $point
            );
        } else {
            return array(
                'company' => Configuration::get($this->cfgName . 'company'),
                'address' => Configuration::get($this->cfgName . 'address'),
                'phone' => Configuration::get($this->cfgName . 'phone'),
                'mail' => Configuration::get($this->cfgName . 'mail'),
                'content' => Configuration::get($this->cfgName . 'content', $this->context->language->id),
            );
        }
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
