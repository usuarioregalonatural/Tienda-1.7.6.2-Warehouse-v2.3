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

include_once(_PS_MODULE_DIR_.'whatsappchat/classes/WhatsappChatBlock.php');
include_once(_PS_MODULE_DIR_.'whatsappchat/classes/WhatsappChatBlockAgent.php');

class WhatsAppChat extends Module
{
    public function __construct()
    {
        $this->name = 'whatsappchat';
        $this->tab = 'front_office_features';
        $this->version = '1.9.1';
        $this->author = 'idnovate';
        $this->bootstrap = true;
        $this->module_key = 'fb00ab599d53a30abdaeae23c95fc2a7';
        $this->author_address = '0xd89bcCAeb29b2E6342a74Bc0e9C82718Ac702160';
        $this->addons_id_product = '26395';

        parent::__construct();

        $this->displayName = $this->l('WhatsApp Chat - Live chat with your customers');
        $this->description = $this->l('Chat with your customers through WhatsApp, the most popular messaging app');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall module?');

        /* Backward compatibility */
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
            $this->local_path = _PS_MODULE_DIR_.$this->name.'/';
        }

        /* Mobile detect library */
        if (!class_exists('Mobile_Detect')) {
            if (version_compare(_PS_VERSION_, '1.5', '<')) {
                include_once(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/Mobile_Detect.php');
            } elseif (version_compare(_PS_VERSION_, '1.7', '>=')) {
                include_once(_PS_VENDOR_DIR_.'mobiledetect/mobiledetectlib/Mobile_Detect.php');
            } else {
                include_once(_PS_TOOL_DIR_.'mobile_Detect/Mobile_Detect.php');
            }
        }

        $this->warning = $this->getWarnings(false);
    }

