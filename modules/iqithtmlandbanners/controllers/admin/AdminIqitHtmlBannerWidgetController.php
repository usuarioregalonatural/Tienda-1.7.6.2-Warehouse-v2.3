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

class AdminIqitHtmlBannerWidgetController extends ModuleAdminController
{
    const UPLOAD_DIR = _PS_MODULE_DIR_ . 'iqithtmlandbanners/uploads/';
    const UPLOAD_URL = _MODULE_DIR_ . 'iqithtmlandbanners/uploads/';
    const ACCESS_RIGHTS = 0775;
    const SOURCE_INDEX = _PS_PROD_IMG_DIR_ . 'index.php';

    public $repository;
    public $presenter;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->className = 'IqitHtmlAndBanner';
        $this->table = 'iqit_htmlandbanner';

        parent::__construct();

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->name = 'IqitHtmlBannerWidget';
        $this->repository = new IqitHtmlAndBannerRepository(
            Db::getInstance(),
            $this->context->shop
        );

        $this->presenter = new IqitHtmlAndBannerPresenter(
            $this->context->language
        );
    }

    public function init()
    {
        if (Tools::isSubmit('edit' . $this->className)) {
            $this->display = 'edit';
        } elseif (Tools::isSubmit('addIqitHtmlAndBanner')) {
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

            Tools::redirectAdmin($this->context->link->getAdminLink('Admin'.$this->name).'&type='.(int)Tools::getValue('type'));
        } elseif (Tools::isSubmit('delete' . $this->className)) {
            $block = new IqitHtmlAndBanner(Tools::getValue('id_iqit_htmlandbanner'));
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

        $title = $this->l('Block configuration');
        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $title,
                'icon' => 'icon-list-alt',
            ),
            'input' => array(
                array(
                    'type' => 'blocks',
                    'label' => $this->l('Blocks'),
                    'name' => 'blocks',
                    'values' => $this->repository->getCMSBlocksSortedByHook(),
                ),
            ),
            'buttons' => array(
                'newBlock' => array(
                    'title' => $this->l('New html widget'),
                    'href' => $this->context->link->getAdminLink('Admin' . $this->name) . '&addIqitHtmlAndBanner&type=1',
                    'class' => 'pull-right',
                    'icon' => 'process-icon-new',
                ),
                'newBlock2' => array(
                    'title' => $this->l('New banner widget'),
                    'href' => $this->context->link->getAdminLink('Admin' . $this->name) . '&addIqitHtmlAndBanner&type=0',
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
        $block = new IqitHtmlAndBanner((int) Tools::getValue('id_iqit_htmlandbanner'), null, $this->context->shop->id);
        $type = Tools::getValue('type');
        $bannerImages = array();

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => isset($block->id) ? $this->l('Edit the  block.') : $this->l('New  block'),
                'icon' => isset($block->id) ? 'icon-edit' : 'icon-plus-square',
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



        if ($type) {
            $this->fields_form[0]['form']['input'] = array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_iqit_htmlandbanner',
                ),
                 array(
                     'type' => 'hidden',
                     'name' => 'type',
                     'value' => 1,
                 ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_shop',
                    'value' => (int) $this->context->shop->id,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Name of the block'),
                    'name' => 'name',
                    'lang' => true,
                    'required' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Hook'),
                    'name' => 'id_hook',
                    'options' => array(
                        'query' => $this->repository->getDisplayHooksForHelper(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'options' => array(
                        'query' => array(
                            array(
                                'id_option' => 0,
                                'name' => $this->module->l('Auto'),
                            ),
                            array(
                                'id_option' => 1,
                                'name' => $this->module->l('1/12'),
                            ),
                            array(
                                'id_option' => 2,
                                'name' => $this->module->l('2/12'),
                            ),
                            array(
                                'id_option' => 3,
                                'name' => $this->module->l('3/12'),
                            ),
                            array(
                                'id_option' => 4,
                                'name' => $this->module->l('4/12'),
                            ),
                            array(
                                'id_option' => 5,
                                'name' => $this->module->l('5/12'),
                            ),
                            array(
                                'id_option' => 6,
                                'name' => $this->module->l('6/12'),
                            ),array(
                                'id_option' => 7,
                                'name' => $this->module->l('7/12'),
                            ),
                            array(
                                'id_option' => 8,
                                'name' => $this->module->l('8/12'),
                            ),
                            array(
                                'id_option' => 9,
                                'name' => $this->module->l('9/12'),
                            ),
                            array(
                                'id_option' => 10,
                                'name' => $this->module->l('10/12'),
                            ),
                            array(
                                'id_option' => 11,
                                'name' => $this->module->l('11/12'),
                            ),
                            array(
                                'id_option' => 12,
                                'name' => $this->module->l('12/12'),
                            ),
                        ),
                        'id' => 'id_option',
                        'name' => 'name',
                    ),
                ),
                 array(
                     'type' => 'hidden',
                     'name' => 'content',
                 ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'description',
                    'lang' => true,
                    'autoload_rte' => true,
                    'cols' => 60,
                    'rows' => 30,
                )
            );
            $block->type = 1;
        } else {
            $bannerImages = $block->content;
            $this->fields_form[0]['form']['input'] = array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_iqit_htmlandbanner',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'type',
                    'value' => 0,
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
                    'options' => array(
                        'query' => $this->repository->getDisplayHooksForHelperBanner(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'file',
                    'name' => 'banners',
                    'multiple' => true,
                    'ajax' => true,
                    'max_files' => 40,
                    'url' => $this->context->link->getAdminLink('Admin'.$this->name).'&ajax=1&action=addImages',
                    'label' => $this->l('Images'),
                ),
                array(
                    'type' => 'banners',
                    'label' => $this->l('Banners'),
                    'name' => 'banners',

                ),
            );
            $block->type = 0;
        }

        if ($id_hook = Tools::getValue('id_hook')) {
            $block->id_hook = (int) $id_hook;
        }

        if (Tools::getValue('name')) {
            $block->name = Tools::getValue('name');
        }

        $block->id_shop = (int) $this->context->shop->id;

        $helper = $this->buildHelper();
        if (isset($block->id)) {
            $helper->currentIndex = AdminController::$currentIndex . '&id_iqit_htmlandbanner=' . $block->id;
            $helper->submit_action = 'submitEdit' . $this->className;
        } else {
            $helper->submit_action = 'submitAdd' . $this->className;
        }

        $helper->fields_value = (array) $block;
        $helper->tpl_vars = array(
            'imgBannersPath' => $this->module->imgBannersPath,
            'bannerImages' => $bannerImages
        );

        return $helper->generateForm($this->fields_form);
    }

    protected function buildHelper()
    {
        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->override_folder = 'iqithtmlandbanners/';
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
        $this->toolbar_title[] = $this->l('Html and Banners');
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addJqueryUi('ui.sortable');
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
        $descriptions = array();
        foreach ($languages as $lang) {
            if ($name = Tools::getValue('name_' . (int) $lang['id_lang'])) {
                $names[(int) $lang['id_lang']] = $name;
            }
            if ($description = Tools::getValue('description_' . (int) $lang['id_lang'])) {
                $descriptions[(int) $lang['id_lang']] = $description;
            }
        }
        $_POST['name_iqit_htmlandbanner'] = $names;
        $_POST['description_iqit_htmlandbanner'] = $descriptions;
    }

    public function ajaxProcessUpdatePositions()
    {
        $way = (int) (Tools::getValue('way'));
        $id_iqit_htmlandbanner = (int) (Tools::getValue('id'));
        $reg = '/^' . $this->table . '_\d*$/';
        $table = array_keys($_POST)[0];
        $positions = array();

        if (preg_match('/^iqit_htmlandbanner_\d*$/', $table, $matches)) {
            $positions = Tools::getValue($table);
        }

        foreach ($positions as $position => $value) {
            $pos = explode('_', $value);
            IqitHtmlAndBanner::updateBlockPosition($pos[2], $position);
        }
        $this->module->clearCache();
        die();
    }

    public function ajaxProcessAddImages()
    {
        header('Content-Type: application/json');

        $folder = 'images/';

        $imageUploader = new HelperImageUploader('banners');
        $imageUploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'));
        $files = $imageUploader->process();
        $newDestination = self::UPLOAD_DIR . $folder;

        foreach ($files as &$file) {
            $filename = uniqid() . '.jpg';
            $error = 0;
            if (!ImageManager::resize($file['save_path'], $newDestination . $filename, null, null, 'jpg', false, $error)) {
                switch ($error) {
                    case ImageManager::ERROR_FILE_NOT_EXIST:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file does not exist anymore.');
                        break;
                    case ImageManager::ERROR_FILE_WIDTH:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file width is 0px.');
                        break;
                    case ImageManager::ERROR_MEMORY_LIMIT:
                        $file['error'] = Tools::displayError('An error occurred while copying image, check your memory limit.');
                        break;
                    default:
                        $file['error'] = Tools::displayError('An error occurred while copying image.');
                        break;
                }
                continue;
            }
            unlink($file['save_path']);
            unset($file['save_path']);
            $file['status'] = 'ok';
            $file['name'] = $filename;
        }
        die(json_encode(array($imageUploader->getName() => $files)));
    }
}
