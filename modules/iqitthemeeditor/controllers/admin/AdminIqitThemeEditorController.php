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

include_once _PS_MODULE_DIR_ . 'iqitthemeeditor/src/IqitThemeEditorForm.php';

class AdminIqitThemeEditorController extends ModuleAdminController
{
    private $name;
    private $cfgName;
    private $defaults;
    private $systemFonts;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->name = 'IqitThemeEditor';
       // $this->display = 'edit';

        parent::__construct();
        $this->meta_title = $this->l('Iqit Theme Editor');

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->cfgName = 'iqitthemeed_';

        $this->systemFonts = $this->module->systemFonts;

        $this->defaults = $this->module->defaults;
    }

    public function renderForm()
    {
        $helper = $this->buildHelper();
        $helper->submit_action = 'saveThemeEditor';

        $helper->fields_value = $this->getConfigFormValues();

        $base_url = Tools::getHttpHost(true);  // DON'T TOUCH (base url (only domain) of site (without final /)).
        $base_url = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? $base_url : str_replace('https', 'http', $base_url);

        $helper->tpl_vars = array(
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'theme_version' => $this->module->version,
            'frontEditorLink' => $this->context->link->getAdminLink('IqitFrontThemeEditor'),
            'current_link' => $this->context->link->getAdminLink('Admin'.$this->name),
            'formType' => 'backoffice',
            'iqit_base_url' => $base_url
        );

        $formFields = new IqitThemeEditorForm();

        return $helper->generateForm(array(
            $formFields->getGeneralForm(), $formFields->getMobileForm(),
            $formFields->getOptionsTabForm(), $formFields->getOptionsForm(), $formFields->getTypographyForm(), $formFields->getCartForm(), $formFields->getButtonsForm(), $formFields->getBreadcrumbForm(), $formFields->getFormsForm(), $formFields->getModalsForm(),
            $formFields->getLabelsForm(), $formFields->getSocialMediaForm(),
            $formFields->getHeaderTabForm(), $formFields->getHeaderWrapperForm(), $formFields->getHeaderLayoutForm(), $formFields->getTopBarForm(), $formFields->getHeaderForm(),
            $formFields->getMenuTabForm(), $formFields->getMenuHorizontalForm(), $formFields->getMenuVerticalForm(), $formFields->getMenuSubmenuForm(), $formFields->getMenuMobileForm(),
            $formFields->getContentTabForm(), $formFields->getContentWrapperForm(), $formFields->getContentForm(), $formFields->getSidebarForm(), $formFields->getProductListForm(), $formFields->getCategoryPageForm(), $formFields->getProductPageForm(),
            $formFields->getBrandsPageForm(),
            $formFields->getFooterTabForm(), $formFields->getFooterLayoutForm(), $formFields->getFooterDesignForm(), $formFields->getFooterCopyrightForm(),
            $formFields->getCodesForm(), $formFields->getMaintanceForm(), $formFields->getImportExportForm()));
    }



    protected function getConfigFormValues()
    {
        $var = array();
        foreach ($this->defaults as $key => $default) {
            if ($default['type'] == 'json') {
                $var[$key] = json_decode(Configuration::get($this->cfgName  . $key), true);
            } elseif ($default['type'] == 'txt') {
                foreach (Language::getLanguages(false) as $lang) {
                    $var[$key][(int)$lang['id_lang']] = Configuration::get($this->cfgName  . $key, (int)$lang['id_lang']);
                }
            } elseif ($default['type'] == 'html') {
                $var[$key] = htmlspecialchars_decode (Configuration::get($this->cfgName  . $key));
            } else {
                $var[$key] = Configuration::get($this->cfgName  . $key);
            }
        }
        return $var;
    }

    protected function buildHelper()
    {
        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->override_folder = 'iqitthemeeditor/';
        $helper->identifier = $this->className;
        $helper->token = Tools::getAdminTokenLite('Admin'.$this->name);
        $helper->languages = $this->_languages;
        $helper->currentIndex = $this->context->link->getAdminLink('Admin'.$this->name);
        $helper->default_form_language = $this->default_form_language;
        $helper->allow_employee_form_lang = $this->allow_employee_form_lang;
        $helper->toolbar_scroll = true;
        $helper->toolbar_btn = $this->initToolbar();

        return $helper;
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addJS(_MODULE_DIR_ . $this->module->name . '/views/js/backoffice.js');
        $this->addCSS(_MODULE_DIR_ . $this->module->name . '/views/css/backoffice.css');
    }

    public function postProcess()
    {
        if (Tools::isSubmit('importConfiguration')) {
            if (isset($_FILES['uploadConfig']) && isset($_FILES['uploadConfig']['tmp_name'])) {
                try{
                    $str = file_get_contents($_FILES['uploadConfig']['tmp_name']);
                    $arr = json_decode($str, true);

                    foreach ($arr as $default => $value) {
                        Configuration::updateValue($this->cfgName . $default, $value);
                    }

                    $var = array();

                    foreach ($this->defaults as $key => $default) {
                        if (isset($default['cached']) && $default['type'] != 'txt') {
                            $var[$key] = Configuration::get($this->cfgName . $key);
                        }
                    }

                    Configuration::updateValue($this->cfgName . 'options', json_encode($var));
                    $this->content .= $this->module->generateCssAndJs();
                }catch(Exception $ex){
                    $this->content .= $this->module->displayError($this->l('No config file'));
                }
            } else {
                $this->content .= $this->module->displayError($this->l('No config file'));
            }
        } elseif (Tools::isSubmit('saveThemeEditor')) {
            $var = array();
            foreach ($this->defaults as $key => $default) {
                if ($default['type'] == 'json') {
                    Configuration::updateValue($this->cfgName . $key, urldecode(Tools::getValue($key)));
                } elseif ($default['type'] == 'txt') {
                    $messageTrads = array();
                    foreach (Language::getLanguages(false) as $lang) {
                        $messageTrads[(int)$lang['id_lang']] = Tools::getValue($key.'_'.(int)$lang['id_lang']);
                    }
                    Configuration::updateValue($this->cfgName . $key, $messageTrads, true);
                } elseif ($default['type'] == 'html') {
                    Configuration::updateValue($this->cfgName . $key, htmlspecialchars(Tools::getValue($key)), true);
                } elseif ($default['type'] == 'raw') {
                    if (isset($_POST[$key]))
                        Configuration::updateValue($this->cfgName . $key, $_POST[$key]);
                } else {
                    Configuration::updateValue($this->cfgName . $key, Tools::getValue($key));
                }

                if (isset($default['cached']) && $default['type'] != 'txt') {
                    $var[$key] = Tools::getValue($key);
                }
            }
            Configuration::updateValue($this->cfgName . 'options', json_encode($var));
            $this->content .= $this->module->generateCssAndJs();
        }

        parent::postProcess();
    }

    public function ajaxProcessExportThemeConfiguration()
    {
        $var = array();

        foreach ($this->defaults as $key => $default) {
            $var[$key] = Configuration::get($this->cfgName  . $key);
        }

        header('Content-disposition: attachment; filename=iqitthemeeditor_config.json');
        header('Content-type: application/json');
        print_r(json_encode($var));
        die;
    }

    public function initContent()
    {
        if (!$this->viewAccess()) {
            $this->errors[] = Tools::displayError('You do not have permission to view this.');
            return;
        }

        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            $this->context->smarty->assign(array(
                'content' => $this->getWarningMultishopHtml()
            ));
            return;
        }

        if (Tools::getValue('liveRedirect')) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink('IqitFrontThemeEditor')
            );
        }

        $this->content .= $this->renderForm();
        $this->context->smarty->assign(array(
            'content' => $this->content,
        ));
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
