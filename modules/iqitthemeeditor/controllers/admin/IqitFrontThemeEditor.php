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

include_once _PS_MODULE_DIR_ . 'iqitthemeeditor/src/scssphp/scss.inc.php';
include_once _PS_MODULE_DIR_ . 'iqitthemeeditor/src/IqitThemeEditorForm.php';

class IqitFrontThemeEditorController extends ModuleAdminController
{
    private $name;
    private $cfgName;
    private $defaults;
    private $systemFonts;

    public function __construct()
    {
        $this->bootstrap = true;

        $this->display_header = false;
        parent::__construct();
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->name = 'IqitFrontThemeEditor';

        $this->cfgName = 'iqitthemeed_';

        $this->systemFonts = array(
            array(
                'id_option' => 'Arial, Helvetica, sans-serif',
                'name' => 'Arial, Helvetica, sans-serif'
            ),
            array(
                'id_option' => 'Georgia, serif',
                'name' => 'Georgia, serif'
            ),
            array(
                'id_option' => 'Tahoma, Geneva, sans-serif',
                'name' => 'Tahoma, Geneva, sans-serif'
            ),
            array(
                'id_option' => '"Times New Roman", Times, serif',
                'name' => '"Times New Roman", Times, serif'
            ),
            array(
                'id_option' => 'Verdana, Geneva, sans-serif',
                'name' => 'Verdana, Geneva, sans-serif'
            )
        );

        $this->defaults = $this->module->defaults;


    }

    public function renderView(){}

    public function initContent(){
        $this->setMedia();
        $this->initHeader();
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addJquery();
        $this->addjQueryPlugin(array('autosize', 'fancybox'));

        $this->addCSS(array(
            __PS_BASE_URI__ . $this->admin_webpath . '/themes/' . $this->bo_theme . '/css/admin-theme.css',
            __PS_BASE_URI__ . $this->admin_webpath . '/themes/' . $this->bo_theme . '/public/theme.css',
            _MODULE_DIR_ . 'iqitthemeeditor/views/css/front.css',
            _MODULE_DIR_ . $this->module->name . '/views/css/backoffice.css'
        ));

        $this->addJqueryUI(array('ui.slider', 'ui.datepicker'));
        $this->addJS(array(
            _PS_JS_DIR_ . 'admin.js?v=' . _PS_VERSION_,
            _PS_JS_DIR_ . 'tiny_mce/tiny_mce.js',
            _PS_JS_DIR_ . 'admin/tinymce.inc.js',
            _PS_JS_DIR_ . 'jquery/plugins/timepicker/jquery-ui-timepicker-addon.js',
            _MODULE_DIR_ . 'iqitthemeeditor/views/js/sassjs/sass.js',
            _MODULE_DIR_ . 'iqitthemeeditor/views/js/front.js',
            _MODULE_DIR_ . $this->module->name . '/views/js/backoffice.js'

        ));

        $this->addJS(__PS_BASE_URI__ . $this->admin_webpath . '/themes/' . $this->bo_theme . '/js/vendor/bootstrap.min.js');


        Media::addJsDef(
            array('iqitThemeEditor' => [
                'defaults' => $this->defaults
            ]));

        Hook::exec('actionAdminControllerSetMedia');
    }

