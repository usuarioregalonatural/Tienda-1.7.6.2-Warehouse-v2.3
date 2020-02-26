<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

class AdminWhatsappChatAgentController extends ModuleAdminController
{
    protected $delete_mode;
    protected $_defaultOrderBy = 'position';
    protected $_defaultOrderWay = 'ASC';
    protected $position_identifier = 'id_whatsappchatblock_agent';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'whatsappchatblock_agent';
        $this->mainClassName = 'WhatsappChatBlock';
        $this->mainTabClassName = 'AdminWhatsappChat';
        $this->className = 'WhatsappChatBlockAgent';
        $this->tabClassName = 'AdminWhatsappChatAgent';
        $this->module_name = 'whatsappchat';
        $this->lang = true;

        parent::__construct();

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->_orderWay = $this->_defaultOrderWay;

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );

        $this->context = Context::getContext();

        $this->default_form_language = $this->context->language->id;

        if (Tools::getValue('id_whatsappchatblock')) {
            $this->_where = 'AND a.id_whatsappchatblock = '.(int)Tools::getValue('id_whatsappchatblock');
            $this->context->cookie->id_whatsappchatblock = (int)Tools::getValue('id_whatsappchatblock');
        } elseif (isset($this->context->cookie->id_whatsappchatblock)) {
            $this->_where = 'AND a.id_whatsappchatblock = '.(int)$this->context->cookie->id_whatsappchatblock;
        }

        $this->fields_list = array(
            'id_whatsappchatblock' => array(
                'title' => $this->l('WhatsApp button'),
                'align' => 'text-center center',
                'callback' => 'printPreview',
            ),
            'id_whatsappchatblock_agent' => array(
                'title' => $this->l('Agent ID'),
                'align' => 'text-center center',
                'class' => 'fixed-width-xs'
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'align' => 'text-center center',
                'filter_key' => 'a!name'
            ),
            'department' => array(
                'title' => $this->l('Department'),
                'align' => 'text-center center',
            ),
            'mobile_phone' => array(
                'title' => $this->l('Mobile phone'),
                'align' => 'text-center center',
            ),
            'image' => array(
                'title' => $this->l('Image'),
                'align' => 'text-center center',
                'filter_key' => 'a!image',
                'callback' => 'printImage'
            ),
            'position' => array('title' => $this->l('Position'), 'filter_key' => 'position', 'align' => 'center', 'class' => 'fixed-width-sm', 'position' => 'position'),
            'active' => array(
                'title' => $this->l('Enabled'),
                'align' => 'text-center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!active'
            ),
        );

        $this->tpl_vars = array(
            'icon' => 'icon-users',
        );
        $this->context->smarty->assign($this->tpl_vars);
    }

    public function init()
    {
        parent::init();
    }

    public function printImage($value)
    {
        if ($value == '' || $value == ' ') {
            return '--';
        }
        return '<img class="whatsappchat_avatar_list" src="'.__PS_BASE_URI__.'modules/'.$this->module_name.'/views/img/agent/'.$value.'" />';
    }

    public function initContent()
    {
        if ($this->action == 'select_delete') {
            $this->context->smarty->assign(array(
                'delete_form' => true,
                'url_delete' => htmlentities($_SERVER['REQUEST_URI']),
                'boxes' => $this->boxes,
            ));
        }

        $warningError = '';
        if ($warnings = $this->module->getWarnings(false)) {
            $warningError = $this->module->displayError($warnings);
        }

        parent::initContent();

        if (Tools::getValue('action') == 'updatePositions') {
            $this->updatePositions(Tools::getValue('whatsappchatblock_agent'));
        }

        /*
        $whatsappchat = new WhatsappChatBlock((int)Tools::getValue('id_whatsappchatblock'));
        $this->content .= $this->buttonPreview($whatsappchat);
        */

        $this->context->smarty->assign(array(
            'content' => $warningError.$this->content,
        ));
    }

    public function initToolbar()
    {
        parent::initToolbar();

        if (empty($this->display)) {
            $this->toolbar_btn['new'] = array(
                'href' => 'index.php?controller='.$this->tabClassName.'&add'.$this->table.'&token='.Tools::getAdminTokenLite($this->tabClassName).'&id_whatsappchatblock='.Tools::getValue('id_whatsappchatblock'),
                'desc' => $this->l('Add new'),
                'icon' => 'process-icon-new'
            );
        }
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();

        if (empty($this->display)) {
            $this->page_header_toolbar_btn['desc-module-back'] = array(
                'href' => 'index.php?controller='.$this->mainTabClassName.'&token='.Tools::getAdminTokenLite($this->mainTabClassName),
                'desc' => $this->l('Back'),
                'icon' => 'process-icon-back'
            );

            $this->page_header_toolbar_btn['desc-module-new'] = array(
                'href' => 'index.php?controller='.$this->tabClassName.'&add'.$this->table.'&token='.Tools::getAdminTokenLite($this->tabClassName).'&id_whatsappchatblock='.Tools::getValue('id_whatsappchatblock'),
                'desc' => $this->l('New'),
                'icon' => 'process-icon-new'
            );

            /*
            $this->page_header_toolbar_btn['desc-module-translate'] = array(
                'href' => '#',
                'desc' => $this->l('Translate'),
                'modal_target' => '#moduleTradLangSelect',
                'icon' => 'process-icon-flag'
            );

            $this->page_header_toolbar_btn['desc-module-hook'] = array(
                'href' => 'index.php?tab=AdminModulesPositions&token='.Tools::getAdminTokenLite('AdminModulesPositions').'&show_modules='.Module::getModuleIdByName('whatsappchat'),
                'desc' => $this->l('Manage hooks'),
                'icon' => 'process-icon-anchor'
            );
            */
        }
    }

    public function initModal()
    {
        parent::initModal();

        $languages = Language::getLanguages(false);
        $translateLinks = array();

        if (version_compare(_PS_VERSION_, '1.7.2.1', '>=')) {
            $module = Module::getInstanceByName($this->module_name);
            $isNewTranslateSystem = $module->isUsingNewTranslationSystem();
            $link = Context::getContext()->link;
            foreach ($languages as $lang) {
                if ($isNewTranslateSystem) {
                    $translateLinks[$lang['iso_code']] = $link->getAdminLink('AdminTranslationSf', true, array(
                        'lang' => $lang['iso_code'],
                        'type' => 'modules',
                        'selected' => $module->name,
                        'locale' => $lang['locale'],
                    ));
                } else {
                    $translateLinks[$lang['iso_code']] = $link->getAdminLink('AdminTranslations', true, array(), array(
                        'type' => 'modules',
                        'module' => $module->name,
                        'lang' => $lang['iso_code'],
                    ));
                }
            }
        }

        $this->context->smarty->assign(array(
            'trad_link' => 'index.php?tab=AdminTranslations&token='.Tools::getAdminTokenLite('AdminTranslations').'&type=modules&module='.$this->module_name.'&lang=',
            'module_languages' => $languages,
            'module_name' => $this->module_name,
            'translateLinks' => $translateLinks,
        ));

        $modal_content = $this->context->smarty->fetch('controllers/modules/modal_translation.tpl');

        $this->modals[] = array(
            'modal_id' => 'moduleTradLangSelect',
            'modal_class' => 'modal-sm',
            'modal_title' => $this->l('Translate this module'),
            'modal_content' => $modal_content
        );
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->context->controller->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/whatsapp.css', 'all');
        $this->context->controller->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/bo_whatsapp.css', 'all');
        $this->context->controller->addJS(_MODULE_DIR_.$this->module->name.'/views/js/whatsappchat_back.js');
    }

    public function processAdd()
    {
        if (Tools::getValue('submitFormAjax')) {
            $this->redirect_after = false;
        }
        if (Tools::substr(Tools::getValue('image'), 0, 1) == '_') {
            $_POST['image'] = Tools::substr(Tools::getValue('image'), 1);
        }
        $processAdd = parent::processAdd();
        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            if (Tools::getValue('image') && Tools::getValue('image') != '') {
                $whatsappchat_agent = new WhatsappChatBlockAgent((int)$processAdd->id);
                if (Tools::getValue('image') == ' ') {
                    $whatsappchat_agent->image = '';
                } else {
                    if (Tools::substr($processAdd->image, 0, 1) == '_') {
                        $processAdd->image = Tools::substr($processAdd->image, 1);
                    }
                    $image = $processAdd->id.'_'.$processAdd->image;
                    $whatsappchat_agent->image = $image;
                    ImageManager::resize($_FILES['image']['tmp_name'], _PS_MODULE_DIR_.$this->module_name.'/views/img/agent/'.$image);
                }
                $whatsappchat_agent->save();
            }
        } else {
            if (Tools::getValue('filename') && Tools::getValue('filename') != '') {
                $whatsappchat_agent = new WhatsappChatBlockAgent((int)$processAdd->id);
                if (Tools::getValue('filename') == ' ') {
                    $whatsappchat_agent->image = '';
                } else {
                    if (Tools::substr($processAdd->image, 0, 1) == '_') {
                        $processAdd->image = Tools::substr($processAdd->image, 1);
                    }
                    $image = $processAdd->id.'_'.$processAdd->image;
                    $whatsappchat_agent->image = $image;
                    ImageManager::resize($_FILES['image']['tmp_name'], _PS_MODULE_DIR_.$this->module_name.'/views/img/agent/'.$image);
                }
                $whatsappchat_agent->save();
            }
        }
        return $processAdd;
    }

    public function processSave()
    {
        if (Tools::getIsset('submitAdd'.$this->table)) {
            if (Tools::getValue('image_prev') && Tools::getValue('image_prev') != '' && (Tools::getValue('image') == '' || !Tools::getValue('image'))) {
                $_POST['image'] = Tools::getValue('image_prev');
            }
        }
        return parent::processSave();
    }

    public function postProcess()
    {
        if (Tools::getIsset('submitAdd'.$this->table)) {
            if (version_compare(_PS_VERSION_, '1.6', '>=')) {
                if (Tools::getValue('image') && Tools::getValue('image') != '') {
                    if (Tools::getValue('image') == ' ') {
                        $_POST['image'] = '';
                    } else {
                        $image = Tools::getValue('id_whatsappchatblock_agent').'_'.Tools::getValue('image');
                        $_POST['image'] = $image;
                        ImageManager::resize($_FILES['image']['tmp_name'], _PS_MODULE_DIR_.$this->module_name.'/views/img/agent/'.$image);
                    }
                }
            } else {
                if (Tools::getValue('filename') && Tools::getValue('filename') != '') {
                    if (Tools::getValue('filename') == ' ') {
                        $_POST['image'] = '';
                    } else {
                        $image = Tools::getValue('id_whatsappchatblock_agent').'_'.Tools::getValue('filename');
                        $_POST['image'] = $image;
                        ImageManager::resize($_FILES['image']['tmp_name'], _PS_MODULE_DIR_.$this->module_name.'/views/img/agent/'.$image);
                    }
                }
            }
        }
        return parent::postProcess();
    }


    public function renderList()
    {
        if (!WhatsappChatBlockAgent::getNbObjects()) {
            $this->redirect_after = 'index.php?controller='.$this->tabClassName.'&add'.$this->table.'&token='.Tools::getAdminTokenLite($this->tabClassName);
            $this->redirect();
        }
        return parent::renderList();
    }

    public function renderForm()
    {
        if (!($object = $this->loadObject(true))) {
            return false;
        }

        $id_lang = (int)$this->context->language->id;

        $this->multiple_fieldsets = true;
        $this->default_form_language = $id_lang;

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Agent configuration'),
                'icon' => 'icon-wrench'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'name' => 'button_preview'
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Enabled'),
                    'name' => 'active',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                    'desc' => $this->l('Enable or disable this WhatsApp chat agent.')
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Agent name'),
                    'name'  => 'name',
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Agent department'),
                    'name'  => 'department',
                    'lang' => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Mobile phone'),
                    'name'  => 'mobile_phone',
                    'desc' => $this->l('Introduce mobile phone number with the international country code, without "+" character.').'<br />'.$this->l('Example: Introduce 341234567 for (+34) 1234567.'),
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type'  => 'file',
                    'label' => $this->l('Agent image'),
                    'name'  => 'image',
                    'display_image' => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'text',
                    'name' => 'image_prev',
                    'class' => 'hidden',
                ),
                array(
                    'type' => 'free',
                    'name' => 'image_src'
                ),
                array(
                    'type' => 'free',
                    'name' => 'delete_image'
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Schedule'),
                    'name' => 'schedule',
                    'hint' => $this->l('Select days of week and hours to show this WhatsApp chat agent.')
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_whatsappchatblock'
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'position'
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $this->context->smarty->assign(array(
            'languages' => Language::getLanguages(),
            'default_form_language' => $this->default_form_language,
        ));

        if ($object->id) {
            $this->fields_value = array(
                'schedule' => $object->schedule,
                'image_src' => ($object->image != '' && $object->image != ' ' ? '<img class="whatsappchat_avatar" src="'.__PS_BASE_URI__.'modules/'.$this->module_name.'/views/img/agent/'.$object->image.'" />' : ''),
                //'image' => ($object->image != '' && $object->image != ' ' ? $object->image : ''),
                'image_prev' => ($object->image != '' && $object->image != ' ' ? $object->image : ''),
                'delete_image' => ($object->image != '' && $object->image != ' ' ? '<a href="javascript:deleteImage();" >'.$this->l('Delete image').'</a>' : ''),
            );
            $this->context->smarty->assign(array(
                'schedule' => $object->schedule
            ));
        } else {
            $position = $this->getLastPosition($this->context->cookie->id_whatsappchatblock);
            $this->fields_value =  array(
                'id_whatsappchatblock' => $this->context->cookie->id_whatsappchatblock,
                'position' => ($position === false ? 0 : $position + 1),
            );
            $this->context->smarty->assign(array(
                'schedule' => ''
            ));
        }

        $this->fields_value = array_merge($this->fields_value, array(
            'schedule' => $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/schedule.tpl'),
        ));

        return parent::renderForm();
    }

    public function printPreview($value, $conf)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            return $value;
        }
        $module = new WhatsAppChat();
        $whatsappchat = new WhatsappChatBlock((int)$conf['id_whatsappchatblock']);
        return $module->displayBlock($whatsappchat->id_hook, true, $conf['id_whatsappchatblock']);
    }

    private function buttonPreview($object)
    {
        $module = new WhatsappChat();
        return $module->displayBlock($object->id_hook, true, $object->id_whatsappchatblock);
    }

    private function getLastPosition($id_whatsappchatblock)
    {
        return Db::getInstance()->getValue('
                SELECT position FROM `'.pSQL(_DB_PREFIX_.$this->table).'`
                WHERE `id_whatsappchatblock` = '.(int)$id_whatsappchatblock.'
                ORDER BY position DESC');
    }

    private function updatePositions($positions)
    {
        foreach ($positions as $key => $position) {
            $pos = explode('_', $position);
            Db::getInstance()->execute('
                UPDATE `'.pSQL(_DB_PREFIX_.$this->table).'`
                SET `position` = '.(int)$key.'
                WHERE `id_whatsappchatblock_agent` = '.(int)$pos[2]);
        }
        return true;
    }
}
