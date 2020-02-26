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

class IqitCookieLaw extends Module implements WidgetInterface
{
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitcookielaw';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;

        $this->cfgName = 'iqitcl_';
        $this->defaults = array(
            'bg' => '#464646',
            'color' => '#ffffff',
            'content' => '<p>iqitcookielaw - module, put here your own cookie law text</p>',
        );

        parent::__construct();

        $this->displayName = $this->l('IQITCOOKIELAW - Eu Cookie Law notification');
        $this->description = $this->l('Show text about cookies in your shop');

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/iqitcookielaw.tpl';
    }

    public function install()
    {
        $this->_clearCache($this->templateFile);
        if (parent::install() && $this->registerHook('displayHeader') && $this->registerHook('displayBeforeBodyClosingTag')) {
            foreach ($this->defaults as $default => $value) {
                if ($default == 'content') {
                    $message_trads = array();
                    foreach (Language::getLanguages(false) as $lang) {
                        $message_trads[(int) $lang['id_lang']] = $value;
                    }
                    Configuration::updateValue($this->cfgName . $default, $message_trads, true);
                } else {
                    Configuration::updateValue($this->cfgName . $default, $value);
                }
            }

            $this->generateCss(true);
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
                            $message_trads[(int) $id_lang[1]] = $value;
                        }
                    }
                    Configuration::updateValue($this->cfgName . $default, $message_trads, true);
                } else {
                    Configuration::updateValue($this->cfgName . $default, Tools::getValue($default));
                }
            }
            $output .= $this->displayConfirmation($this->l('Configuration updated'));
            $this->_clearCache($this->templateFile);
            $this->generateCss();
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
                        'type' => 'textarea',
                        'label' => $this->l('Cookie law text'),
                        'name' => 'content',
                        'autoload_rte' => true,
                        'lang' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background color'),
                        'name' => 'bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color'),
                        'name' => 'color',
                        'size' => 30,
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
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
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
                    $var[$default][(int) $lang['id_lang']] = Configuration::get($this->cfgName . $default, (int) $lang['id_lang']);
                }
            } else {
                $var[$default] = Configuration::get($this->cfgName . $default);
            }
        }
        return $var;
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->context->controller->registerStylesheet('modules-'.$this->name.'-style-custom', 'modules/'.$this->name.'/views/css/custom_s_'.(int) $this->context->shop->getContextShopID().'.css', ['media' => 'all', 'priority' => 151]);
        }
        $this->context->controller->registerJavascript('modules'.$this->name.'-script', 'modules/'.$this->name.'/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (isset($_COOKIE['cookielaw_module'])) {
            return;
        }
        if (!$this->isCached($this->templateFile, $this->getCacheId())) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId());
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        return array(
            'txt' => Configuration::get($this->cfgName . 'content', $this->context->language->id),
        );
    }

    public function generateCss($allShops = false)
    {
        $css = '
        #iqitcookielaw{
             color: ' . Configuration::get($this->cfgName . 'color') . ';
             background-color: ' . Configuration::get($this->cfgName . 'bg') . ';
        }';

        $css = trim(preg_replace('/\s+/', ' ', $css));

        if ($allShops) {
            $shops = Shop::getShopsCollection();
            foreach ($shops as $shop) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int) $shop->id . ".css";
                file_put_contents($myFile, $css);
            }
        } else {
            if (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int) $this->context->shop->getContextShopID() . ".css";

                if (file_put_contents($myFile, $css)) {
                    return true;
                } else {
                    return false;
                }
            }
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