    public function display()
    {

        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink('AdminIqitThemeEditor') . '&liveRedirect=1'
            );
        }

        $idLang = (int)$this->context->language->id;
        $idShop = (int)$this->context->shop->id;

        $params = array(
            'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
            'admin_webpath' => $this->context->controller->admin_webpath,
            'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                Tools::getValue('id_employee')
        );

        $idProduct = $this->getPreviewProductId($idShop);
        $ipa = Product::getDefaultAttribute($idProduct);
        $idCategory = $this->getPreviewCategoryId($idShop);

        $product = new Product($idProduct, false, $idLang);


        $category = new Category($idCategory, $idLang);

        $previewLinks = array(
            'index' => [
                'title' => $this->l('Homepage'),
                'link' => $this->context->link->getPageLink('index', true, null, $params)
            ],
            'brands' => [
                'title' => $this->l('Brands'),
                'link' => $this->context->link->getPageLink('manufacturer', true, null, $params)
            ],
            'maintenance' => [
                'title' => $this->l('Maintenance'),
                'link' => $this->context->link->getModuleLink('iqitthemeeditor', 'Preview', array(
                    'page' => 'maintenance',
                    'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
                    'admin_webpath' => $this->context->controller->admin_webpath,
                    'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                        Tools::getValue('id_employee')
                ), true)
            ],
            'form' => [
                'title' => $this->l('Form'),
                'link' => $this->context->link->getModuleLink('iqitthemeeditor', 'Preview', array(
                    'page' => 'form',
                    'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
                    'admin_webpath' => $this->context->controller->admin_webpath,
                    'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                        Tools::getValue('id_employee')
                ), true)
            ],
        );

        if (Validate::isLoadedObject($product)){
            $previewLinks['product'] = [
                'title' => $this->l('Product'),
                'link' => $this->context->link->getProductLink($product->id, $product->link_rewrite, null, null, null, null, $ipa, false, false, false, $params)
            ];
        }

        if (Validate::isLoadedObject($category)){
            $previewLinks['category'] = [
                'title' => $this->l('Category'),
                'link' => $this->parseCategoryUrl($this->context->link->getCategoryLink($category))
            ];
        }

        Media::addJsDef(
            array('iqitFrontEditor' => [
                'ajaxurl' => $this->context->link->getAdminLink('IqitFrontThemeEditor') . '&ajax=1',
                'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
                'admin_webpath' => $this->context->controller->admin_webpath,
                'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                    Tools::getValue('id_employee')
            ]));

        $this->context->smarty->assign(array(
            'js_def_vars' => Media::getJsDef(),
        ));

        $cacheStatus = false;
        $smartyCacheStatus = Configuration::get('PS_SMARTY_CACHE');
        $additonalCacheStatus = _PS_CACHE_ENABLED_;

        if ($additonalCacheStatus || $smartyCacheStatus) {
            $cacheStatus = true;
        }

        $form = $this->buildHelper();
        $this->context->smarty->assign(array(
            'baseDir' => __PS_BASE_URI__ . basename(_PS_ADMIN_DIR_) . '/',
            'previewLinks' => $previewLinks,
            'editorForm' => $form,
            'cacheStatus' => $cacheStatus,
            'cacheLink' => $this->context->link->getAdminLink('AdminPerformance'),
            'backToBo' => $this->context->link->getAdminLink('AdminIqitThemeEditor')
        ));

        $this->smartyOutputContent(_PS_MODULE_DIR_ . '/iqitthemeeditor/views/templates/admin/fronteditor.tpl');
    }

    public function ajaxProcessSaveForm()
    {
        header('Content-Type: application/json');


        $formData = array();
        parse_str(Tools::getValue('formData'), $formData);

        $var = array();
        foreach ($this->defaults as $key => $default) {
            if ($default['type'] != 'txt') {
                if (!isset($formData[$key])) {
                    continue;
                }
            }

            if ($default['type'] == 'json') {
                Configuration::updateValue($this->cfgName . $key, urldecode($formData[$key]));
            } elseif ($default['type'] == 'txt') {
                $messageTrads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $messageTrads[(int)$lang['id_lang']] = $formData[$key.'_'.(int)$lang['id_lang']];
                }
                Configuration::updateValue($this->cfgName . $key, $messageTrads, true);
            } elseif ($default['type'] == 'html') {
                Configuration::updateValue($this->cfgName . $key, htmlspecialchars($formData[$key]), true);
            }  else {
                Configuration::updateValue($this->cfgName . $key, $formData[$key]);
            }

            if (isset($default['cached']) && $default['type'] != 'txt') {
                $var[$key] = $formData[$key];
            }
        }
        Configuration::updateValue($this->cfgName . 'options', json_encode($var));

        $generationResult = $this->module->generateCssAndJsProcess();

        $result = [
            'success' => $generationResult['success'],
            'message' => $generationResult['message'],
        ];


        die(json_encode($result));
    }

    public function renderForm()
    {
    }


    protected function buildHelper()
    {
        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->override_folder = 'iqitthemeeditor/';
        $helper->identifier = $this->className;
        $helper->token = Tools::getAdminTokenLite('Admin' . $this->name);
        $helper->languages = $this->_languages;
        $helper->currentIndex = $this->context->link->getAdminLink('Admin' . $this->name);
        $helper->default_form_language = $this->default_form_language;
        $helper->allow_employee_form_lang = $this->allow_employee_form_lang;
        $helper->toolbar_scroll = true;
        $helper->toolbar_btn = $this->initToolbar();

        $helper->submit_action = 'saveThemeEditor';

        $helper->fields_value = $this->getConfigFormValues();

        $base_url = Tools::getHttpHost(true);  // DON'T TOUCH (base url (only domain) of site (without final /)).
        $base_url = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? $base_url : str_replace('https', 'http', $base_url);

        $helper->tpl_vars = array(
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'theme_version' => $this->module->version,
            'frontEditorLink' => $this->context->link->getAdminLink('IqitFrontThemeEditor'),
            'current_link' => $this->context->link->getAdminLink('Admin' . $this->name),
            'formType' => 'front',
            'backToBoLink' => $this->context->link->getAdminLink('AdminIqitThemeEditor'),
            'iqit_base_url' => $base_url
        );


        $formFields = new IqitThemeEditorForm();

        return $helper->generateForm(array(
            $formFields->getGeneralForm(), $formFields->getMobileForm(),
            $formFields->getOptionsTabForm(), $formFields->getOptionsForm(), $formFields->getTypographyForm(), $formFields->getCartForm(), $formFields->getButtonsForm(), $formFields->getBreadcrumbForm(),  $formFields->getFormsForm(), $formFields->getModalsForm(),
            $formFields->getLabelsForm(), $formFields->getSocialMediaForm(),
            $formFields->getHeaderTabForm(), $formFields->getHeaderWrapperForm(), $formFields->getHeaderLayoutForm(), $formFields->getTopBarForm(), $formFields->getHeaderForm(),
            $formFields->getMenuTabForm(), $formFields->getMenuHorizontalForm(), $formFields->getMenuVerticalForm(), $formFields->getMenuSubmenuForm(), $formFields->getMenuMobileForm(),
            $formFields->getContentTabForm(), $formFields->getContentWrapperForm(), $formFields->getContentForm(), $formFields->getSidebarForm(), $formFields->getProductListForm(), $formFields->getCategoryPageForm(), $formFields->getProductPageForm(),
            $formFields->getBrandsPageForm(),
            $formFields->getFooterTabForm(), $formFields->getFooterLayoutForm(), $formFields->getFooterDesignForm(), $formFields->getFooterCopyrightForm(),
            $formFields->getCodesForm(), $formFields->getMaintanceForm()));
    }


    protected function getConfigFormValues()
    {
        $var = array();
        foreach ($this->defaults as $key => $default) {
            if ($default['type'] == 'json') {
                $var[$key] = json_decode(Configuration::get($this->cfgName . $key), true);
            } elseif ($default['type'] == 'txt') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$key][(int)$lang['id_lang']] = Configuration::get($this->cfgName . $key, (int)$lang['id_lang']);
                }
            } elseif ($default['type'] == 'html') {
                $var[$key] = htmlspecialchars_decode(Configuration::get($this->cfgName  . $key));
            }  else {
                $var[$key] = Configuration::get($this->cfgName . $key);
            }
        }

        return $var;
    }

    protected function getPreviewProductId($idShop)
    {
        $sql = 'SELECT id_product FROM ' . _DB_PREFIX_ . 'product_shop WHERE active = 1 AND id_shop = ' . (int)$idShop;
        return Db::getInstance()->getValue($sql);
    }

    protected function getPreviewCategoryId($idShop)
    {
        $sql = 'SELECT c.id_category FROM ' . _DB_PREFIX_ . 'category c
         INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (c.`id_category` = cs.`id_category`) 
         WHERE c.active = 1 AND c.level_depth > 1 AND cs.id_shop = ' . (int)$idShop;
        return Db::getInstance()->getValue($sql);
    }

    protected function parseCategoryUrl($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        $employe = is_object($this->context->employee) ? (int)$this->context->employee->id : Tools::getValue('id_employee');

        if ($query) {
            $url .= '&iqit_fronteditor_token=' . $this->module->getFrontEditorToken() . '&admin_webpath=' . $this->context->controller->admin_webpath . '&id_employee=' . $employe;
        } else {
            $url .= '?iqit_fronteditor_token=' . $this->module->getFrontEditorToken() . '&admin_webpath=' . $this->context->controller->admin_webpath . '&id_employee=' . $employe;
        }
        return $url;
    }
}
