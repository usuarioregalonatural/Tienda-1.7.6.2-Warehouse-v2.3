<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminIqitElementorController extends ModuleAdminController
{
    public $name;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'IqitElementorLanding';
        $this->table = 'iqit_elementor_landing';
        $this->_where = 'AND a.`id_shop` = '.(int) Context::getContext()->shop->id;

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        parent::__construct();

        $this->_orderBy = 'id_iqit_elementor_landing';
        $this->identifier = 'id_iqit_elementor_landing';
        $test = array();
        $test[0] = array(
            'id' => 0,
            'name' => $this->l('No results were found for your search.')
        );


        $this->fields_options = array(
            'general' => array(
                'title' =>    $this->l('Settings'),
                'fields' =>    array(
                    'iqit_homepage_layout' => array(
                        'title' => $this->l('Homepage layout'),
                        'desc' => $this->l('Choose your homepage layout. You can create multiple layouts in list above. So you can change them fast when needed.'),
                        'cast' => 'intval',
                        'type' => 'select',
                        'list' => array_merge($test, IqitElementorLanding::getLandingPages()),
                        'identifier' => 'id'
                    ),
                    'iqit_elementor_cache' => array(
                        'title' => $this->l('Autoclear cache'),
                        'desc' => $this->l('If enabled module cache will be cleared after product or manufacturer create/edit/delete. If not it will be only clearad when you edit layout.'),
                        'cast' => 'intval',
                        'type' => 'select',
                        'list' => array(
                            array(
                                'id' => '0',
                                'name' => $this->l('No'),
                            ),
                            array(
                                'id' => '1',
                                'name' => $this->l('Yes'),
                            )
                        ),
                        'identifier' => 'id'
                    ),

                ),
                'submit' => array('title' => $this->l('Save'))
            )
        );

        $this->fields_list = array(
            'id_iqit_elementor_landing' => array('title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'),
            'title' => array('title' => $this->l('Name'), 'width' => 'auto'),
        );

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }
        $this->name = 'IqitElementor';
    }

    public function init()
    {


        if (Tools::isSubmit('edit' . $this->className)) {
            $this->display = 'edit';
        } elseif (Tools::isSubmit('addiqit_elementor_landing')) {
            $this->display = 'add';
        }


        parent::init();
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

        parent::initContent();
    }



    public function postProcess()
    {
        if (Tools::isSubmit('submit' . $this->className)) {
            $returnObject = $this->processSave();
            if (!$returnObject) {
                return false;
            }

            Tools::redirectAdmin($this->context->link->getAdminLink('Admin'.$this->name) . '&id_iqit_elementor_landing='.$returnObject->id .'&updateiqit_elementor_landing');
        }

        if (Tools::isSubmit('submitOptions' . $this->table)) {
            $this->module->clearHomeCache();
        }
        
        return parent::postProcess();
    }

    public function renderForm()
    {
        $landing = new IqitElementorLanding((int) Tools::getValue('id_iqit_elementor_landing'));

        if ($landing->id){
            $url = $this->context->link->getAdminLink('IqitElementorEditor').'&pageType=landing&pageId=' . $landing->id;
        }
        else{
            $url = false;
        }

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => isset($landing->id) ? $this->l('Edit layout.') : $this->l('New layout'),
                'icon' => isset($landing->id) ? 'icon-edit' : 'icon-plus-square',
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_iqit_elementor_landing',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Title of layout'),
                    'name' => 'title',
                    'required' => true,
                ),
                array(
                    'type' => 'elementor_trigger',
                    'label' => $this->l('Title of layout'),
                    'url'  => $url,
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_shop',
                ),
            ),
            'buttons' => array(
                'cancelBlock' => array(
                    'title' => $this->l('Cancel'),
                    'href' => (Tools::safeOutput(Tools::getValue('back', false)))
                        ?: $this->context->link->getAdminLink('Admin' . $this->name),
                    'icon' => 'process-icon-cancel',
                ),
            ),
            'submit' => array(
                'name' => 'submit' . $this->className,
                'title' => $this->l('Save and stay'),
            ),
        );


        if (Tools::getValue('title')) {
            $landing->title = Tools::getValue('title');
        }

        $helper = $this->buildHelper();
        if (isset($landing->id)) {
            $helper->currentIndex = AdminController::$currentIndex . '&id_iqit_link_block=' . $landing->id;
            $helper->submit_action = 'submitEdit' . $this->className;
        } else {
            $helper->submit_action = 'submitAdd' . $this->className;
        }

        $helper->fields_value = (array) $landing;
        $helper->fields_value['id_shop'] = $this->context->shop->id;
        return $helper->generateForm($this->fields_form);
    }

    protected function buildHelper()
    {
        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->override_folder = 'iqitelementor/';
        $helper->identifier = $this->className;
        $helper->token = Tools::getAdminTokenLite('Admin' . $this->name);
        $helper->languages = $this->_languages;
        $helper->currentIndex = $this->context->link->getAdminLink('Admin' . $this->name);
        $helper->default_form_language = $this->default_form_language;
        $helper->allow_employee_form_lang = $this->allow_employee_form_lang;
        $helper->toolbar_scroll = true;
        $helper->toolbar_btn = $this->initToolbar();

        return $helper;
    }


    public function initToolBarTitle()
    {
        $this->toolbar_title[] = $this->l('Iqit Elementor - Page builder');
    }


    public function ajaxProcessCategoryLayout()
    {
        header('Content-Type: application/json');
        $categoryId = (int) Tools::getValue('categoryId');
        $justElementor = (int) Tools::getValue('justElementor');

        IqitElementorCategory::setJustElementor($categoryId, $justElementor);

        $return = array(
            'success' => true,
            'data' => true
        );

        die(json_encode($return));
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
