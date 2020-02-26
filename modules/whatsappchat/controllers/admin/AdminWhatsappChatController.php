<?php
/**
 * WhatsApp Chat
 *
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
 *  @author    idnovate
 *  @copyright 2019 idnovate
 *  @license   See above
*/

include_once(_PS_MODULE_DIR_.'whatsappchat/classes/array_column.php');

class AdminWhatsappChatController extends ModuleAdminController
{
    protected $delete_mode;
    protected $is_multishop_selected = true;
    protected $_defaultOrderBy = 'id_whatsappchatblock';
    protected $_defaultOrderWay = 'ASC';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'whatsappchatblock';
        $this->className = 'WhatsappChatBlock';
        $this->tabClassName = 'AdminWhatsappChat';
        $this->module_name = 'whatsappchat';
        $this->lang = true;

        parent::__construct();

        $this->addRowAction('edit');
        $this->addRowAction('agents');
        $this->addRowAction('duplicate');
        $this->addRowAction('delete');
        $this->allow_duplicate = true;

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

        $this->_select = '"hook_position", "show_on", "filters", "audience", "preview"';

        $this->fields_options = array(
            'general' => array(
                'title' => $this->l('General configuration'),
                'image' => '../modules/whatsappchat/logo.gif',
                'class' => (version_compare(_PS_VERSION_, '1.5', '>=')) ? 'hidden': '',
                'fields' => array(
                    'WA_CHAT_MOBILE' => array(
                        'title' => $this->l('Mobile phone number'),
                        'desc' => $this->l('Introduce mobile phone number with the international country code, without "+" character.').'<br />'.$this->l('Example: Introduce 341234567 for (+34) 1234567.'),
                        'type' => (version_compare(_PS_VERSION_, '1.5', '>=')) ? 'hidden': 'text',
                        'size' => 15,
                        'visibility' => Shop::CONTEXT_ALL
                    ),
                    'WA_FONT_AWESOME' => array(
                        'title' => $this->l('Use Font Awesome to display WhatsApp icon'),
                        'desc' => array($this->l('Enable only if your theme is compatible'),
                            $this->l('If WhatsApp icon is not shown, disable this option')),
                        'type' => (version_compare(_PS_VERSION_, '1.5', '>=')) ? 'hidden': 'text',
                        'visibility' => Shop::CONTEXT_ALL
                    ),
                    'WA_CHAT_MESSAGE' => array(
                        'title' => $this->l('Default chat message'),
                        'type' => (version_compare(_PS_VERSION_, '1.5', '>=')) ? 'hidden': 'textLang',
                        'lang' => true,
                        'size' => 50,
                        'visibility' => Shop::CONTEXT_ALL
                    ),
                ),
                'submit' => array('title' => $this->l('Save'))
            )
        );

        $this->fields_list = array(
            'id_whatsappchatblock' => array(
                'title' => $this->l('ID'),
                'align' => 'text-center center',
                'class' => 'fixed-width-xs'
            ),
            'active' => array(
                'title' => $this->l('Enabled'),
                'align' => 'text-center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!active'
            ),
            'mobile_phone' => array(
                'title' => $this->l('Phone'),
                'align' => 'text-center center',
                'callback' => 'printPhone',
            ),
            'show_on' => array(
                'title' => $this->l('Device'),
                'class' => 'fixed-width-lg',
                'callback' => 'printShowOn',
                'search' => false,
            ),
            'hook_position' => array(
                'title' => $this->l('Position'),
                'callback' => 'printHookPosition',
                'search' => false,
            ),
            'display_on' => array(
                'title' => $this->l('Display on'),
                'class' => 'fixed-width-lg',
                'callback' => 'printDisplayOn',
                'search' => false,
            ),
            /*
            'id_hook' => array(
                'title' => $this->l('Hook'),
                'callback' => 'printHookTranslation',
            ),
            'message' => array(
                'title' => $this->l('Message')
            ),
            'pos' => array(
                'title' => $this->l('Position'),
                'align' => 'text-center center',
                'callback' => 'printPositionTranslation',
            ),*/
            'audience' => array(
                'title' => $this->l('Audience'),
                'class' => 'fixed-width-lg',
                'callback' => 'printAudience',
                'search' => false,
            ),
            'chat_group' => array(
                'title' => $this->l('Chat group'),
                'align' => 'text-center center',
                'callback' => 'printEnabledDisabledIcon',
                'search' => false,
            ),
            'agents' => array(
                'title' => $this->l('Agents'),
                'align' => 'text-center center',
                'callback' => 'printAgentsIcon',
                'search' => false,
            ),
            'preview' => array(
                'title' => $this->l('Preview'),
                'align' => 'text-center center',
                'callback' => 'printPreview',
                'search' => false,
            ),
        );

        $this->shopLinkType = 'shop';

        if (Shop::isFeatureActive() && (Shop::getContext() == Shop::CONTEXT_ALL || Shop::getContext() == Shop::CONTEXT_GROUP)) {
            $this->is_multishop_selected = false;
        }

