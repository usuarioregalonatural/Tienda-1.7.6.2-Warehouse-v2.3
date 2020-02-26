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

class AdminIqitLinkWidgetController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->className = 'IqitLinkBlock';
        $this->table = 'iqit_link_block';

        parent::__construct();

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->name = 'IqitLinkWidget';
        $this->repository = new IqitLinkBlockRepository(
            Db::getInstance(),
            $this->context->shop
        );

        $this->presenter = new IqitLinkBlockPresenter(
            new Link(),
            $this->context->language
        );
    }

    public function init()
    {
        if (Tools::isSubmit('edit' . $this->className)) {
            $this->display = 'edit';
        } elseif (Tools::isSubmit('addIqitLinkBlock')) {
            $this->display = 'add';
        }

        parent::init();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submit' . $this->className)) {
            $this->addNameArrayToPost();

            if (!$this->processSave()) {
                return false;
            }
            $hook_name = Hook::getNameById(Tools::getValue('id_hook'));
            if (!Hook::isModuleRegisteredOnHook($this->module, $hook_name, $this->context->shop->id)) {
                Hook::registerHook($this->module, $hook_name);
            }

            $this->module->clearCache();

            Tools::redirectAdmin($this->context->link->getAdminLink('Admin'.$this->name));
        } elseif (Tools::isSubmit('delete' . $this->className)) {
            $block = new IqitLinkBlock(Tools::getValue('id_iqit_link_block'));
            $block->delete();

            if (!$this->repository->getCountByIdHook((int) $block->id_hook)) {
                Hook::unregisterHook($this->module, Hook::getNameById((int) $block->id_hook));
            }

            $this->module->clearCache();

            Tools::redirectAdmin($this->context->link->getAdminLink('Admin' . $this->name));
        }

        return parent::postProcess();
    }

    public function renderView()
    {

        $title = $this->l('Link block configuration');

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $title,
                'icon' => 'icon-list-alt',
            ),
            'input' => array(
                array(
                    'type' => 'link_blocks',
                    'label' => $this->l('Link Blocks'),
                    'name' => 'link_blocks',
                    'values' => $this->repository->getCMSBlocksSortedByHook(),
                ),
            ),
            'buttons' => array(
                'newBlock' => array(
                    'title' => $this->l('New block'),
                    'href' => $this->context->link->getAdminLink('Admin' . $this->name) . '&amp;addIqitLinkBlock',
                    'class' => 'pull-right',
                    'icon' => 'process-icon-new',
                ),
            ),
        );

        $this->getLanguages();

        $helper = $this->buildHelper();
        $helper->submit_action = '';
        $helper->title = $title;

        $helper->fields_value = $this->fields_value;

        return $helper->generateForm($this->fields_form);
    }

    public function renderForm()
    {
        $block = new IqitLinkBlock((int) Tools::getValue('id_iqit_link_block'));

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => isset($block->id) ? $this->l('Edit the link block.') : $this->l('New link block'),
                'icon' => isset($block->id) ? 'icon-edit' : 'icon-plus-square',
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_iqit_link_block',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_shop',
                    'value' => (int) $this->context->shop->id,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Name of the link block'),
                    'name' => 'name',
                    'lang' => true,
                    'required' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Hook'),
                    'name' => 'id_hook',
                    'class' => 'input-lg',
                    'options' => array(
                        'query' => $this->repository->getDisplayHooksForHelper(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'repository_links',
                    'label' => $this->l('Links repository'),
                    'name' => 'repository_links',
                ),
                array(
                    'type' => 'selected_links',
                    'label' => $this->l('Selected links'),
                    'name' => 'selected_links[]',
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
                'title' => $this->l('Save'),
            ),
        );

        if ($id_hook = Tools::getValue('id_hook')) {
            $block->id_hook = (int) $id_hook;
        }

        if (Tools::getValue('name')) {
            $block->name = Tools::getValue('name');
        }

        $block->id_shop = (int) $this->context->shop->id;

        $helper = $this->buildHelper();
        if (isset($block->id)) {
            $helper->currentIndex = AdminController::$currentIndex . '&id_iqit_link_block=' . $block->id;
            $helper->submit_action = 'submitEdit' . $this->className;
        } else {
            $helper->submit_action = 'submitAdd' . $this->className;
        }

        $helper->fields_value = (array) $block;

        $helper->tpl_vars = array(
            'category_tree' => $this->repository->getCategories(),
            'cms_tree' => $this->repository->getCmsPages(),
            'static_pages' => $this->repository->getStaticPages(),
            'selected_links' => $this->presenter->makeLinks($block->content)
        );

        return $helper->generateForm($this->fields_form);
    }

    protected function buildHelper()
    {
        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->override_folder = 'iqitlinkwidget/';
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
        $this->toolbar_title[] = $this->l('Themes');
        $this->toolbar_title[] = $this->l('Iqit Links Manager"');
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addJqueryPlugin('tablednd');
        $this->addJS(_MODULE_DIR_ . $this->module->name . '/views/js/admin.js');
        $this->addJS(_PS_JS_DIR_ . 'admin/dnd.js');
        $this->addCSS(_MODULE_DIR_ . $this->module->name . '/views/css/back.css');

        return;
    }

    private function addNameArrayToPost()
    {
        $languages = Language::getLanguages();
        $names = array();
        foreach ($languages as $lang) {
            if ($name = Tools::getValue('name_' . (int) $lang['id_lang'])) {
                $names[(int) $lang['id_lang']] = $name;
            }
        }
        $_POST['name_iqit_link_block'] = $names;
    }

    public function ajaxProcessUpdatePositions()
    {
        $way = (int) (Tools::getValue('way'));
        $id_iqit_link_block = (int) (Tools::getValue('id'));
        $reg = '/^' . $this->table . '_\d*$/';
        $table = array_keys($_POST)[0];
        $positions = array();

        if (preg_match('/^iqit_link_block_\d*$/', $table, $matches)) {
            $positions = Tools::getValue($table);
        }

        foreach ($positions as $position => $value) {
            $pos = explode('_', $value);
            IqitLinkBlock::updateBlockPosition($pos[2], $position);
        }
        $this->module->clearCache();

        die();
    }
}
