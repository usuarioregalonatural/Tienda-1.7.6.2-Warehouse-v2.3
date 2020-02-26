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

class Iqitpopup extends Module implements WidgetInterface
{
    protected $config_form = false;
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitpopup';
        $this->tab = 'front_office_features';
        $this->version = '1.1.1';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IQITPOPUP - Pop-up window module with newsletter subscription');
        $this->description = $this->l('Show custom popup in your prestashop store. ');

        $this->config_name = 'IQITPOPUP';
        $this->defaults = array(
            'width' => 650,
            'height' => 450,
            'pages' => 1,
            'newval' => 1,
            'cookie' => 10,
            'txt_color' => '#777777',
            'bg_color' => '#ffffff',
            'newsletter' => 0,
            'bg_image' => '',
            'bg_repeat' => 0,
            'bg_cover' => 0,
            'pop_delay' => 2500,
            'new_txt_color' => '#ffffff',
            'new_bg_color' => '#777777',
            'input_txt_color' => '#ffffff',
            'input_bg_color' => '#a1a1a1',
            'new_bg_image' => '',
            'new_bg_repeat' => 0,
            'content' => 'Content of newsletter popup',
        );

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBeforeBodyClosingTag') &&
            $this->registerHook('registerGDPRConsent')
        ) {
            $this->setDefaults();
            $this->generateCss(true);
            return true;
        } else {
            return false;
        }
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }

        return parent::uninstall();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                $message_trads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $message_trads[(int)$lang['id_lang']] = '<p>The best effect you will get if you remove text and put background image</p>';
                }

                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } else {
                Configuration::updateValue($this->config_name . '_' . $default, $value);
            }
        }
    }

    public function getContent()
    {
        $output = '';
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return $this->getWarningMultishopHtml();
        }

        $base_url = Tools::getHttpHost(true);  // DON'T TOUCH (base url (only domain) of site (without final /)).
        $base_url = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? $base_url : str_replace('https', 'http', $base_url);

        Media::addJsDef(array(
            'iqitBaseUrl'  => Tools::safeOutput($base_url)
        ));

        if (Tools::isSubmit('submitIqitpopupModule')) {
            $this->_postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        return $output . $this->renderForm();
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
        $helper->submit_action = 'submitIqitpopupModule';
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
                        'type' => 'select',
                        'label' => $this->l('Pages'),
                        'name' => 'pages',
                        'options' => array(
                            'query' => array(array(
                                'id_option' => 1,
                                'name' => $this->l('Index only(homepage)'),
                            ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('All pages'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show newsletter form'),
                        'name' => 'newsletter',
                        'is_bool' => true,
                        'desc' => $this->l('Make shure that you have instaled ps_emailsubscription module. Voucher code you can set in ps_emailsubscription module'),
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
                        'label' => $this->l('Width'),
                        'name' => 'width',
                        'suffix' => 'px',
                        'desc' => $this->l('Popup window width. Below this width module will be hidden.'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Height of main content'),
                        'name' => 'height',
                        'suffix' => 'px',
                        'desc' => $this->l('Popup window height. Below this height module will be hidden.'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Content background color'),
                        'name' => 'bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'background_image',
                        'label' => $this->l('Content  background image'),
                        'name' => 'bg_image',
                        'desc' => $this->l('Filename should be without special characters or whitespaces'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Content background repeat'),
                        'name' => 'bg_repeat',
                        'options' => array(
                            'query' => array(array(
                                'id_option' => 3,
                                'name' => $this->l('Repeat XY'),
                            ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('Repeat X'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Repeat Y'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('No repeat'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Background-size: cover'),
                        'name' => 'bg_cover',
                        'is_bool' => true,
                        'desc' => $this->l('If enable image background will cover entire popup'),
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
                        'label' => $this->l('Popup dalay'),
                        'name' => 'pop_delay',
                        'suffix' => 's',
                        'desc' => $this->l('Delay show of popup for x miliseconds'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Content text color'),
                        'name' => 'txt_color',
                        'desc' => $this->l('Default text color. Can be modified in wysiwyg editor too.'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Newsletter background color'),
                        'name' => 'new_bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'background_image',
                        'label' => $this->l('Newsletter background image'),
                        'name' => 'new_bg_image',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Newsletter background repeat'),
                        'name' => 'new_bg_repeat',
                        'options' => array(
                            'query' => array(array(
                                'id_option' => 3,
                                'name' => $this->l('Repeat XY'),
                            ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('Repeat X'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Repeat Y'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('No repeat'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Newsletter text color'),
                        'name' => 'new_txt_color',
                        'desc' => $this->l('Default text color. Text can be modified by modules translation'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Newsletter input text color'),
                        'name' => 'input_txt_color',
                        'desc' => $this->l('Text color of input field'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Newsletter input bg color'),
                        'name' => 'input_bg_color',
                        'desc' => $this->l('Background color on input field'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Cookie time'),
                        'name' => 'cookie',
                        'suffix' => 'days',
                        'desc' => $this->l('Time in days of storing cookie. After that time windows will be showed again'),
                        'size' => 20,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content of popup module'),
                        'name' => 'content',
                        'lang' => true,
                        'autoload_rte' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Generate new cookie variable'),
                        'name' => 'newval',
                        'is_bool' => true,
                        'desc' => $this->l('If enabled cookie variable name will be generated, so after modification popup will be showed to users even if old cookie life time do not end yet'),
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
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $var = array();

        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$default][(int)$lang['id_lang']] = Configuration::get($this->config_name . '_' . $default, (int)$lang['id_lang']);
                }
            } elseif ($default == 'newval') {
                $var[$default] = 1;
            } else {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }
        }
        return $var;
    }

    protected function _postProcess()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                $message_trads = array();
                foreach ($_POST as $key => $value) {
                    if (preg_match('/content_/i', $key)) {
                        $id_lang = preg_split('/content_/i', $key);
                        $message_trads[(int)$id_lang[1]] = $value;
                    }
                }
                Configuration::updateValue($this->config_name . '_' . $default, $message_trads, true);
            } elseif ($default == 'newval') {
                if (Tools::getValue($default)) {
                    Configuration::updateValue($this->config_name . '_' . $default, mt_rand(1, 40000));
                }
            } else {
                Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
            }
        }
        $this->_clearCache($this->templateFile);
        $this->generateCss();
        self::clearAssetsCache();
    }

    public function generateCss($allShops = false)
    {
        $css = '';
        $bg_image = Configuration::get($this->config_name . '_bg_image');
        $bg_image_input = Configuration::get($this->config_name . '_new_bg_image');
        $css .= '
		#iqitpopup{ width: ' . (int)Configuration::get($this->config_name . '_width') . 'px; height: ' . ((int)Configuration::get($this->config_name . '_height')) . 'px; }

		#iqitpopup {
		background-color: ' . (Configuration::get($this->config_name . '_bg_color')) . ';
		' . (isset($bg_image) && $bg_image != '' ? 'background-image: url(' . $bg_image . ') !important;' : '') . '
		background-repeat: ' . $this->convertBgRepeat(Configuration::get($this->config_name . '_bg_repeat')) . ' !important;
	}
		#iqitpopup .iqitpopup-content{ color: ' . Configuration::get($this->config_name . '_txt_color') . ';
		}

		#iqitpopup .iqitpopup-newsletter-form{ color: ' . Configuration::get($this->config_name . '_new_txt_color') . '; background-color: ' . (Configuration::get($this->config_name . '_new_bg_color')) . ';

		' . (isset($bg_image_input) && $bg_image_input != '' ? 'background-image: url(' . $bg_image_input . ') !important;' : '') . '
		background-repeat: ' . $this->convertBgRepeat(Configuration::get($this->config_name . '_new_bg_repeat')) . ' !important;
		}

		#iqitpopup .iqitpopup-newsletter-form .newsletter-input{
		color: ' . Configuration::get($this->config_name . '_input_txt_color') . '; background-color: ' . (Configuration::get($this->config_name . '_input_bg_color')) . ';
		}

		#iqitpopup .iqitpopup-newsletter-form .newsletter-inputl:-moz-placeholder {
  color: ' . Configuration::get($this->config_name . '_input_txt_color') . ' !important;}
#iqitpopup .iqitpopup-newsletter-form .newsletter-input::-moz-placeholder {
  color: ' . Configuration::get($this->config_name . '_input_txt_color') . ' !important;}
#iqitpopup .iqitpopup-newsletter-form .newsletter-input:-ms-input-placeholder {
  color: ' . Configuration::get($this->config_name . '_input_txt_color') . ' !important; }
#iqitpopup .iqitpopup-newsletter-form .newsletter-input::-webkit-input-placeholder {
  color: ' . Configuration::get($this->config_name . '_input_txt_color') . ' !important; }

		';

        if (Configuration::get($this->config_name . '_bg_cover')) {
            $css .= '#iqitpopup{
				    background-size: cover;
			}';
        }

        if ($allShops) {
            $shops = Shop::getShopsCollection();
            foreach ($shops as $shop) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int)$shop->id . ".css";
                file_put_contents($myFile, $css);
            }
        } else {
            if (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int)$this->context->shop->getContextShopID() . ".css";

                if (file_put_contents($myFile, $css)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function convertBgRepeat($value)
    {
        switch ($value) {
            case 3:
                $repeat_option = 'repeat';
                break;
            case 2:
                $repeat_option = 'repeat-x';
                break;
            case 1:
                $repeat_option = 'repeat-y';
                break;
            default:
                $repeat_option = 'no-repeat';
        }
        return $repeat_option;
    }

    public function hookHeader()
    {
        if (Configuration::get($this->config_name . '_pages') && $this->context->controller->php_self != 'index') {
            return;
        }

        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style', 'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules' . $this->name . '-script', 'modules/' . $this->name . '/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);

        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->context->controller->registerStylesheet('modules-' . $this->name . '-style-custom', 'modules/' . $this->name . '/views/css/custom_s_' . (int)$this->context->shop->getContextShopID() . '.css', ['media' => 'all', 'priority' => 150]);
        }

        $newVal = (int)Configuration::get($this->config_name . '_newval');

        $delay = 0;
        $delay = (int)Configuration::get($this->config_name . '_pop_delay');

        Media::addJsDef(array(
            'iqitpopup' => [
                'time' => (int)Configuration::get($this->config_name . '_cookie'),
                'name' => 'iqitpopup_'.$newVal,
                'delay' => $delay
            ]));
    }


    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (Configuration::get($this->config_name . '_pages') && $this->context->controller->php_self != 'index') {
            return;
        }

        $newVal = (int)Configuration::get($this->config_name . '_newval');

        if (!isset($_COOKIE['iqitpopup_' . $newVal])) {
            if (!$this->isCached($this->templateFile, $this->getCacheId())) {
                $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
            }
            return $this->fetch($this->templateFile, $this->getCacheId());
        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {

        return array(
            'txt' => Configuration::get($this->config_name . '_content', $this->context->language->id),
            'id_module' =>  $this->id,
            'newsletter' => Configuration::get($this->config_name . '_newsletter'),

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

    public static function clearAssetsCache()
    {
        $files = glob(_PS_THEME_DIR_.'assets/cache/*');

        foreach ($files as $file) {
            if ('index.php' !== basename($file)) {
                Tools::deleteFile($file);
            }
        }

        $version = (int) Configuration::get('PS_CCCJS_VERSION');
        Configuration::updateValue('PS_CCCJS_VERSION', ++$version);
        $version = (int) Configuration::get('PS_CCCCSS_VERSION');
        Configuration::updateValue('PS_CCCCSS_VERSION', ++$version);
    }
}