    public function install()
    {
        $result = true;

        $result &= parent::install()
            && $this->createDb()
            && $this->registerHook('header')
            && $this->registerHook('footer')
            && $this->registerHook('leftColumn')
            && $this->registerHook('rightColumn')
            && $this->registerHook('top')
            && $this->registerHook('home')
            && $this->registerHook('shoppingCart')
            && $this->registerHook('shoppingCartExtra')
            && $this->registerHook('paymentTop')
            && $this->registerHook('beforeCarrier')
            && $this->registerHook('customerAccount')
            && $this->registerHook('myAccountBlock')
            && $this->registerHook('orderConfirmation')
            && $this->registerHook('backOfficeHeader')
            && $this->registerHook('displayProductAdditionalInfo')
            && $this->registerHook('displayWhatsAppChat');

        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $result &= $this->installTabs()
                && $this->registerHook('displayBanner')
                && $this->registerHook('displayTopColumn')
                && $this->registerHook('displayNav')
                && $this->registerHook('displayProductActions')
                && $this->registerHook('displayProductButtons')
                && $this->registerHook('displayWhatsAppProductSocialButtons')
                && $this->registerHook('displayLeftColumnProduct')
                && $this->registerHook('displayRightColumnProduct')
                && $this->registerHook('displayFooterProduct')
                && $this->registerHook('displayShoppingCartFooter')
                && $this->registerHook('displayCustomerAccountForm')
                && $this->registerHook('displayCustomerAccountFormTop')
                && $this->registerHook('displayCustomerIdentityForm')
                && $this->registerHook('displayWrapperBottom')
                && $this->registerHook('displayMaintenance');
        } else {
            $result &= $this->registerHook('extraLeft')
                && $this->registerHook('extraRight')
                && $this->registerHook('productActions')
                && $this->registerHook('productfooter');
        }

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $result &= $this->registerHook('displayAfterBodyOpeningTag');
        }

        return $result ? true : false;
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallDb()
            && Configuration::deleteByName('WA_CHAT_MOBILE')
            && Configuration::deleteByName('WA_CHAT_MESSAGE')
            && Configuration::deleteByName('WA_BADGE_MESSAGE')
            && Configuration::deleteByName('WA_BADGE_POSITION');
    }

    public function createDb()
    {
        $result = true;

        $result &= Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock` (
              `id_whatsappchatblock` int(11) NOT NULL AUTO_INCREMENT,
              `id_shop` int(10) NOT NULL,
              `id_hook` varchar(150) NOT NULL,
              `open_chat` int(1) NOT NULL DEFAULT 1,
              `position` int(4) unsigned NULL default 0,
              `color` varchar(32) NULL DEFAULT "",
              `active` int(1) NOT NULL DEFAULT 0,
              `customer_groups` varchar(60) NULL DEFAULT "all",
              `only_home` int(1) NOT NULL DEFAULT 0,
              `chat_group` varchar(60) NULL DEFAULT "",
              `badge_width` int(3) NULL,
              `only_mobile` int(1) NOT NULL DEFAULT 1,
              `share_option` int(1) NOT NULL DEFAULT 0,
              `schedule` varchar(500) NULL DEFAULT "",
              `only_desktop` int(1) NOT NULL DEFAULT 1,
              `only_tablet` int(1) NOT NULL DEFAULT 1,
              `custom_css` text NULL,
              `custom_js` text NULL,
              `display_on` int(2) unsigned NULL DEFAULT 0,
              `display_on_selection` text NULL,
              `filter_by_customer` int(1) unsigned NULL DEFAULT 0,
              `customers` text NULL,
              `countries` text NULL,
              `zones` text NULL,
              `languages` text NULL,
              `currencies` text NULL,
              `pos` varchar(150),
              `positions` text NULL,
              PRIMARY KEY (`id_whatsappchatblock`),
              KEY `id_shop_id_hook` (`id_shop`,`id_hook`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;'
        );

        $result &= Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_lang` (
              `id_whatsappchatblock` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `message` text,
              `def_message` text,
              `offline_message` text,
              `offline_link` text,
              `mobile_phone` varchar(32) NULL DEFAULT "",
              PRIMARY KEY (`id_whatsappchatblock`,`id_lang`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;'
        );

        $result &= Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent` (
              `id_whatsappchatblock_agent` int(11) NOT NULL AUTO_INCREMENT,
              `id_whatsappchatblock` int(11) NOT NULL,
              `name` varchar(150) NOT NULL,
              `mobile_phone` varchar(32) NULL DEFAULT "",
              `image` varchar(150) NULL,
              `position` INT(5) NULL DEFAULT "0",
              `active` int(1) NOT NULL DEFAULT 0,
              `schedule` varchar(500) default "" null,
              PRIMARY KEY (`id_whatsappchatblock_agent`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;'
        );

        $result &= Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent_lang` (
              `id_whatsappchatblock_agent` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `department` text,
              PRIMARY KEY (`id_whatsappchatblock_agent`,`id_lang`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;'
        );

        return $result;
    }

    public function uninstallDb()
    {
        $result = true;
        $result &= Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'whatsappchatblock`;');
        $result &= Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'whatsappchatblock_lang`;');
        $result &= Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent`;');
        $result &= Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'whatsappchatblock_agent_lang`;');
        return $result;
    }

    public function installTabs()
    {
        $moduleTab = array(
            'tabClassName' => 'AdminWhatsappChat',
            'tabParentName' => '',
            'tabName' => $this->l('WhatsApp Chat'),
        );

        $id_tab = Tab::getIdFromClassName($moduleTab['tabClassName']);
        if (!$id_tab) {
            $tab = new Tab();
            $tab->class_name = $moduleTab['tabClassName'];
            if ($moduleTab['tabParentName']) {
                $tab->id_parent = Tab::getIdFromClassName($moduleTab['tabParentName']);
            } else {
                $tab->id_parent = -1;
            }

            $tab->module = $this->name;

            $languages = Language::getLanguages(false);
            foreach ($languages as $lang) {
                $tab->name[$lang['id_lang']] = $moduleTab['tabName'];
            }

            $tab->add();
        }

        $moduleTab = array(
            'tabClassName' => 'AdminWhatsappChatAgent',
            'tabParentName' => '',
            'tabName' => $this->l('WhatsApp Chat Agents'),
        );

        $id_tab = Tab::getIdFromClassName($moduleTab['tabClassName']);
        if (!$id_tab) {
            $tab = new Tab();
            $tab->class_name = $moduleTab['tabClassName'];
            if ($moduleTab['tabParentName']) {
                $tab->id_parent = Tab::getIdFromClassName($moduleTab['tabParentName']);
            } else {
                $tab->id_parent = -1;
            }

            $tab->module = $this->name;

            $languages = Language::getLanguages(false);
            foreach ($languages as $lang) {
                $tab->name[$lang['id_lang']] = $moduleTab['tabName'];
            }

            $tab->add();
        }

        return true;
    }

    /* All pages */
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/whatsapp.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/jBox.min.css', 'all');

        $agents_obj = new WhatsappChatBlockAgent();
        if (count($agents_obj->getWhatsappChatAgents(false, true)) > 0) {
            if (version_compare(_PS_VERSION_, '1.7', '<')) {
                $this->context->controller->addJS($this->_path . '/views/js/whatsappchat16.js');
            } else {
                $this->context->controller->addJS($this->_path.'/views/js/jBox.min.js');
            }
        }

        $html = '';
        //$html .= $this->displayBlock('badge');
        //$html .= $this->displayBlock('topWidth');
        //$html .= $this->displayBlock('floating');
        //$html .= $this->displayBlock('topWidthSticky');
        //$html .= $this->displayBlock('bottomWidth');
        return $html.$this->displayBlock('header');
    }

    public function hookFooter()
    {
        $html = '';
        /*if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $html .= $this->displayBlock('badge');
            $html .= $this->displayBlock('topWidth');
            $html .= $this->displayBlock('floating');
            $html .= $this->displayBlock('topWidthSticky');
        }*/
        $html .= $this->displayBlock('bottomWidth');
        return $html.$this->displayBlock('footer');
    }

    public function hookDisplayBanner()
    {
        $html = '';
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $html .= $this->displayBlock('badge');
            $html .= $this->displayBlock('topWidth');
            $html .= $this->displayBlock('floating');
            $html .= $this->displayBlock('topWidthSticky');
        }
        return $html.$this->displayBlock(__FUNCTION__);
    }

    public function hookLeftColumn()
    {
        return $this->displayBlock('leftcolumn');
    }

    public function hookRightColumn()
    {
        return $this->displayBlock('rightcolumn');
    }

    public function hookDisplayTopColumn()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookTop()
    {
        $html = '';
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            //$html .= $this->displayBlock('badge');
            //$html .= $this->displayBlock('topWidth');
            //$html .= $this->displayBlock('floating');
            //$html .= $this->displayBlock('topWidthSticky');
        }
        return $html.$this->displayBlock('top');
    }

    public function hookDisplayAfterBodyOpeningTag()
    {
        $html = '';
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $html .= $this->displayBlock('badge');
            $html .= $this->displayBlock('topWidth');
            $html .= $this->displayBlock('floating');
            $html .= $this->displayBlock('topWidthSticky');
        }
        //$html .= $this->displayBlock('bottomWidth');
        return $html.$this->displayBlock(__FUNCTION__);
    }

    /* Homepage */
    public function hookDisplayNav()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookHome()
    {
        return $this->displayBlock('home');
    }

    /* Product page */
    public function hookDisplayProductActions()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayProductButtons()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayWhatsAppProductSocialButtons()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayProductAdditionalInfo()
    {
        return $this->hookDisplayWhatsAppProductSocialButtons().$this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayLeftColumnProduct()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayRightColumnProduct()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayFooterProduct()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    /* Checkout */
    public function hookShoppingCart()
    {
        return $this->displayBlock('shoppingcart');
    }

    public function hookShoppingCartExtra()
    {
        return $this->displayBlock('shoppingcartextra');
    }

    public function hookPaymentTop()
    {
        return $this->displayBlock('paymenttop');
    }

    public function hookBeforeCarrier()
    {
        return $this->displayBlock('beforecarrier');
    }

    /* Order */
    public function hookOrderConfirmation()
    {
        return $this->displayBlock('orderconfirmation');
    }

    /* Customer account */
    public function hookCustomerAccount()
    {
        return $this->displayBlock('customeraccount');
    }

    public function hookDisplayCustomerAccountForm()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayCustomerAccountFormTop()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookDisplayCustomerIdentityForm()
    {
        return $this->displayBlock(__FUNCTION__);
    }

    public function hookMyAccountBlock()
    {
        return $this->displayBlock('myaccountblock');
    }

     /* Maintenance */
    public function hookDisplayMaintenance()
    {
        $html = '<link href="'.$this->_path.'views/css/whatsapp.css" rel="stylesheet">';
        return $html.$this->displayBlock(__FUNCTION__);
    }

    /* Free */
    public function hookDisplayWhatsAppChat($params)
    {
        return $this->displayBlock('hookDisplayWhatsAppChat', false, false, $params['id_whatsappchat']);
    }

    /* 1.4 */
    public function hookExtraLeft()
    {
        return $this->displayBlock('extraleft');
    }
    public function hookExtraRight()
    {
        return $this->displayBlock('extraright');
    }
    public function hookProductActions()
    {
        return $this->displayBlock('productactions');
    }
    public function hookProductFooter()
    {
        return $this->displayBlock('productfooter');
    }

    public function displayBlock($hook = false, $from_bo = false, $id_whatsappchatblock = false, $id_from_tpl = false)
    {
        if (Tools::getIsset('ajax') && Tools::getValue('ajax') == 'true') {
            return '';
        }
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            if (!($mobileNumber = Configuration::get('WA_CHAT_MOBILE'))) {
                return $mobileNumber;
            }
        }
        $only_active = $from_bo ? false : true;
        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $whatsappchatblock = new WhatsappChatBlock();
            $agents_class = new WhatsappChatBlockAgent();
            if ($messages = $whatsappchatblock->getWhatsappChatByHook($hook, $only_active, $from_bo, $id_whatsappchatblock)) {
                $tpl = '';
                foreach ($messages as $message) {
                    if ($hook === 'hookDisplayWhatsAppChat' && $id_from_tpl != $message['id_whatsappchatblock'] && $from_bo == false) {
                        continue;
                    }
                    if ($this->isShowableByDisplayOn($message) === false) {
                        if (!$from_bo) {
                            continue;
                        }
                    }
                    $showablebyschedule = $this->isShowableBySchedule($message);
                    if ($showablebyschedule === false && $message['offline_message'] == '') {
                        continue;
                    }
                    $offline_message = '';
                    $offline_link = '';
                    if ($showablebyschedule === true && $message['offline_message'] != '') {
                        $offline_message = '';
                    }
                    if ($showablebyschedule === false && $message['offline_message'] != '') {
                        $offline_message = $message['offline_message'];
                        $offline_link = $message['offline_link'];
                    }
                    if ($message['mobile_phone'] == '' && $message['message'] == '' && ($message['share_option'] == '0' || $message['share_option'] == '')) {
                        continue;
                    }
                    $mobile = new Mobile_Detect();
                    if ($message['only_mobile'] != '1' && $mobile->isMobile() && $from_bo == false) {
                        continue;
                    }
                    if ($message['only_tablet'] != '1' && $mobile->isTablet() && $from_bo == false) {
                        continue;
                    }
                    if ($message['only_desktop'] != '1' && (!$mobile->isMobile() && !$mobile->isTablet()) && $from_bo == false) {
                        continue;
                    }
                    if ($message['only_home'] == '1' && Dispatcher::getInstance()->getController() != 'index' && $from_bo == false) {
                        continue;
                    }
                    $text = '';
                    if ($message['def_message'] != '') {
                        $text .= $message['def_message'];
                    }
                    if ($message['share_option'] == '1') {
                        if (method_exists($this->context->controller, 'getProduct')) {
                            $product = $this->context->controller->getProduct();
                            if (Validate::isLoadedObject($product)) {
                                $text .= ' '.addcslashes($this->context->link->getProductLink($product), "'");
                            }
                        } else {
                            if (isset($_SERVER['SCRIPT_URI']) && $_SERVER['SCRIPT_URI'] != '') {
                                $text .= ' '.$_SERVER['SCRIPT_URI'];
                            } else {
                                $text .= ' '.$this->getProtocolUrl().$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                            }
                        }
                    }
                    $url = $this->getWhatsappUrl($message['mobile_phone'], $text, $message['chat_group']);
                    $agents = $agents_class->getWhatsappChatAgents($message['id_whatsappchatblock'], true);
                    foreach ($agents as $key => $agent) {
                        if (!$this->isShowableBySchedule($agent)) {
                            unset($agents[$key]);
                            continue;
                        }
                        $agents[$key]['url'] = $this->getWhatsappUrl($agent['mobile_phone'], $text);
                        if ($agent['image'] == '') {
                            $agents[$key]['image'] = 'agent_2.jpg';
                        }
                    }
                    if (Tools::substr($message['color'], 0, 1) == '#') {
                        $color = $message['color'];
                    } else {
                        $color = '#'.$message['color'];
                    }
                    if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                        $whatsapp_action = Tools::getValue('action');
                    } elseif (version_compare(_PS_VERSION_, '1.6', '>=')) {
                        $whatsapp_action = (int)Tools::getValue('content_only');
                    } else {
                        $whatsapp_action = 0;
                    }
                    $this->context->smarty->assign(array(
                        'whatsapp_action' => $whatsapp_action,
                        'font_awesome'    => ($hook == 'hookDisplayMaintenance' ? false : Configuration::get('WA_FONT_AWESOME')),
                        'whatsappchat_id' => $message['id_whatsappchatblock'],
                        'button_text'     => $message['message'],
                        'offline_message' => $offline_message,
                        'offline_link'    => $offline_link,
                        'whatsapp_class'  => $hook,
                        'position'        => $message['pos'],
                        'open_chat'       => '1',
                        'mobile_phone'    => $message['mobile_phone'],
                        'color'           => $color,
                        'custom_css'      => $message['custom_css'],
                        'custom_js'       => $message['custom_js'],
                        'url'             => $url,
                        'agents'          => count($agents) <= 0 ? false : $agents,
                        'agents_img_src'  => __PS_BASE_URI__.'modules/'.$this->name.'/views/img/agent/',
                        'from_bo'         => ($from_bo ? '1' : '0')
                    ));
                    if ($from_bo) {
                        return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/hook/template.tpl');
                    }
                    $tpl .= $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/hook/template.tpl');
                    //$tpl .= $this->display(__FILE__, 'template.tpl');
                }
                if (version_compare(_PS_VERSION_, '1.7', '<')) {
                    return $tpl;
                } else {
                    return $tpl;
                }
            }
        } else {
            if (Configuration::get('WA_'.Tools::strtoupper($hook).'_ENABLE')) {
                $url = $this->getWhatsappUrl(Configuration::get('WA_CHAT_MOBILE'), Configuration::get('WA_CHAT_MESSAGE', $this->context->cookie->id_lang));
                $this->context->smarty->assign(array(
                    'font_awesome'  => false,
                    'message'       => Configuration::get('WA_'.Tools::strtoupper($hook).'_MESSAGE', (int)$this->context->cookie->id_lang),
                    'whatsapp_class'=> $hook,
                    'position'      => Configuration::get('WA_'.Tools::strtoupper($hook).'_POSITION'),
                    'open_chat'     => '1',
                    'url'           => $url,
                    'from_bo'       => ($from_bo ? '1' : '0')
                ));
                return $this->display(__FILE__, 'views/templates/hook/template.tpl');
            }
        }
    }

    public function hookBackOfficeHeader()
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            if (Module::isInstalled($this->name) && (Tools::strtolower(Tools::getValue('tab')) == 'admincustomers' || Tools::strtolower(Tools::getValue('tab')) == 'adminorders')) {
                if ((Tools::getIsset('viewcustomer') && Tools::getValue('id_customer') > 0) ||
                    (Tools::getIsset('vieworder') && Tools::getValue('id_order') > 0)) {
                    return '';
                }
                $this->context->controller->addCSS($this->_path.'views/css/whatsapp.css', 'all');
                $this->context->controller->addCSS($this->_path.'views/css/bo_whatsapp.css', 'all');
                $this->context->smarty->assign(array(
                    'action' => $this->l('WhatsApp'),
                    'action_whatsappchat' => $this->l('WhatsApp with this customer'),
                    'admin_base_dir' => $this->currentPageURL(),
                    'this_path_bo' => $this->_path,
                    'iso_code' => $this->context->language->iso_code,
                    'whatsappchat_admincontroller' => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/whatsappchat/controllers/admin/AdminWhatsappChatController14.php',
                    'url' => false,
                    'show_button' => true,
                    'token' => Tools::getValue('token')
                ));
                return $this->display(__FILE__, '/views/templates/hook/bo_customers_grid_action.tpl');
            }
            return '';
        }
        if ((version_compare(_PS_VERSION_, '1.5', '>=') && (Tools::strtolower(Dispatcher::getInstance()->getController()) == 'admincustomers') || Tools::strtolower(Dispatcher::getInstance()->getController()) == 'adminorders') ||
                (version_compare(_PS_VERSION_, '1.5', '<') && Tools::strtolower(Tools::getValue('tab')) == 'admincustomers')
        ) {
            $this->context->controller->addCSS($this->_path.'views/css/whatsapp.css', 'all');
            $this->context->controller->addCSS($this->_path.'views/css/bo_whatsapp.css', 'all');
            $this->context->smarty->assign(array(
                'action' => $this->l('WhatsApp'),
                'action_whatsappchat' => $this->l('WhatsApp with this customer'),
                'admin_base_dir' => $this->currentPageURL(),
                'this_path_bo' => $this->_path,
                'iso_code' => $this->context->language->iso_code,
                'whatsappchat_admincontroller' => $this->context->link->getAdminLink('AdminWhatsappChat', true, $this->context->language->id),
                'url' => false,
                'show_button' => true,
                'token' => Tools::getValue('token')
            ));
            if ((Tools::getIsset('viewcustomer') && Tools::getValue('id_customer') > 0) ||
                (Tools::getIsset('vieworder') && Tools::getValue('id_order') > 0)) {
                if (Tools::getIsset('vieworder') && Tools::getValue('id_order') > 0) {
                    $order = new Order((int)Tools::getValue('id_order'));
                    $id_customer = $order->id_customer;
                } else {
                    $id_customer = Tools::getValue('id_customer');
                }
                $address_id = Address::getFirstCustomerAddressId((int)$id_customer, true);
                if ($address_id > 0) {
                    $address = new Address((int)$address_id);
                    $phone = $address->phone_mobile;
                    /*
                    if (!Validate::isPhoneNumber($phone) || $phone == '' || (int)$phone == 0) {
                        $phone = $address->phone;
                        if (!Validate::isPhoneNumber($phone) || $phone == '') {
                            $this->context->smarty->assign(array(
                                'show_button' => false
                            ));
                        }
                    }
                    */
                    if (!Validate::isPhoneNumber($phone) || $phone == '') {
                        $phone = $address->phone;
                        if (!Validate::isPhoneNumber($phone) || $phone == '') {
                            $this->context->smarty->assign(array(
                                'show_button' => false
                            ));
                        }
                    }
                    $phone = $this->formatMobilePhoneForWhatsapp($phone, $address->id_country);
                    $this->context->smarty->assign(array(
                        'url' => $this->getWhatsappUrl($phone)
                    ));
                } else {
                    $this->context->smarty->assign(array(
                        'show_button' => false
                    ));
                }
            }
            if (Tools::strtolower(Dispatcher::getInstance()->getController()) == 'adminorders') {
                return $this->display(__FILE__, 'bo_orders_grid_action.tpl');
            } else {
                return $this->display(__FILE__, 'bo_customers_grid_action.tpl');
            }
        }
        return '';
    }

    public function getContent()
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $html = '';

            if (((bool)Tools::isSubmit('submitwhatsappchatModule')) == true) {
                $html .= $this->postProcess();
            }

            if ($warnings = $this->getWarnings(false)) {
                $html .= $this->displayError($warnings);
            }

            return $html.$this->renderForm14();
        }

        if ((version_compare(_PS_VERSION_, '1.5.0.13', '<') && Module::isInstalled('whatsappchat'))
            || (version_compare(_PS_VERSION_, '1.5.0.13', '>=') && Module::isEnabled('whatsappchat'))) {
            $this->installTabs();
        }

        Tools::redirectAdmin('index.php?controller=AdminWhatsappChat&token='.Tools::getAdminTokenLite('AdminWhatsappChat'));
        return false;
    }

    protected function renderForm()
    {
        $html = '';

        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitwhatsappchatModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages'     => $this->context->controller->getLanguages(),
            'id_language'   => $this->context->language->id,
        );

        $html .= $helper->generateForm($this->getConfigForm());

        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            $this->context->smarty->assign(array(
                'this_path'     => $this->_path,
                'support_id'    => $this->addons_id_product
            ));
            $available_iso_codes = array('en', 'es');
            $default_iso_code = 'en';
            $template_iso_suffix = in_array($this->context->language->iso_code, $available_iso_codes) ? $this->context->language->iso_code : $default_iso_code;
            $html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/company/information_'.$template_iso_suffix.'.tpl');
        }

        return $html;
    }

    protected function renderForm14()
    {
        $html = '';

        $helper = new Helper();

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => Language::getLanguages(false),
            'id_language' => $this->context->language->id,
            'THEME_LANG_DIR' => _PS_IMG_.'l/'
        );

        $html .= $helper->generateForm($this->getConfigForm());

        return $html;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, $form_values[$key]);
        }

        return $this->displayConfirmation($this->l('Configuration saved successfully.'));
    }

    protected function getConfigForm()
    {
        $fields = array();

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('General configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type'  => 'text',
                    'label' => $this->l('Mobile phone number'),
                    'name'  => 'WA_CHAT_MOBILE',
                    'desc' => $this->l('Introduce mobile phone number with the international country code, without "+" character.').'<br />'.$this->l('Example: Introduce 341234567 for (+34) 1234567.'),
                    'col'   => 2,
                    'class' => 't',
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Default chat message'),
                    'name'  => 'WA_CHAT_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
            )
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Badge configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display badge?'),
                    'name' => 'WA_BADGE_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_BADGE_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_BADGE_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Badge message'),
                    'name'  => 'WA_BADGE_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Badge position'),
                    'name' => 'WA_BADGE_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'bottom-left',
                                'name' => $this->l('Bottom left')
                            ),
                            array(
                                'id' => 'bottom-right',
                                'name' => $this->l('Bottom right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_BADGE_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_BADGE_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_BADGE_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        $positions = array(
            array(
                'id' => 'HEADER',
                'name' => 'header'
            ),
            array(
                'id' => 'TOP',
                'name' => 'top'
            ),
            array(
                'id' => 'LEFTCOLUMN',
                'name' => 'left column'
            ),
            array(
                'id' => 'RIGHTCOLUMN',
                'name' => 'right column'
            ),
            array(
                'id' => 'FOOTER',
                'name' => 'footer'
            )
        );

        $sectionFields = array();
        foreach ($positions as $position) {
            $sectionFields = array_merge($sectionFields, array(
                array(
                    'type'          => 'html',
                    'html_content'  => '<hr>',
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display block in').' '.$position['name'].'?',
                    'name' => 'WA_'.$position['id'].'_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Block message'),
                    'name'  => 'WA_'.$position['id'].'_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WA_'.$position['id'].'_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center'),
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_'.$position['id'].'_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                )
            ));
        }

        $sectionFields = array_merge(
            array(array(
                'type'  => 'html',
                'html_content'  => '<div style="text-align:center; font-weight:bold"><a target="_blank" href="'.$this->_path.'views/img/allpages_14.png">'.$this->l('View hook position 🔗').'</a></div><br />',
            )),
            $sectionFields
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('All pages configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => $sectionFields,
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Home configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type'  => 'html',
                    'html_content'  => '<div style="text-align:center; font-weight:bold"><a target="_blank" href="'.$this->_path.'views/img/home_14.png">'.$this->l('View hook position 🔗').'</a></div><br />',
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display block in home?'),
                    'name' => 'WA_HOME_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_HOME_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_HOME_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Block message'),
                    'name'  => 'WA_HOME_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WA_HOME_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center'),
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_HOME_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_HOME_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_HOME_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        $positions = array(
            array(
                'id' => 'EXTRALEFT',
                'name' => 'left column'
            ),
            array(
                'id' => 'EXTRARIGHT',
                'name' => 'right column'
            ),
            array(
                'id' => 'PRODUCTACTIONS',
                'name' => 'product actions'
            ),
            array(
                'id' => 'PRODUCTFOOTER',
                'name' => 'product footer'
            ),
        );

        $sectionFields = array();
        foreach ($positions as $position) {
            $sectionFields = array_merge($sectionFields, array(
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display block in').' '.$position['name'].'?',
                    'name' => 'WA_'.$position['id'].'_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Block message'),
                    'name'  => 'WA_'.$position['id'].'_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WA_'.$position['id'].'_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center'),
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_'.$position['id'].'_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'          => 'html',
                    'html_content'  => '<hr>',
                ),
            ));
        }

        $sectionFields = array_merge(
            array(array(
                'type'  => 'html',
                'html_content'  => '<div style="text-align:center; font-weight:bold"><a target="_blank" href="'.$this->_path.'views/img/product_14.png">'.$this->l('View hook position 🔗').'</a></div><br />',
            )),
            $sectionFields
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Product page configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => $sectionFields,
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        $positions = array(
            array(
                'id' => 'SHOPPINGCART',
                'name' => 'shopping cart'
            ),
            array(
                'id' => 'SHOPPINGCARTEXTRA',
                'name' => 'shopping cart extra'
            ),
            array(
                'id' => 'PAYMENTTOP',
                'name' => 'payment top'
            ),
            array(
                'id' => 'BEFORECARRIER',
                'name' => 'before carrier'
            ),
            array(
                'id' => 'ORDERCONFIRMATION',
                'name' => 'order confirmation'
            ),
        );

        $sectionFields = array();
        foreach ($positions as $position) {
            $sectionFields = array_merge($sectionFields, array(
                array(
                    'type'          => 'html',
                    'html_content'  => '<hr>',
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display block in').' '.$position['name'].'?',
                    'name' => 'WA_'.$position['id'].'_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Block message'),
                    'name'  => 'WA_'.$position['id'].'_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WA_'.$position['id'].'_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center'),
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_'.$position['id'].'_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                )
            ));
        }

        $sectionFields = array_merge(
            array(array(
                'type'  => 'html',
                'html_content'  => '<div style="text-align:center; font-weight:bold"><a target="_blank" href="'.$this->_path.'views/img/shoppingcart_14.png">'.$this->l('View hook position 🔗').'</a></div><br />',
            )),
            $sectionFields
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Checkout/Order configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => $sectionFields,
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        $positions = array(
            array(
                'id' => 'CUSTOMERACCOUNT',
                'name' => 'customer account'
            ),
            array(
                'id' => 'MYACCOUNTBLOCK',
                'name' => 'my account'
            ),
        );

        $sectionFields = array();
        foreach ($positions as $position) {
            $sectionFields = array_merge($sectionFields, array(
                array(
                    'type'          => 'html',
                    'html_content'  => '<hr>',
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Display block in').' '.$position['name'].'?',
                    'name' => 'WA_'.$position['id'].'_ENABLE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Block message'),
                    'name'  => 'WA_'.$position['id'].'_MESSAGE',
                    'lang'  => true,
                    'col'   => 4,
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WA_'.$position['id'].'_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'left',
                                'name' => $this->l('Left')
                            ),
                            array(
                                'id' => 'center',
                                'name' => $this->l('Center'),
                            ),
                            array(
                                'id' => 'right',
                                'name' => $this->l('Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Open chat in a new window?'),
                    'name' => 'WA_'.$position['id'].'_CHAT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'WA_'.$position['id'].'_CHAT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                )
            ));
        }

        $sectionFields = array_merge(
            array(array(
                'type'  => 'html',
                'html_content'  => '<div style="text-align:center; font-weight:bold"><a target="_blank" href="'.$this->_path.'views/img/shoppingcart_14.png">'.$this->l('View hook position 🔗').'</a></div><br />',
            )),
            $sectionFields
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('My account configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => $sectionFields,
            'submit' => array(
                'title' => $this->l('Save'),
                'type' => 'submit',
                'name' => 'submitwhatsappchatModule',
            ),
        );

        return $fields;
    }

    protected function getConfigFormValues()
    {
        $fields = array();

        $fields['WA_CHAT_MOBILE'] = Tools::getValue(
            'WA_CHAT_MOBILE',
            Configuration::get('WA_CHAT_MOBILE')
        );

        $fields['WA_FONT_AWESOME'] = Tools::getValue(
            'WA_FONT_AWESOME',
            Configuration::get('WA_FONT_AWESOME')
        );

        $positions = array('BADGE', 'HEADER', 'FOOTER', 'LEFTCOLUMN', 'RIGHTCOLUMN', 'TOP', 'HOME', 'EXTRALEFT', 'EXTRARIGHT', 'PRODUCTACTIONS', 'PRODUCTFOOTER', 'SHOPPINGCART', 'SHOPPINGCARTEXTRA', 'PAYMENTTOP', 'BEFORECARRIER', 'ORDERCONFIRMATION', 'CUSTOMERACCOUNT', 'MYACCOUNTBLOCK', 'TOPWIDTH', 'TOPWIDTHSTICKY', 'BOTTOMWIDTH');

        foreach ($positions as $position) {
            $fields['WA_'.$position.'_ENABLE'] = Tools::getValue(
                'WA_'.$position.'_ENABLE',
                Configuration::get('WA_'.$position.'_ENABLE')
            );

            $fields['WA_'.$position.'_POSITION'] = Tools::getValue(
                'WA_'.$position.'_POSITION',
                Configuration::get('WA_'.$position.'_POSITION')
            );

            $fields['WA_'.$position.'_CHAT'] = Tools::getValue(
                'WA_'.$position.'_CHAT',
                Configuration::get('WA_'.$position.'_CHAT')
            );
        }

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $fields['WA_CHAT_MESSAGE'][$lang['id_lang']] = Tools::getValue(
                'WA_CHAT_MESSAGE_'.$lang['id_lang'],
                Configuration::get('WA_CHAT_MESSAGE', $lang['id_lang'])
            );

            foreach ($positions as $position) {
                $fields['WA_'.$position.'_MESSAGE'][$lang['id_lang']] = Tools::getValue(
                    'WA_'.$position.'_MESSAGE_'.$lang['id_lang'],
                    Configuration::get('WA_'.$position.'_MESSAGE', $lang['id_lang'])
                );
            }
        }

        return $fields;
    }

    public function getWarnings($getAll = true)
    {
        $warning = array();

        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            if (Configuration::get('PS_DISABLE_NON_NATIVE_MODULE')) {
                $warning[] = $this->l('You have to enable non PrestaShop modules at ADVANCED PARAMETERS - PERFORMANCE');
            }
        }

        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            if (Shop::isFeatureActive() && (Shop::getContext() == Shop::CONTEXT_ALL || Shop::getContext() == Shop::CONTEXT_GROUP)) {
                $warning[] = $this->l('You have to select a shop to create a new WhatsApp button chat configuration.');
            }
        }

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            if (!(Configuration::get('WA_CHAT_MOBILE'))) {
                $warning[] = $this->l('You have to set your mobile phone number.');
            }
        }

        if (count($warning) && !$getAll) {
            return $warning[0];
        }

        return $warning;
    }

    public function getAvailableHooks()
    {
        $hooks = array(
            /* All pages */
            array(
                'id' => 'badge',
                'name' => $this->l('Badge - All pages')
            ),
            array(
                'id' => 'floating',
                'name' => $this->l('Floating - All pages')
            ),
            array(
                'id' => 'hookDisplayBanner',
                'name' => $this->l('Banner (displayBanner) - All pages')
            ),
            array(
                'id' => 'top',
                'name' => $this->l('Top (displayTop) - All pages')
            ),
            array(
                'id' => 'header',
                'name' => $this->l('Header (displayHeader) - All pages')
            ),
            array(
                'id' => 'footer',
                'name' => $this->l('Footer (displayFooter) - All pages')
            ),
            array(
                'id' => 'leftcolumn',
                'name' => $this->l('Left column (displayLeftColumn) - All pages')
            ),
            array(
                'id' => 'rightcolumn',
                'name' => $this->l('Right column (displayRightColumn) - All pages')
            ),
            array(
                'id' => 'hookDisplayTopColumn',
                'name' => $this->l('Top column (displayTopColumn) - All pages')
            ),
            array(
                'id' => 'hookDisplayNav',
                'name' => $this->l('Navigation (displayNav) - All pages')
            ),
            array(
                'id' => 'topWidth',
                'name' => $this->l('Top of page 100% width - All pages')
            ),
            array(
                'id' => 'topWidthSticky',
                'name' => $this->l('Sticked at top of page 100% width  - All pages')
            ),
            array(
                'id' => 'bottomWidth',
                'name' => $this->l('Sticked at bottom of page 100% width  - All pages')
            ),

            /* Homepage */
            array(
                'id' => 'home',
                'name' => $this->l('Home (displayHome) - Homepage')
            ),

            /* Product page */
            array(
                'id' => 'hookDisplayProductButtons',
                'name' => $this->l('Product page actions (displayProductButtons) - Product page')
            ),
            array(
                'id' => 'hookDisplayProductActions',
                'name' => $this->l('Product page actions (displayProductActions) - Product page')
            ),
            array(
                'id' => 'hookDisplayProductAdditionalInfo',
                'name' => $this->l('Product page additional info (displayDisplayProductAdditionalInfo) - Product page')
            ),
            array(
                'id' => 'hookDisplayWhatsAppProductSocialButtons',
                'name' => $this->l('Product page social buttons - Product page')
            ),
            array(
                'id' => 'hookDisplayLeftColumnProduct',
                'name' => $this->l('Left column (displayLeftColumnProduct) - Product page')
            ),
            array(
                'id' => 'hookDisplayRightColumnProduct',
                'name' => $this->l('Right column (displayRightColumnProduct) - Product page')
            ),
            array(
                'id' => 'hookDisplayFooterProduct',
                'name' => $this->l('Product footer (displayFooterProduct) - Product page')
            ),

            /* Checkout */
            array(
                'id' => 'shoppingcart',
                'name' => $this->l('Shopping cart (displayShoppingCart) - Checkout')
            ),
            array(
                'id' => 'shoppingcartextra',
                'name' => $this->l('Shopping cart extra (displayShoppingCartExtra) - Checkout')
            ),
            array(
                'id' => 'paymenttop',
                'name' => $this->l('Top of payment page (displayPaymentTop) - Checkout')
            ),
            array(
                'id' => 'beforecarrier',
                'name' => $this->l('Before carriers list (displayBeforeCarrier) - Checkout')
            ),

            /* Order */
            array(
                'id' => 'orderconfirmation',
                'name' => $this->l('Order confirmation (displayOrderConfirmation) - Order')
            ),

            /* Customer account */
            array(
                'id' => 'customeraccount',
                'name' => $this->l('Customer account (displayCustomerAccount) - Customer account')
            ),
            array(
                'id' => 'hookDisplayCustomerAccountForm',
                'name' => $this->l('Customer account creation form (displayCustomerAccountForm) - Customer account')
            ),
            array(
                'id' => 'hookDisplayCustomerAccountFormTop',
                'name' => $this->l('Above the customer account creation form (displayCustomerAccountFormTop) - Customer account')
            ),
            array(
                'id' => 'hookDisplayCustomerIdentityForm',
                'name' => $this->l('Customer identity form (displayCustomerIdentityForm) - Customer account')
            ),
            array(
                'id' => 'myaccountblock',
                'name' => $this->l('My account footer block (displayMyAccountBlock) - Customer account')
            ),

            /* Maintenance */
            array(
                'id' => 'hookDisplayMaintenance',
                'name' => $this->l('Maintenance (displayMaintenance) - Maintenance page')
            ),

            /* Free */
            array(
                'id' => 'hookDisplayWhatsAppChat',
                'name' => $this->l('TPL - To insert freely in a TPL page')
            ),
            /*
            array(
                'id' => 'hookWhatsAppChatCms',
                'name' => $this->l('CMS - To insert freely in a CMS page')
            ),
            */
        );
        foreach ($hooks as $key => $hook) {
            if (version_compare(_PS_VERSION_, '1.7', '>=') && $hook['id'] === 'hookDisplayProductButtons') {
                unset($hooks[$key]);
            }
            if (version_compare(_PS_VERSION_, '1.7', '<') && $hook['id'] === 'hookDisplayProductActions') {
                unset($hooks[$key]);
            }
        }
        return array_values($hooks);
    }

    private function currentPageURL()
    {
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            {$pageURL = "https://";}
        } else {
            {$pageURL = "http://";}
        }

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }

    public function displayAgentsLink($token, $id)
    {
        $agents_class = new WhatsappChatBlockAgent();
        $nb_agents = (int)count($agents_class->getWhatsappChatAgents($id, true));
        $this->context->smarty->assign(array(
            'href' => 'index.php?controller=AdminWhatsappChatAgent&token='.Tools::getAdminTokenLite('AdminWhatsappChatAgent').'&id_whatsappchatblock='.$id,
            'action' => $this->l('Agents'),
            'nb_agents' => $nb_agents,
            'token' => $token
        ));
        return $this->display(__FILE__, 'views/templates/admin/list_action_agents.tpl');
    }

    public function formatMobilePhoneForWhatsapp($phone, $id_country = false)
    {
        $phone = preg_replace('/[^0-9]+/', '', $phone);
        if (!$id_country) {
            return $phone;
        } else {
            $country = new Country((int)$id_country);
            if (Tools::substr($phone, 0, Tools::strlen($country->call_prefix)) == $country->call_prefix) {
                return $phone;
            } else {
                return $country->call_prefix.$phone;
            }
        }
    }

    public function getWhatsappUrl($phone = false, $text = false, $chat_group = '')
    {
        $mobile = new Mobile_Detect();
        if ($mobile->isMobile() || $mobile->isTablet()) {
            if ($mobile->is('AndroidOS')) {
                if ($this->isFacebookInstagramInAppBrowser()) {
                    return 'intent://send/'.($phone ? '&phone='.$phone : '').'#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end';
                }
            }
            if ($this->UCBrowser()) {
                return 'intent://send/'.($phone ? '&phone='.$phone : '').'#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end';
            }
            $url = 'https://api.whatsapp.com/';
        } else {
            $url = 'https://web.whatsapp.com/';
        }
        if ($chat_group != '') {
            return 'https://chat.whatsapp.com/'.$chat_group;
        }
        return $url.'send?l='.$this->context->language->iso_code.($phone ? '&phone='.$phone : '').($text ? '&text='.$text : '');
    }

    public function isShowableBySchedule($whatsappchat)
    {
        $schedule = Tools::jsonDecode($whatsappchat['schedule']);
        $dayOfWeek = date('w') - 1;
        if ($dayOfWeek < 0) {
            $dayOfWeek = 6;
        }
        if (is_array($schedule)) {
            if (is_object($schedule[$dayOfWeek]) && $schedule[$dayOfWeek]->isActive === true) {
                if ($schedule[$dayOfWeek]->timeFrom <= date('H:i') && $schedule[$dayOfWeek]->timeTill > date('H:i')) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function isShowableByDisplayOn($whatsappchat)
    {
        $display = true;
        $entity = $this->context->controller->php_self;
        if (!isset($entity) || is_null($entity) || $entity == '') {
            if (!empty($this->context->controller->page_name)) {
                $entity = $this->context->controller->page_name;
            } elseif (preg_match('#^'.preg_quote($this->context->shop->physical_uri, '#').'modules/([a-zA-Z0-9_-]+?)/(.*)$#', $_SERVER['REQUEST_URI'], $m)) {
                $entity = 'module-' . $m[1] . '-' . str_replace(array ('.php', '/'), array ('', '-'), $m[2]);
            } else {
                $entity = Dispatcher::getInstance()->getController();
                $entity = (preg_match('/^[0-9]/', $entity)) ? 'page_'.$entity : $entity;
            }
        }
        $entity_id = (int)Tools::getValue('id_'.$entity);
        switch ($whatsappchat['display_on']) {
            case '1':
                if ($entity !== 'product') {
                    $display = false;
                }
                break;
            case '2':
                if ($entity !== 'product') {
                    $display = false;
                } else {
                    if (!in_array((string)$entity_id, explode(';', $whatsappchat['display_on_selection']))) {
                        $display = false;
                    }
                }
                break;
            case '3':
                if ($entity !== 'category') {
                    $display = false;
                }
                break;
            case '4':
                if ($entity !== 'category') {
                    $display = false;
                } else {
                    if (!in_array((string)$entity_id, explode(';', $whatsappchat['display_on_selection']))) {
                        $display = false;
                    }
                }
                break;
            case '5':
                if ($entity !== 'cms') {
                    $display = false;
                }
                break;
            case '6':
                if ($entity !== 'cms') {
                    $display = false;
                } else {
                    if (!in_array((string)$entity_id, explode(';', $whatsappchat['display_on_selection']))) {
                        $display = false;
                    }
                }
                break;
            case '7':
                if ($entity !== 'manufacturer') {
                    $display = false;
                }
                break;
            case '8':
                if ($entity !== 'manufacturer') {
                    $display = false;
                } else {
                    if (!in_array((string)$entity_id, explode(';', $whatsappchat['display_on_selection']))) {
                        $display = false;
                    }
                }
                break;
            case '9':
                if ($entity !== 'supplier') {
                    $display = false;
                }
                break;
            case '10':
                if ($entity !== 'supplier') {
                    $display = false;
                } else {
                    if (!in_array((string)$entity_id, explode(';', $whatsappchat['display_on_selection']))) {
                        $display = false;
                    }
                }
                break;
            case '11':
                if (!in_array($entity, explode(';', $whatsappchat['display_on_selection']))) {
                    $display = false;
                }
                break;
            default:
        }
        if (!$display) {
            return false;
        }
        return true;
    }

    public function getCustomerGroups($id_lang, $withall = true)
    {
        if ($withall) {
            $groups = array(array('id_group' => 'all', 'name' => $this->l('-- All --')));
        } else {
            $groups = array(array('id_group' => '0', 'name' => '-'));
        }
        return array_merge($groups, Group::getGroups($id_lang, true));
    }

    public function getDisplayOnOptions()
    {
        return array(
            array(
                'id' => '0',
                'name' => $this->l('On all available pages')
            ),
            array(
                'id' => '1',
                'name' => $this->l('Only on product pages')
            ),
            array(
                'id' => '2',
                'name' => $this->l('Only on selected product pages')
            ),
            array(
                'id' => '3',
                'name' => $this->l('Only on category pages')
            ),
            array(
                'id' => '4',
                'name' => $this->l('Only on selected category pages')
            ),
            array(
                'id' => '5',
                'name' => $this->l('Only on cms pages')
            ),
            array(
                'id' => '6',
                'name' => $this->l('Only on selected cms pages')
            ),
            array(
                'id' => '7',
                'name' => $this->l('Only on manufacturer pages')
            ),
            array(
                'id' => '8',
                'name' => $this->l('Only on selected manufacturer pages')
            ),
            array(
                'id' => '9',
                'name' => $this->l('Only on supplier pages')
            ),
            array(
                'id' => '10',
                'name' => $this->l('Only on selected supplier pages')
            ),
            array(
                'id' => '11',
                'name' => $this->l('Other pages...')
            ),
        );
    }

    public static function getDisplayOnSelection($entity)
    {
        if ($entity === false) {
            return array();
        }
        $context = Context::getContext();
        $module = new WhatsappChat();
        switch ($entity) {
            case '2': //Products
                $products_array = array();
                $products = Product::getProducts($context->language->id, 0, 0, 'id_product', 'desc');
                foreach ($products as $product) {
                    $products_array[] = array('id' => $product['id_product'], 'name' => $product['name']);
                }
                return $products_array;
            case '4': //Categories
                $categories_array = array();
                if (version_compare(_PS_VERSION_, '1.6.1', '>=')) {
                    $categories = Category::getAllCategoriesName(2, $context->language->id);
                } else {
                    $categories = Category::getCategories($context->language->id, false, false);
                }
                foreach ($categories as $category) {
                    $categories_array[] = array('id' => $category['id_category'], 'name' => $category['name']);
                }
                return $categories_array;
            case '6': //CMS pages
                $cms_array = array();
                $cms = CMS::getCMSPages($context->language->id, null, false, $context->shop->id);
                foreach ($cms as $page) {
                    $cms_array[] = array('id' => $page['id_cms'], 'name' => $page['meta_title'], 'link_rewrite' => Context::getContext()->link->getCMSLink($page['id_cms']));
                }
                return $cms_array;
            case '8': //Manufacturers
                $manufacturers_array = array();
                $manufacturers = Manufacturer::getManufacturers(false, $context->language->id, false);
                foreach ($manufacturers as $manufacturer) {
                    $manufacturers_array[] = array('id' => $manufacturer['id_manufacturer'], 'name' => $manufacturer['name'], 'link_rewrite' => Context::getContext()->link->getManufacturerLink($manufacturer['id_manufacturer']));
                }
                return $manufacturers_array;
            case '10': //Suppliers
                $suppliers_array = array();
                $suppliers = Supplier::getSuppliers(false, $context->language->id, false);
                foreach ($suppliers as $supplier) {
                    $suppliers_array[] = array('id' => $supplier['id_supplier'], 'name' => $supplier['name'], 'link_rewrite' => Context::getContext()->link->getSupplierLink($supplier['id_supplier']));
                }
                return $suppliers_array;
            case '11': //Other pages
                $otherpages_array = array();
                if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                    $otherpages = Meta::getAllMeta($context->language->id);
                } else {
                    $otherpages = Meta::getMetasByIdLang($context->language->id);
                }
                foreach ($otherpages as $otherpage) {
                    try {
                        if ($otherpage['page'] === 'index') {
                            $otherpages_array[] = array('id' => $otherpage['page'], 'name' => $otherpage['title'] == '' ? $module->l('Home page') : $otherpage['title'], 'link_rewrite' => Context::getContext()->link->getPageLink($otherpage['page']), 'title' => $otherpage['title']);
                        } else {
                            $otherpages_array[] = array('id' => $otherpage['page'], 'name' => $otherpage['title'] == '' ? $otherpage['page'] : $otherpage['title'], 'link_rewrite' => Context::getContext()->link->getPageLink($otherpage['page']), 'title' => $otherpage['title']);
                        }
                    } catch (Exception $e) {
                        continue;
                    }
                }
                return $otherpages_array;
            default:
                return array();
        }
    }

    public static function getProductsLite($id_lang, $only_active = false, $front = false)
    {
        $sql = 'SELECT p.`id_product`, CONCAT(p.`reference`, " - ", pl.`name`) as name FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                WHERE pl.`id_lang` = '.(int)$id_lang.
               ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
               ($only_active ? ' AND product_shop.`active` = 1' : '');
        $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        return ($rq);
    }

    protected function getProtocolUrl()
    {
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }

        return $protocol."://";
    }

    protected function isFirefoxBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Firefox')) {
            return true;
        } else {
            return false;
        }
    }

    protected function isFacebookInstagramInAppBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'FBAN') || strpos($user_agent, 'FB_IAB') || strpos($user_agent, 'FBAV')) {
            return true;
        } elseif (strpos($user_agent, 'Instagram')) {
            return true;
        } else {
            return false;
        }
    }

    protected function UCBrowser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'UCBrowser')) {
            return true;
        } else {
            return false;
        }
    }

    protected function isAndroidBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'SamsungBrowser')) {
            return true;
        } elseif (strpos($user_agent, 'MiuiBrowser')) {
            return true;
        } elseif (strpos($user_agent, 'UCBrowser')) {
            return true;
        } else {
            return false;
        }
    }
}
