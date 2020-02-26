<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/


            
class AdminRevolutionsliderFmanagerController extends ModuleAdminController
{

    protected $_ajax_results;

    protected $_ajax_stripslash;

    protected $_filter_whitespace;

    protected $lushslider_model;

    public function __construct()
    {
        $this->display_header = false;
        $this->display_footer = false;
        $this->content_only   = true;
        parent::__construct();
        $this->_ajax_results['error_on'] = 1; 
    }
    public function init()
    {

        // Process POST | GET
        $this->initProcess();
       // $this->initHeader();
    }
    /**
     * 
     * @throws Exception
     */
    public function initProcess()
    {
                    
                ob_start(); 
                switch (Tools::getValue("view")) {
                    case "upload": 
                    require_once(RS_PLUGIN_PATH . '/include/filemanager/upload.php');
                        break;
                    case "ajax_calls": 
                    require_once(RS_PLUGIN_PATH . '/include/filemanager/ajax_calls.php');
                        break;
                    case "execute": 
                    require_once(RS_PLUGIN_PATH . '/include/filemanager/execute.php');
                        break;
                    case "download": 
                       
                    require_once(RS_PLUGIN_PATH . '/include/filemanager/force_download.php');
                        break; 
                    default: 
                        
                    require_once(RS_PLUGIN_PATH . '/include/filemanager/dialog.php');
                    }
                $output = ob_get_contents();
                ob_end_clean(); 
                die($output);
    }
 public function initHeader()
    {
    
        // Multishop
        $is_multishop = Shop::isFeatureActive();

        // Quick access
        $quick_access = QuickAccess::getQuickAccesses($this->context->language->id);
        foreach ($quick_access as $index => $quick) {
            if ($quick['link'] == '../' && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $url = $this->context->shop->getBaseURL();
                if (!$url) {
                    unset($quick_access[$index]);
                    continue;
                }
                $quick_access[$index]['link'] = $url;
            } else {
                preg_match('/controller=(.+)(&.+)?$/', $quick['link'], $admin_tab);
                if (@RevsliderPrestashop::getIsset($admin_tab[1])) {
                    if (strpos($admin_tab[1], '&')) {
                        $admin_tab[1] = Tools::substr($admin_tab[1], 0, strpos($admin_tab[1], '&'));
                    }

                    $token = Tools::getAdminToken($admin_tab[1].(int)Tab::getIdFromClassName($admin_tab[1]).(int)$this->context->employee->id);
                    $quick_access[$index]['link'] .= '&token='.$token;
                }
            }
        }

        $name = $this->l('New Bookmark');
        if (@RevsliderPrestashop::getIsset($this->context->smarty->tpl_vars['breadcrumbs2']) && $this->context->smarty->tpl_vars['breadcrumbs2']->value['tab']['name']) {
            if ($this->context->smarty->tpl_vars['breadcrumbs2']->value['action']['name']) {
                $name = $this->context->smarty->tpl_vars['breadcrumbs2']->value['tab']['name'].' > '.$this->context->smarty->tpl_vars['breadcrumbs2']->value['action']['name'];
            } else {
                $name = $this->context->smarty->tpl_vars['breadcrumbs2']->value['tab']['name'];
            }
        } elseif (@RevsliderPrestashop::getIsset($this->context->smarty->tpl_vars['breadcrumbs2']) && is_string($this->context->smarty->tpl_vars['breadcrumbs2']->value)) {
            $name = $this->context->smarty->tpl_vars['breadcrumbs2']->value;
        }

        $link = preg_replace('/&token=[a-z0-9]{32}/', '', basename($_SERVER['REQUEST_URI']));

        $quick_access[] = array(
            'name' => $this->l('Bookmark this page'),
            'link' => $this->context->link->getAdminLink('AdminQuickAccesses').'&new_window=0&name_'.(int)Configuration::get('PS_LANG_DEFAULT').'='.urlencode($name).'&link='.urlencode($link).'&submitAddquick_access=1',
            'new_window' => 0
        );

        // Tab list
        $tabs = Tab::getTabs($this->context->language->id, 0);
        $current_id = Tab::getCurrentParentId();
        foreach ($tabs as $index => $tab) {
            if (!Tab::checkTabRights($tab['id_tab'])
                || ($tab['class_name'] == 'AdminStock' && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') == 0)
                || $tab['class_name'] == 'AdminCarrierWizard') {
                unset($tabs[$index]);
                continue;
            }

            $img_cache_url = 'themes/'.$this->context->employee->bo_theme.'/img/t/'.$tab['class_name'].'.png';
            $img_exists_cache = Tools::file_exists_cache(_PS_ADMIN_DIR_.$img_cache_url);
            // retrocompatibility : change png to gif if icon not exists
            if (!$img_exists_cache) {
                $img_exists_cache = Tools::file_exists_cache(_PS_ADMIN_DIR_.str_replace('.png', '.gif', $img_cache_url));
            }

            if ($img_exists_cache) {
                $path_img = $img = $img_exists_cache;
            } else {
                $path_img = _PS_IMG_DIR_.'t/'.$tab['class_name'].'.png';
                // Relative link will always work, whatever the base uri set in the admin
                $img = '../img/t/'.$tab['class_name'].'.png';
            }

            if (trim($tab['module']) != '') {
                $path_img = _PS_MODULE_DIR_.$tab['module'].'/'.$tab['class_name'].'.png';
                // Relative link will always work, whatever the base uri set in the admin
                $img = '../modules/'.$tab['module'].'/'.$tab['class_name'].'.png';
            }

            // retrocompatibility
            if (!file_exists($path_img)) {
                $img = str_replace('png', 'gif', $img);
            }
            // tab[class_name] does not contains the "Controller" suffix
            $tabs[$index]['current'] = ($tab['class_name'].'Controller' == get_class($this)) || ($current_id == $tab['id_tab']);
            $tabs[$index]['img'] = $img;
            $tabs[$index]['href'] = $this->context->link->getAdminLink($tab['class_name']);

            $sub_tabs = Tab::getTabs($this->context->language->id, $tab['id_tab']);
            foreach ($sub_tabs as $index2 => $sub_tab) {
                //check if module is enable and
                if (@RevsliderPrestashop::getIsset($sub_tab['module']) && !empty($sub_tab['module'])) {
                    $module = Module::getInstanceByName($sub_tab['module']);
                    if (is_object($module) && !$module->isEnabledForShopContext()) {
                        unset($sub_tabs[$index2]);
                        continue;
                    }
                }
                
                if (Tab::checkTabRights($sub_tab['id_tab']) === true && (bool)$sub_tab['active'] && $sub_tab['class_name'] != 'AdminCarrierWizard') {
                    // class_name is the name of the class controller

                    $sub_tabs[$index2]['href'] = $this->context->link->getAdminLink($sub_tab['class_name']);
                    $sub_tabs[$index2]['current'] = ($sub_tab['class_name'].'Controller' == get_class($this) || $sub_tab['class_name'] == Tools::getValue('controller'));
                } elseif ($sub_tab['class_name'] == 'AdminCarrierWizard' && $sub_tab['class_name'].'Controller' == get_class($this)) {
                    foreach ($sub_tabs as $i => $tab) {
                        if ($tab['class_name'] == 'AdminCarriers') {
                            break;
                        }
                    }
                    $sub_tabs[$i]['current'] = true;
                    unset($sub_tabs[$index2]);
                } else {
                    unset($sub_tabs[$index2]);
                }
            }

            $tabs[$index]['sub_tabs'] = $sub_tabs;
        }

        if (Validate::isLoadedObject($this->context->employee)) {
            $accesses = Profile::getProfileAccesses($this->context->employee->id_profile, 'class_name');
            /* Hooks are volontary out the initialize array (need those variables already assigned) */
            $bo_color = empty($this->context->employee->bo_color) ? '#FFFFFF' : $this->context->employee->bo_color;
            $this->context->smarty->assign(array(
                'autorefresh_notifications' => Configuration::get('PS_ADMINREFRESH_NOTIFICATION'),
                'help_box' => Configuration::get('PS_HELPBOX'),
                'round_mode' => Configuration::get('PS_PRICE_ROUND_MODE'),
                'brightness' => Tools::getBrightness($bo_color) < 128 ? 'white' : '#383838',
                'bo_width' => (int)$this->context->employee->bo_width,
                'bo_color' => @RevsliderPrestashop::getIsset($this->context->employee->bo_color) ? Tools::htmlentitiesUTF8($this->context->employee->bo_color) : null,
                'show_new_orders' => Configuration::get('PS_SHOW_NEW_ORDERS') && @RevsliderPrestashop::getIsset($accesses['AdminOrders']) && $accesses['AdminOrders']['view'],
                'show_new_customers' => Configuration::get('PS_SHOW_NEW_CUSTOMERS') && @RevsliderPrestashop::getIsset($accesses['AdminCustomers']) && $accesses['AdminCustomers']['view'],
                'show_new_messages' => Configuration::get('PS_SHOW_NEW_MESSAGES') && @RevsliderPrestashop::getIsset($accesses['AdminCustomerThreads'])&& $accesses['AdminCustomerThreads']['view'],
                'employee' => $this->context->employee,
                'search_type' => Tools::getValue('bo_search_type'),
                'bo_query' => Tools::safeOutput(Tools::stripslashes(Tools::getValue('bo_query'))),
                'quick_access' => $quick_access,
                'multi_shop' => Shop::isFeatureActive(),
                'shop_list' => Helper::renderShopList(),
                'shop' => $this->context->shop,
                'shop_group' => new ShopGroup((int)Shop::getContextShopGroupID()),
                'current_parent_id' => (int)Tab::getCurrentParentId(),
                'tabs' => $tabs,
                'is_multishop' => $is_multishop,
                'multishop_context' => $this->multishop_context,
                'default_tab_link' => $this->context->link->getAdminLink(Tab::getClassNameById((int)Context::getContext()->employee->default_tab)),
                'collapse_menu' => @RevsliderPrestashop::getIsset($this->context->cookie->collapse_menu) ? (int)$this->context->cookie->collapse_menu : 0
            ));
        } else {
            $this->context->smarty->assign('default_tab_link', $this->context->link->getAdminLink('AdminDashboard'));
        }

        $this->context->smarty->assign(array(
            'img_dir' => _PS_IMG_,
            'iso' => $this->context->language->iso_code,
            'class_name' => $this->className,
            'iso_user' => $this->context->language->iso_code,
            'country_iso_code' => $this->context->country->iso_code,
            'version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'full_language_code' => $this->context->language->language_code,
            'link' => $this->context->link,
            'shop_name' => Configuration::get('PS_SHOP_NAME'),
            'base_url' => $this->context->shop->getBaseURL(),
            'tab' => @RevsliderPrestashop::getIsset($tab) ? $tab : null, // Deprecated, this tab is declared in the foreach, so it's the last tab in the foreach
            'current_parent_id' => (int)Tab::getCurrentParentId(),
            'tabs' => $tabs,
            'install_dir_exists' => file_exists(_PS_ADMIN_DIR_.'/../install'),
            'pic_dir' => _THEME_PROD_PIC_DIR_,
            'controller_name' => htmlentities(Tools::getValue('controller')),
            'currentIndex' => self::$currentIndex,
            'bootstrap' => $this->bootstrap,
            'default_language' => (int)Configuration::get('PS_LANG_DEFAULT')
        ));

        $module = Module::getInstanceByName('themeconfigurator');
        $lang = '';
        if (Configuration::get('PS_REWRITING_SETTINGS') && count(Language::getLanguages(true)) > 1) {
            $lang = Language::getIsoById($this->context->employee->id_lang).'/';
        }
        if (is_object($module) && $module->active && (int)Configuration::get('PS_TC_ACTIVE') == 1 && $this->context->shop->getBaseURL()) {
            $this->context->smarty->assign(
                'base_url_tc',
                $this->context->shop->getBaseUrl()
                .(Configuration::get('PS_REWRITING_SETTINGS') ? '' : 'index.php')
                .$lang
                .'?live_configurator_token='.$module->getLiveConfiguratorToken()
                .'&id_employee='.(int)$this->context->employee->id
                .'&id_shop='.(int)$this->context->shop->id
                .(Configuration::get('PS_TC_THEME') != '' ? '&theme='.Configuration::get('PS_TC_THEME') : '')
                .(Configuration::get('PS_TC_FONT') != '' ? '&theme_font='.Configuration::get('PS_TC_FONT') : '')
            );
        }
    }
}