        $this->tpl_vars = array(
            'icon' => 'icon-bars',
        );
        $this->context->smarty->assign($this->tpl_vars);
    }

    public function init()
    {
        /* if (!$this->isBoLogged()) {
            die(Tools::jsonEncode(array('whatsappchat_response' => '[WhatsAppChat] Permission denied.')));
        } */
        if (Tools::isSubmit('method')) {
            switch (Tools::getValue('method')) {
                case 'getCustomerMobilePhone':
                    if (Tools::getIsset('id_order') && $id_order = Tools::getValue('id_order')) {
                        $order = new Order((int)$id_order);
                        $id_customer = $order->id_customer;
                    } else {
                        $id_customer = Tools::getValue('id_customer');
                    }
                    $address_id = Address::getFirstCustomerAddressId((int)$id_customer, true);
                    if ($address_id > 0) {
                        $address = new Address((int)$address_id);
                        $phone = $address->phone_mobile;
                        if (!Validate::isPhoneNumber($phone) || $phone == '') {
                            $phone = $address->phone;
                            if (!Validate::isPhoneNumber($phone) || $phone == '') {
                                die(Tools::jsonEncode(array('whatsappchat_response' => array(
                                    'code' => 'NOK',
                                    'url'  => '',
                                    'msg'  => Translate::getModuleTranslation($this->module_name, 'Not a valid phone number or this customer has no mobile phone.', $this->tabClassName)
                                )
                                )));
                            }
                        }
                        $module = new WhatsAppChat();
                        $phone = $module->formatMobilePhoneForWhatsapp($phone, $address->id_country);
                        die(Tools::jsonEncode(array('whatsappchat_response' => array(
                            'code' => 'OK',
                            'url'  => $module->getWhatsappUrl($phone),
                            'msg'  => ''
                        )
                        )));
                    } else {
                        die(Tools::jsonEncode(array('whatsappchat_response' => array(
                            'code' => 'NOK',
                            'url'  => '',
                            'msg'  => Translate::getModuleTranslation($this->module_name, 'Not a valid phone number or this customer has no mobile phone.', $this->tabClassName)
                        )
                        )));
                    }
                    break;
                case 'entity':
                    if (is_numeric(Tools::getValue('entity'))) {
                        die(json_encode(WhatsAppChat::getDisplayOnSelection(Tools::getValue('entity'))));
                    } elseif (Tools::getValue('entity') === 'products') {
                        die(json_encode(WhatsAppChat::getProductsLite($this->context->language->id, true, true)));
                    } elseif (Tools::getValue('entity') === 'manufacturers') {
                        die(json_encode(Manufacturer::getManufacturers(false, $this->context->language->id, false)));
                    } elseif (Tools::getValue('entity') === 'suppliers') {
                        die(json_encode(Supplier::getSuppliers(false, $this->context->language->id, false)));
                    } elseif (Tools::getValue('entity') === 'customers') {
                        die(json_encode(Customer::getCustomers(true)));
                    }
                    break;
                default:
                    break;
            }
        } else {
            parent::init();
        }
    }

    public function printHookPosition($value, $config)
    {
        $tpl = $this->context->smarty->createTemplate(
            _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin/'.$this->module_name.'/helpers/list/list_hook_position.tpl'
        );
        $tpl->assign(array(
            'hook_position' => $this->printHookTranslation($config['id_hook']),
            'horizontal_pos' => $this->printPositionTranslation($config['pos']),
            'pos_id' => $config['pos'],
        ));
        return $tpl->fetch();
    }

    public function printHookTranslation($value)
    {
        $whatsappchat = new WhatsappChat();
        $hooks = $whatsappchat->getAvailableHooks();
        $key = array_search($value, array_column($hooks, 'id'));
        return $hooks[$key]['name'];
    }

    public function printPositionTranslation($value)
    {
        switch ($value) {
            case 'left':
                $value = $this->l('Left');
                break;
            case 'center':
                $value = $this->l('Center');
                break;
            case 'right':
                $value = $this->l('Right');
                break;
            case 'bottom-left':
                $value = $this->l('Bottom left');
                break;
            case 'bottom-right':
                $value = $this->l('Bottom right');
                break;
            case 'top-right':
                $value = $this->l('Top right');
                break;
            case 'top-left':
                $value = $this->l('Top left');
                break;
        }

        return $value;
    }

    public function printDisplayOn($value, $config)
    {
        $tpl = $this->context->smarty->createTemplate(
            _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin/'.$this->module_name.'/helpers/list/list_display_on.tpl'
        );
        $module = new WhatsAppChat();
        $display_on_options = $module->getDisplayOnOptions();
        $display_on_selection = explode(';', $config['display_on_selection']);
        $selections = array();
        switch ($value) {
            case '2': //Products
                foreach ($display_on_selection as $item) {
                    $product = new Product((int)$item);
                    $selections[] = $product->name[$this->context->language->id];
                }
                break;
            case '4': //Categories
                foreach ($display_on_selection as $item) {
                    $category = new Category((int)$item);
                    $selections[] = $category->name[$this->context->language->id];
                }
                break;
            case '6': //CMS pages
                foreach ($display_on_selection as $item) {
                    $cms = new CMS((int)$item);
                    $selections[] = $cms->meta_title[$this->context->language->id];
                }
                break;
            case '8': //Manufacturers
                foreach ($display_on_selection as $item) {
                    $manufacturer = new Manufacturer((int)$item);
                    $selections[] = $manufacturer->name;
                }
                break;
            case '10': //Suppliers
                foreach ($display_on_selection as $item) {
                    $supplier = new Supplier((int)$item);
                    $selections[] = $supplier->name;
                }
                break;
            case '11': //Other pages
                foreach ($display_on_selection as $item) {
                    $page = Meta::getMetaByPage($item, $this->context->language->id);
                    if ($page['title'] == '') {
                        if ($page['page'] === 'index') {
                            $selections[] = $module->l('Home page');
                        } else {
                            $selections[] = $page['page'];
                        }
                    } else {
                        $selections[] = $page['title'];
                    }
                }
                break;
            default:
                break;
        }
        $tpl->assign(array(
            'display_on_selection_all' => implode('<br/>', $selections),
        ));
        $nb_selections = (int)count($selections);
        if ($nb_selections > 5) {
            $selections = array_slice($selections, 0, 5);
            $selections[] = sprintf($this->l('and %s more.'), $nb_selections - 5);
        }
        $tpl->assign(array(
            'entity' => $value,
            'display_on' => $display_on_options[$value],
            'display_on_selection' => implode('<br/>', $selections),
        ));
        return $tpl->fetch();
    }

    public function printPreview($value, $conf)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            return $value;
        }
        $module = new WhatsAppChat();
        if (!$module->isShowableBySchedule($conf) && trim($conf['offline_message'] == '')) {
            return '<span style="color:#fff;background-color: red;padding: 4px;border-radius: 5px;font-size: larger;">'.$this->l('Button offline').'</span>';
        }
        return $module->displayBlock($conf['id_hook'], true, $conf['id_whatsappchatblock']);
    }

    public function printEnabledDisabledIcon($value, $config)
    {
        $this->context->smarty->assign(array(
            'value' => (bool)$value
        ));
        return $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/enabled.tpl');
    }

    public function printPhone($value, $config)
    {
        $tpl = $this->context->smarty->createTemplate(
            _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin/'.$this->module_name.'/helpers/list/list_phone.tpl'
        );
        $tpl->assign(array(
            'config' => $config,
            'value' => $value,
        ));
        return $tpl->fetch();
    }

    public function printShowOn($value, $config)
    {
        $tpl = $this->context->smarty->createTemplate(
            _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin/'.$this->module_name.'/helpers/list/list_show_on.tpl'
        );
        $tpl->assign(array(
            'config' => $config,
            'value' => $value,
        ));
        return $tpl->fetch();
    }

    public function printAudience($value, $config)
    {
        $text = '';
        if ($config['customers'] == '' || $config['customers'] == 'all') {
            $text .= '<li>'.$this->l('All customers').'</li>';
        } else {
            $text .= '<li>'.$this->l('Customer:').' ';
            foreach (explode(';', $config['customers']) as $value) {
                $customer = new Customer((int)$value);
                $text .= $customer->firstname.' '.$customer->lastname.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        if ($config['customer_groups'] == '' || $config['customer_groups'] == 'all') {
            $text .= '<li>'.$this->l('All customer groups').'</li>';
        } else {
            $text .= '<li>'.$this->l('Group:').' ';
            foreach (explode(';', $config['customer_groups']) as $value) {
                $group = new Group((int)$value, $this->context->language->id, $this->context->shop->id);
                $text .= $group->name.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        if ($config['currencies'] == '' || $config['currencies'] == 'all') {
            $text .= '<li>'.$this->l('All currencies').'</li>';
        } else {
            $text .= '<li>'.$this->l('Currency:').' ';
            foreach (explode(';', $config['currencies']) as $value) {
                $currency = new Currency((int)$value, $this->context->language->id, $this->context->shop->id);
                $text .= $currency->iso_code.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        if ($config['languages'] == '' || $config['languages'] == 'all') {
            $text .= '<li>'.$this->l('All languages').'</li>';
        } else {
            $text .= '<li>'.$this->l('Language:').' ';
            foreach (explode(';', $config['languages']) as $value) {
                $language = new Language((int)$value, $this->context->language->id);
                $text .= $language->locale.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        if ($config['zones'] == '' || $config['zones'] == 'all') {
            $text .= '<li>'.$this->l('All zones').'</li>';
        } else {
            $text .= '<li>'.$this->l('Zone:').' ';
            foreach (explode(';', $config['zones']) as $value) {
                $zone = new Zone((int)$value);
                $text .= $zone->name.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        if ($config['countries'] == '' || $config['countries'] == 'all') {
            $text .= '<li>'.$this->l('All countries').'</li>';
        } else {
            $text .= '<li>'.$this->l('Country:').' ';
            foreach (explode(';', $config['countries']) as $value) {
                $country = new Country((int)$value, $this->context->language->id, $this->context->shop->id);
                $text .= $country->name.',';
            }
            $text = Tools::rtrimString($text, ',').'</li>';
        }
        return $text;
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

        if ((Tools::getValue('id_'.$this->table)) && Tools::getIsset('duplicate'.$this->table)) {
            $this->processDuplicate();
        }

        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            $whatsapp = new WhatsAppChat();
            $this->context->smarty->assign(array(
                'this_path'     => $this->module->getPathUri(),
                'support_id'    => $whatsapp->addons_id_product
            ));

            $available_iso_codes = array('en', 'es');
            $default_iso_code = 'en';
            $template_iso_suffix = in_array($this->context->language->iso_code, $available_iso_codes) ? $this->context->language->iso_code : $default_iso_code;
            $this->content .= $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/company/information_'.$template_iso_suffix.'.tpl');
        }

        $this->context->smarty->assign(array(
            'content' => $warningError.$this->content,
        ));
    }

    public function initToolbar()
    {
        parent::initToolbar();

        if (!$this->is_multishop_selected) {
            unset($this->toolbar_btn['new']);
        }
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();

        if (empty($this->display)) {
            $this->page_header_toolbar_btn['desc-module-new'] = array(
                'href' => 'index.php?controller='.$this->tabClassName.'&add'.$this->table.'&token='.Tools::getAdminTokenLite($this->tabClassName),
                'desc' => $this->l('New'),
                'icon' => 'process-icon-new'
            );

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
        }

        if (!$this->is_multishop_selected) {
            unset($this->page_header_toolbar_btn['desc-module-new']);
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
        $this->addJqueryPlugin(array('typewatch', 'fancybox', 'autocomplete'));
        $this->addJqueryUI('ui.button');
        $this->addJqueryUI('ui.sortable');
        $this->addJqueryUI('ui.droppable');
        $this->context->controller->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/whatsapp.css', 'all');
        $this->context->controller->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/bo_whatsapp.css', 'all');
        $this->context->controller->addCSS(_MODULE_DIR_.$this->module->name.'/views/css/jBox.min.css');
        $this->context->controller->addJS(_MODULE_DIR_.$this->module->name.'/views/js/whatsappchat_back.js');
        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            if ($this->display) {
                $this->context->controller->addJS(_MODULE_DIR_.$this->module->name.'/views/js/tabs.js');
            }
        }
        Media::addJsDef(array ('AdminWhatsappChatController' => $this->context->link->getAdminLink('AdminWhatsappChat')));
        $this->context->controller->addJS(_MODULE_DIR_.$this->module->name.'/views/js/jBox.min.js');
    }

    public function processSave()
    {
        $_POST['positions'] = (is_array(Tools::getValue('positions')) ? (in_array('all', Tools::getValue('positions')) ? 'all' : implode(';', Tools::getValue('positions'))) : (Tools::getValue('positions') == '' ? 'all' : Tools::getValue('positions')));
        $_POST['display_on_selection'] = (is_array(Tools::getValue('display_on_selection')) ? (in_array('all', Tools::getValue('display_on_selection')) ? 'all' : implode(';', Tools::getValue('display_on_selection'))) : (Tools::getValue('display_on_selection') == '' ? 'all' : Tools::getValue('display_on_selection')));
        $_POST['customer_groups'] = (is_array(Tools::getValue('customer_groups')) ? (in_array('all', Tools::getValue('customer_groups')) ? 'all' : implode(';', Tools::getValue('customer_groups'))) : (Tools::getValue('customer_groups') == '' ? 'all' : Tools::getValue('customer_groups')));
        $_POST['customers'] = (is_array(Tools::getValue('customers')) ? (in_array('all', Tools::getValue('customers')) ? 'all' : implode(';', Tools::getValue('customers'))) : (Tools::getValue('customers') == '' ? 'all' : Tools::getValue('customers')));
        $_POST['countries'] = (is_array(Tools::getValue('countries')) ? (in_array('all', Tools::getValue('countries')) ? 'all' : implode(';', Tools::getValue('countries'))) : (Tools::getValue('countries') == '' ? 'all' : Tools::getValue('countries')));
        $_POST['zones'] = (is_array(Tools::getValue('zones')) ? (in_array('all', Tools::getValue('zones')) ? 'all' : implode(';', Tools::getValue('zones'))) : (Tools::getValue('zones') == '' ? 'all' : Tools::getValue('zones')));
        $_POST['languages'] = (is_array(Tools::getValue('languages')) ? (in_array('all', Tools::getValue('languages')) ? 'all' : implode(';', Tools::getValue('languages'))) : (Tools::getValue('languages') == '' ? 'all' : Tools::getValue('languages')));
        $_POST['currencies'] = (is_array(Tools::getValue('currencies')) ? (in_array('all', Tools::getValue('currencies')) ? 'all' : implode(';', Tools::getValue('currencies'))) : (Tools::getValue('currencies') == '' ? 'all' : Tools::getValue('currencies')));
        $_POST['color'] = (Tools::getValue('color') == '' ? '#25d366' : Tools::getValue('color'));
        $_POST['chat_group'] = (Tools::getValue('chat_group') == '' ? '' : Tools::getValue('chat_group'));
        $_POST['schedule'] = (Tools::getValue('schedule') == '' ? '' : Tools::getValue('schedule'));
        return parent::processSave();
    }

    public function processUpdate()
    {
        if (Validate::isLoadedObject($this->object)) {
            $_POST['positions'] = (is_array(Tools::getValue('positions')) ? (in_array('all', Tools::getValue('positions')) ? 'all' : implode(';', Tools::getValue('positions'))) : (Tools::getValue('positions') == '' ? 'all' : Tools::getValue('positions')));
            $_POST['display_on_selection'] = (is_array(Tools::getValue('display_on_selection')) ? (in_array('all', Tools::getValue('display_on_selection')) ? 'all' : implode(';', Tools::getValue('display_on_selection'))) : (Tools::getValue('display_on_selection') == '' ? 'all' : Tools::getValue('display_on_selection')));
            $_POST['customer_groups'] = (is_array(Tools::getValue('customer_groups')) ? (in_array('all', Tools::getValue('customer_groups')) ? 'all' : implode(';', Tools::getValue('customer_groups'))) : (Tools::getValue('customer_groups') == '' ? 'all' : Tools::getValue('customer_groups')));
            $_POST['customers'] = (is_array(Tools::getValue('customers')) ? (in_array('all', Tools::getValue('customers')) ? 'all' : implode(';', Tools::getValue('customers'))) : (Tools::getValue('customers') == '' ? 'all' : Tools::getValue('customers')));
            $_POST['countries'] = (is_array(Tools::getValue('countries')) ? (in_array('all', Tools::getValue('countries')) ? 'all' : implode(';', Tools::getValue('countries'))) : (Tools::getValue('countries') == '' ? 'all' : Tools::getValue('countries')));
            $_POST['zones'] = (is_array(Tools::getValue('zones')) ? (in_array('all', Tools::getValue('zones')) ? 'all' : implode(';', Tools::getValue('zones'))) : (Tools::getValue('zones') == '' ? 'all' : Tools::getValue('zones')));
            $_POST['languages'] = (is_array(Tools::getValue('languages')) ? (in_array('all', Tools::getValue('languages')) ? 'all' : implode(';', Tools::getValue('languages'))) : (Tools::getValue('languages') == '' ? 'all' : Tools::getValue('languages')));
            $_POST['currencies'] = (is_array(Tools::getValue('currencies')) ? (in_array('all', Tools::getValue('currencies')) ? 'all' : implode(';', Tools::getValue('currencies'))) : (Tools::getValue('currencies') == '' ? 'all' : Tools::getValue('currencies')));
            $_POST['color'] = (Tools::getValue('color') == '' ? '#25d366' : Tools::getValue('color'));
            $_POST['chat_group'] = (Tools::getValue('chat_group') == '' ? '' : Tools::getValue('chat_group'));
            $_POST['schedule'] = (Tools::getValue('schedule') == '' ? '' : Tools::getValue('schedule'));
            if (version_compare(_PS_VERSION_, '1.6.1', '<')) {
                $whatsappchatblock = new WhatsappChatBlock((int)$this->object->id_whatsappchatblock);
                foreach (Language::getIsoIds(false) as $lang) {
                    $id_lang = $lang['id_lang'];
                    $whatsappchatblock->mobile_phone[$id_lang] = Tools::getValue('mobile_phone_'.$id_lang);
                    $whatsappchatblock->message[$id_lang] = Tools::getValue('message_'.$id_lang);
                    $whatsappchatblock->def_message[$id_lang] = Tools::getValue('def_message_'.$id_lang);
                    $whatsappchatblock->offline_message[$id_lang] = Tools::getValue('offline_message_'.$id_lang);
                    $whatsappchatblock->offline_link[$id_lang] = Tools::getValue('offline_link_'.$id_lang);
                }
                $whatsappchatblock->save();
            }
        } else {
            $this->errors[] = Tools::displayError('An error occurred while loading the object.');
        }
        return parent::processUpdate();
    }

    public function processDuplicate()
    {
        try {
            $id_conf = Tools::getValue($this->identifier);
            $conf = new WhatsappChatBlock($id_conf);
            unset($conf->id_whatsappchatblock);
            if (!$conf->add()) {
                $this->errors[] = Tools::displayError('An error occurred while duplicating WhatsApp configuration #'.$id_conf);
            } else {
                $this->confirmations[] = sprintf($this->l('WhatsApp configuration #%s successfully duplicated.'), $id_conf);
                $this->afterUpdate($conf, $conf->id);
                if (version_compare(_PS_VERSION_, '1.6', '<')) {
                    Tools::redirectAdmin('index.php?tab='.$this->tabClassName.'&token='.Tools::getAdminTokenLite($this->tabClassName));
                } else {
                    Tools::redirectAdmin('index.php?controller='.$this->tabClassName.'&token='.Tools::getAdminTokenLite($this->tabClassName));
                }
            }
        } catch (exception $e) {
            $this->errors[] = Tools::displayError('An error occurred while duplicating WhatsApp configuration #'.$id_conf);
        }
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAdd'.$this->table)) {
            if (($object = $this->loadObject(true)) || Validate::isLoadedObject($object)) {
                if (version_compare(_PS_VERSION_, '1.6.1', '<')) {
                    $object = parent::postProcess();
                    $whatsappchatblock = new WhatsappChatBlock((int)$object->id);
                    foreach (Language::getIsoIds(false) as $lang) {
                        $id_lang = $lang['id_lang'];
                        $whatsappchatblock->mobile_phone[$id_lang] = Tools::getValue('mobile_phone_'.$id_lang);
                        $whatsappchatblock->message[$id_lang] = Tools::getValue('message_'.$id_lang);
                        $whatsappchatblock->def_message[$id_lang] = Tools::getValue('def_message_'.$id_lang);
                        $whatsappchatblock->offline_message[$id_lang] = Tools::getValue('offline_message_'.$id_lang);
                        $whatsappchatblock->offline_link[$id_lang] = Tools::getValue('offline_link_'.$id_lang);
                    }
                    $whatsappchatblock->save();
                } else {
                    return parent::postProcess();
                }
            } else {
                return parent::postProcess();
            }
        } else {
            return parent::postProcess();
        }
    }

    public function renderList()
    {
        //Redirect if no button is created
        if (!WhatsappChatBlock::getNbObjects()) {
            //Tools::redirectAdmin('index.php?controller=AdminWhatsappChat&add'.$this->table.'&token='.Tools::getAdminTokenLite('AdminWhatsappChat'));
            $this->redirect_after = 'index.php?controller='.$this->tabClassName.'&add'.$this->table.'&token='.Tools::getAdminTokenLite($this->tabClassName);
            $this->redirect();
        }
        return parent::renderList();
    }

    public function renderForm()
    {
        if (!($conf = $this->loadObject(true))) {
            return '';
        }

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $id_lang = (int)$this->context->cookie->id_lang;
            $id_shop = (int)$this->context->cookie->id_shop;
            $currencies = Currency::getCurrencies(false, true);
        } else {
            $id_lang = (int)$this->context->language->id;
            $id_shop = (int)$this->context->shop->id;
            if (Shop::isFeatureActive()) {
                $currencies = Currency::getCurrenciesByIdShop($this->context->shop->id);
            } else {
                $currencies = Currency::getCurrencies(false, true);
            }
        }

        $groups = Group::getGroups($id_lang, true);
        $countries = Country::getCountries($id_lang);
        $zones = Zone::getZones();
        /*if ($conf->filter_by_manufacturer) {
            $manufacturers = Manufacturer::getManufacturers(false, $id_lang, false);
        } else {
            $manufacturers = array();
        }
        if ($conf->filter_by_supplier) {
            $suppliers = Supplier::getSuppliers(false, $id_lang, false);
        } else {
            $suppliers = array();
        }*/
        $languages = Language::getLanguages(false, $id_shop);

        $this->multiple_fieldsets = true;
        $this->default_form_language = $id_lang;

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('General chat button configuration'),
                'icon' => 'icon-wrench'
            ),
            'description' => $this->l('Leaving blank "Phone" and "Message to display" (both) in a specific language, will hide this chat button for this language.'),
            'input' => array(
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
                    'desc' => $this->l('Enable or disable this WhatsApp chat.')
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Mobile phone number'),
                    'name'  => 'mobile_phone',
                    'lang' => true,
                    'desc' => $this->l('Introduce mobile phone number with the international country code, without "+" character.').'<br />'.$this->l('Example: Introduce 341234567 for (+34) 1234567.'),
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Chat group Id'),
                    'name'  => 'chat_group',
                    'desc' => array($this->l('Identification of the WhatsApp chat group. If defined, will open the group and will offer  to the customer to join it.'),
                        $this->l('You can obtain this Id going to the Info group - add participant - Invite to group via link. You can find identification needed in https://chat.whatsapp.com/xxxxxx where xxxxxx it is the Id.')
                    ),
                    'col'   => 3,
                    'class' => 't',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Predefined message to send'),
                    'name' => 'def_message',
                    'size' => 40,
                    'col' => '3',
                    'lang' => true,
                    'desc' => $this->l('Predefined message to open WhatsApp chat.'),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Enable share option?'),
                    'name' => 'share_option',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'share_option_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'share_option_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    'desc' => array($this->l('With this option enabled, message text from WhatsApp chat opened will be filled with current URL address.'),
                        $this->l('With mobile phone number filled above, URL address will be shared to this number. Without mobile phone, will be shared with customer WhatsApp contact list.'))
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $product = new Product((int)$this->getLastProduct($id_lang));
        $category = new Category((int)$product->id_category_default);
        $cms_pages = WhatsAppChat::getDisplayOnSelection(6);
        $manufacturers_pages = WhatsAppChat::getDisplayOnSelection(8);
        $suppliers_pages = WhatsAppChat::getDisplayOnSelection(10);
        $other_pages = WhatsAppChat::getDisplayOnSelection(11);
        $this->context->smarty->assign(array(
            'id_whatsappchatblock' => Tools::getValue('id_whatsappchatblock') ? Tools::getValue('id_whatsappchatblock') : 'X',
            'AdminWhatsappChatController' => $this->context->link->getAdminLink('AdminWhatsappChat'),
            'whatsappchat_homepage' => $this->context->shop->getBaseURL().'?show_whatsapp=1',
            'whatsappchat_categorypage' => $category->getLink().'?show_whatsapp=1',
            'whatsappchat_productpage' => $product->getLink().'?show_whatsapp=1',
            'whatsappchat_cartpage' => $this->context->link->getPageLink('cart', null, 1, array('action' => 'show', 'show_whatsapp' => '1')),
            'whatsappchat_manufacturerpage' => count($manufacturers_pages) > 0 ? end($manufacturers_pages) : false,
            'whatsappchat_supplierpage' => count($suppliers_pages) > 0 ? end($suppliers_pages) : false,
            'whatsappchat_cmspages' => $cms_pages,
            'whatsappchat_otherpages' => $other_pages,
        ));
        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Display on (where will be shown the chat button)'),
                'icon' => 'icon-th'
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Hook position'),
                    'name' => 'id_hook',
                    'class' => 't fixed-width-xxl',
                    'required' => true,
                    'col' => '7',
                    'options' => array(
                        'query' => $this->module->getAvailableHooks(),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => array(
                        $this->l('Select the position you want to show the chat button'),
                        $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/positions_help.tpl')
                    ),
                ),
                array(
                    'col' => 9,
                    'type' => 'free',
                    'name' => 'hook_position',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Horizontal position'),
                    'name' => 'pos',
                    'class' => 't',
                    'col' => '4',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'bottom-left',
                                'name' => $this->l('Bottom left')
                            ),
                            array(
                                'id' => 'bottom-right',
                                'name' => $this->l('Bottom right')
                            ),
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center')
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right')
                            ),
                            array(
                                'id' => 'top-left',
                                'name' => $this->l('Top left')
                            ),
                            array(
                                'id' => 'top-right',
                                'name' => $this->l('Top right')
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Display on'),
                    'name' => 'display_on',
                    'required' => false,
                    'col' => '5',
                    'options' => array(
                        'query' => $this->module->getDisplayOnOptions(),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => array($this->l('Select page or pages where to show the chat button'),
                        $this->l('Must be compatible with previous "Hook position" configuration')),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Display on selection'),
                    'name' => 'display_on_selection[]',
                    'class' => 'multiple_select toggle_display_on',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $this->module->getDisplayOnSelection($conf->display_on ? $conf->display_on : false),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => array($this->l('Specify products, categories, pages,... where to show the chat button')),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Show on mobile'),
                    'name' => 'only_mobile',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'only_mobile_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'only_mobile_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    'desc' => $this->l('Show on mobile devices.')
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Show on tablet'),
                    'name' => 'only_tablet',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'only_tablet_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'only_tablet_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    'desc' => $this->l('Show on tablet devices.')
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Show on desktop'),
                    'name' => 'only_desktop',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'only_desktop_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'only_desktop_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    'desc' => $this->l('Show on desktop devices.')
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Target filters (who will see the chat button)'),
                'icon' => 'icon-globe'
            ),
            'input' => array(
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Filter by customer'),
                    'name' => 'filter_by_customer',
                    'class' => 't',
                    'col' => '5',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'filter_by_customer_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'filter_by_customer_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                    'desc' => $this->l('Enable if you want to filter by specific customers'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Customer(s)'),
                    'name' => 'customers[]',
                    'class' => 'multiple_select toggle_filter_by_customer',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $conf->filter_by_customer ? Customer::getCustomers(true) : array(),
                        'id' => 'id_customer',
                        'name' => 'email'
                    ),
                    'desc' => $this->l('Select the Customer(s) where the configuration will be applied. If you don\'t select any value, the configuration will be applied to all Customers'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Customer group(s)'),
                    'name' => 'customer_groups[]',
                    'class' => 'multiple_select',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $groups,
                        'id' => 'id_group',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Select the Customer Group(s) where the configuration will be applied. If you don\'t select any value, the configuration will be applied to all Groups'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Currency(es)'),
                    'name' => 'currencies[]',
                    'class' => 'multiple_select',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $currencies,
                        'id' => 'id_currency',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Currency(es) to apply this configuration'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Language(s)'),
                    'name' => 'languages[]',
                    'class' => 'multiple_select',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $languages,
                        'id' => 'id_lang',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Select the Language(s) where the configuration will be applied. If you don\'t select any value, the configuration will be applied to all Languages'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Zone(s)'),
                    'name' => 'zones[]',
                    'class' => 'multiple_select',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $zones,
                        'id' => 'id_zone',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Select the Zone(s) where the configuration will be applied. If you don\'t select any value, the configuration will be applied to all Zones'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Select Country(s)'),
                    'name' => 'countries[]',
                    'class' => 'multiple_select',
                    'multiple' => true,
                    'required' => false,
                    'col' => '7',
                    'options' => array(
                        'query' => $countries,
                        'id' => 'id_country',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Select the Country(s) where the configuration will be applied. If you don\'t select any value, the configuration will be applied to all Countries'),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Design options (Button text, color, custom CSS style, custom JS code,...)'),
                'icon' => 'icon-picture'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Button text'),
                    'name' => 'message',
                    'size' => 40,
                    'col' => '3',
                    'lang' => true,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Color'),
                    'name' => 'color',
                    'size' => 30,
                    'desc' => array(
                        $this->l('Choose a color with the color picker, or enter an HTML color (e.g. "lightblue", "#CC6600").'),
                        $this->l('Leave blank for default WhatsApp color.')
                    )
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Custom CSS'),
                    'name' => 'custom_css',
                    'cols' => 40,
                    'rows' => 5,
                    'desc' => $this->l('Custom CSS styles. This will override other defined css classes.')
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Custom JS'),
                    'name' => 'custom_js',
                    'cols' => 40,
                    'rows' => 5,
                    'desc' => $this->l('Custom JavaScript code. For example, you can add here Google Analytics code to track button event clicks.')
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $this->fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Schedule'),
                'icon' => 'icon-time'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => $this->l('Schedule'),
                    'name' => 'schedule',
                    'hint' => $this->l('Select days of week and hours to show this WhatsApp chat contact button.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Offline message'),
                    'name' => 'offline_message',
                    'size' => 40,
                    'col' => '5',
                    'lang' => true,
                    'desc' => $this->l('Offline message to show out of time. Leave blank to not show the button out of time.'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Offline link'),
                    'name' => 'offline_link',
                    'size' => 40,
                    'col' => '5',
                    'lang' => true,
                    'desc' => $this->l('Offline link to go when out of time (contact page, for example). Leave blank to not link.'),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
            ),
        );

        $agents_obj = new WhatsappChatBlockAgent();
        if ($conf->id) {
            $agents = $agents_obj->getWhatsappChatAgents($conf->id);
            foreach ($agents as $key => $agent) {
                $agents[$key]['edit'] = 'index.php?controller=AdminWhatsappChatAgent&token='.Tools::getAdminTokenLite('AdminWhatsappChatAgent').'&id_whatsappchatblock_agent='.$agent['id_whatsappchatblock_agent'].'&updatewhatsappchatblock_agent=1';
                $agents[$key]['url'] = $this->module->getWhatsappUrl($agent['mobile_phone']);
                if ($agent['image'] == '') {
                    $agents[$key]['image'] = 'agent_2.jpg';
                }
            }
            $this->fields_form[]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Agents'),
                    'icon' => 'icon-users'
                ),
                'input' => array(
                    array(
                        'type' => 'free',
                        'label' => '',
                        'name' => 'agents',
                        'col' => 12
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type' => 'submit',
                ),
            );
        } else {
            $agents = false;
        }

        $this->context->smarty->assign(array(
            'languages' => Language::getLanguages(),
            'default_form_language' => $this->default_form_language,
        ));

        if ($conf->id) {
            $this->fields_value =  array(
                'id_hook' => $conf->id_hook,
                'message' => $conf->message,
                'mobile_phone' => $conf->mobile_phone,
                'schedule' => $conf->schedule,
                'positions[]' => explode(';', $conf->positions),
                'customer_groups[]' => explode(';', $conf->customer_groups),
                'customers[]' => explode(';', $conf->customers),
                'countries[]' => explode(';', $conf->countries),
                'zones[]' => explode(';', $conf->zones),
                'languages[]' => explode(';', $conf->languages),
                'currencies[]' => explode(';', $conf->currencies),
                'display_on_selection[]' => explode(';', $conf->display_on_selection)
            );
            $this->context->smarty->assign(array(
                'schedule' => $conf->schedule,
                'agents' => $agents,
                'agents_img_dir' => __PS_BASE_URI__.'modules/'.$this->module_name.'/views/img/agent/',
                'agents_img_default' => __PS_BASE_URI__.'modules/'.$this->module_name.'/views/img/agent/agent_2.jpg',
                'agents_new_agent_url' => 'index.php?controller=AdminWhatsappChatAgent&token='.Tools::getAdminTokenLite('AdminWhatsappChatAgent').'&addwhatsappchatblock_agent&id_whatsappchatblock='.$conf->id,
            ));
        } else {
            $this->context->smarty->assign(array(
                'agents' => false,
                'schedule' => ''
            ));
            $this->fields_value =  array(
                'active' => 1,
                'only_desktop' => 1,
                'only_mobile' => 1,
                'only_tablet' => 1
            );
        }

        $this->fields_value = array_merge($this->fields_value, array(
            'hook_position' => $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/view_hook_position.tpl'),
            //'general_help' => $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/general_help.tpl'),
            'agents' => $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/agents.tpl'),
            'schedule' => $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/schedule.tpl'),
        ));

        $this->content .= parent::renderForm();
        $this->content .= $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/translations.tpl');
        $this->content .= $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/multiselect.tpl');
        return '';
    }

    public function displayAgentsLink($token, $id)
    {
        $module = new WhatsAppChat();
        return $module->displayAgentsLink($token, $id);
    }

    public static function getLastProduct($id_lang)
    {
        $front = true;
        $sql = 'SELECT p.`id_product`
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                WHERE pl.`id_lang` = '.(int)$id_lang.' AND product_shop.`active` = 1 
                '.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
                ORDER BY p.`id_product` DESC';
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }

    private function isBoLogged()
    {
        $cookie = new Cookie('psAdmin', '', (int)Configuration::get('PS_COOKIE_LIFETIME_BO'));
        $employee = new Employee((int)$cookie->id_employee);
        if (Validate::isLoadedObject($employee) && $employee->checkPassword((int)$cookie->id_employee, $cookie->passwd)
            && (!isset($cookie->remote_addr) || $cookie->remote_addr == ip2long(Tools::getRemoteAddr()) || !Configuration::get('PS_COOKIE_CHECKIP'))) {
            return true;
        } else {
            return false;
        }
    }
}
