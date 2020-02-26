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
use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

require_once dirname(__FILE__).'/src/IqitAdditionalTab.php';

class IqitAdditionalTabs extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';

    public $fields_list;
    public $fields_form;
    public $cfgName;
    public $defaults;
    public $templateFile;

    public function __construct()
    {
        $this->name = 'iqitadditionaltabs';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->cfgName = 'iqitadditionaltabs_';
        $this->defaults = array(
            'hook' => 0,
        );


        $this->bootstrap = true;
        parent::__construct();
        Shop::addTableAssociation('iqitadditionaltab', array('type' => 'shop'));

        $this->displayName = $this->l('IQITADDITIONALTABS - custom product tabs');
        $this->description = $this->l('Extend your products description with additional tabs');

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('displayAdminProductsExtra')
            || !$this->registerHook('displayProductExtraContent')
            || !$this->registerHook('backOfficeHeader')
            || !$this->registerHook('actionObjectProductDeleteAfter')
            || !$this->installSQL()) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        return $this->uninstallSQL() && parent::uninstall();
    }

    public function hookBackOfficeHeader()
    {
        Media::addJsDef(array('iqitModulesAdditionalTabs' => [
                'ajaxUrl' => $this->context->link->getAdminLink('AdminModules', true) . '&ajax=1&configure=' . $this->name
            ]));
    }

    public function getContent()
    {
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . '/views/js/bo_module.js');
        
        $output = '';
        $id_iqitadditionaltab = (int)Tools::getValue('id_iqitadditionaltab');

        if (Tools::isSubmit('added')) {
            $output .= '<div class="alert alert-success">'.$this->trans('Tab added', array(), 'Modules.IqitAdditionalTabs.Admin').'</div>';
        }

        if (Tools::isSubmit('submitModule')) {
            $this->clearCache();
            $this->postProcess();
        }


        // onSave
        if (Tools::isSubmit('saveIqitAdditionalTab')) {
            if ($id_iqitadditionaltab) {
                $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
            } else {
                $iqitAdditionalTab = new IqitAdditionalTab();
            }
            $iqitAdditionalTab->copyFromPost();
            $iqitAdditionalTab->id_product = 0;

            $id_shop_list = Tools::getValue('checkBoxShopAsso_iqitadditionaltab');
            if (isset($id_shop_list) && !empty($id_shop_list)) {
                $iqitAdditionalTab->id_shop_list = $id_shop_list;
            } else {
                $iqitAdditionalTab->id_shop_list[] =  (int)Context::getContext()->shop->id;
            }

            if ($iqitAdditionalTab->validateFields(false) && $iqitAdditionalTab->validateFieldsLang(false)) {
                $iqitAdditionalTab->save();

                $this->clearCache();
                Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&added&token=' . Tools::getAdminTokenLite('AdminModules'));
            } else {
                $output .= '<div class="conf error">'.$this->trans('An error occurred while attempting to save.', array(), 'Admin.Notifications.Error').'</div>';
            }
        }

        // show edit form
        if (Tools::isSubmit('updateiqitadditionaltabs') || Tools::isSubmit('addIqitAdditionalTab')) {
            $helper = $this->initForm();
            foreach (Language::getLanguages(false) as $lang) {
                if ($id_iqitadditionaltab) {
                    $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
                    $helper->id = (int)$id_iqitadditionaltab;
                    $helper->fields_value['title'][(int)$lang['id_lang']] = $iqitAdditionalTab->title[(int)$lang['id_lang']];
                    $helper->fields_value['active'] = $iqitAdditionalTab->active;
                    $helper->fields_value['description'][(int)$lang['id_lang']] = $iqitAdditionalTab->description[(int)$lang['id_lang']];
                    $helper->fields_value['description'][(int)$lang['id_lang']] = $iqitAdditionalTab->description[(int)$lang['id_lang']];
                } else {
                    $helper->fields_value['title'][(int)$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], '');
                    $helper->fields_value['active'] = Tools::getValue('active');
                    $helper->fields_value['description'][(int)$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], '');
                }
            }
            $helper->table = 'iqitadditionaltab';
            $helper->identifier = 'id_iqitadditionaltab';
            if ($id_iqitadditionaltab = Tools::getValue('id_iqitadditionaltab')) {
                $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_iqitadditionaltab');
                $helper->fields_value['id_iqitadditionaltab'] = (int)$id_iqitadditionaltab;
            }
            return $output.$helper->generateForm($this->fields_form);
        } elseif (Tools::isSubmit('deleteiqitadditionaltabs')) {
            $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
            $iqitAdditionalTab->delete();
            $this->clearCache();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } elseif (Tools::isSubmit('changeStatus')) {
            $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
            if ($iqitAdditionalTab->active == 0) {
                $iqitAdditionalTab->active = 1;
            } else {
                $iqitAdditionalTab->active = 0;
            }
            $iqitAdditionalTab->update(false, true);
            $this->clearCache();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else {
            $output .= $this->renderForm();
            $output .= $this->initList();
        }


        return $output;
    }

    protected function initList()
    {
        $tabs = IqitAdditionalTab::getTabs('global');

        foreach ($tabs as $key => $tab) {
            $tabs[$key]['status'] = $this->displayStatus($tab['id_iqitadditionaltab'], $tab['active']);
            $associated_shop_ids = IqitAdditionalTab::getAssociatedIdsShop((int)$tab['id_iqitadditionaltab']);
            if ($associated_shop_ids && count($associated_shop_ids) > 1) {
                $tabs[$key]['is_shared'] = true;
            } else {
                $tabs[$key]['is_shared'] = false;
            }
        }

        $this->context->smarty->assign(array(
            'path' => $this->_path,
            'tabs' => $tabs,
            'link' => $this->context->link,
            'module' => $this->name,
        ));

        return $this->display(__FILE__, 'views/templates/admin/bo_module.tpl');
    }

    protected function initForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->trans('New Tab', array(), 'Modules.IqitAdditionalTabs.Admin'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enabled'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Title'),
                    'name' => 'title',
                    'lang' => true,
                ),
                array(
                     'type' => 'textarea',
                     'label' => $this->l('Description'),
                     'name' => 'description',
                     'autoload_rte' => true,
                     'lang' => true,
                 ),
            ),
            'submit' => array(
                'title' => $this->trans('Save', array(), 'Admin.Actions'),
            ),
            'buttons' => array(
                'cancelBlock' => array(
                    'title' => $this->l('Back to list'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                    'icon' => 'process-icon-back',
                ),
            ),
        );

        if (Shop::isFeatureActive()) {
            $this->fields_form[0]['form']['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang) {
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );
        }
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->submit_action = 'saveIqitAdditionalTab';
        return $helper;
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $languages = $this->context->controller->getLanguages();
        $default_language = (int) Configuration::get('PS_LANG_DEFAULT');

        $idProduct = (int) Tools::getValue('id_product', $params['id_product']);

        $tabs = array();
        $tabsIds = IqitAdditionalTab::getIdTabs('product', $idProduct, false);

        foreach ($tabsIds as $key => $tabId) {

            $tab = new IqitAdditionalTab((int)$tabId['id_iqitadditionaltab']);

            $tabs[$tabId['id_iqitadditionaltab']] = (array) $tab;
            $tabs[$tabId['id_iqitadditionaltab']]['status'] = $this->displayStatus($tab->id_iqitadditionaltab, $tab->active);
            $associated_shop_ids = IqitAdditionalTab::getAssociatedIdsShop((int)$tab->id_iqitadditionaltab);
            if ($associated_shop_ids && count($associated_shop_ids) > 1) {
                $tabs[$tabId['id_iqitadditionaltab']]['is_shared'] = true;
            } else {
                $tabs[$tabId['id_iqitadditionaltab']]['is_shared'] = false;
            }


        }

        $this->context->smarty->assign(array(
            'path' => $this->_path,
            'tabs' => $tabs,
            'idProduct' =>$idProduct,
            'languages' => $languages,
            'default_language' => $default_language,
            'id_language' => $this->context->language->id,
            'link' => $this->context->link,
            'module' => $this->name,
        ));


        return $this->display(__FILE__, 'views/templates/admin/bo_productab.tpl');
    }

    public function ajaxProcessUpdatePositions()
    {
        $tabs = Tools::getValue('tabs');
        IqitAdditionalTab::updatePositions($tabs);
        $this->clearCache();
        die(true);
    }

    public function ajaxProcessUpdatePositionsProduct()
    {
        $tabs = Tools::getValue('iqitadditionaltabs');
        IqitAdditionalTab::updatePositions($tabs);
        $this->clearCache();
        die(true);
    }


    public function ajaxProcessAddTabProduct()
    {
        header('Content-Type: application/json');

        parse_str(Tools::getValue('fields'), $fields);

        $idProduct = Tools::getValue('idProduct');
        $id_iqitadditionaltab = (int) $fields[$this->name]['id_iqitadditionaltab'];

        $action = 'add';

        if ($id_iqitadditionaltab) {
            $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
            $action = 'edit';
        } else {
            $iqitAdditionalTab = new IqitAdditionalTab();
            $iqitAdditionalTab->id_product = $idProduct;
        }

        if (isset($fields[$this->name]['active'])) {
            $fields[$this->name]['active'] = 1;
        } else {
            $fields[$this->name]['active'] = 0;
        }

        $iqitAdditionalTab->copyFromAjax($fields[$this->name]);

        if (Shop::getContext() == Shop::CONTEXT_ALL) {
            $iqitAdditionalTab->id_shop_list = Shop::getShops(true, null, true);
        } else {
            $iqitAdditionalTab->id_shop_list[] = (int) Context::getContext()->shop->id;
        }


        if ($iqitAdditionalTab->validateFields(false) && $iqitAdditionalTab->validateFieldsLang(false)) {
            $iqitAdditionalTab->save();
            $this->clearCache($idProduct);
            $return = array(
                'status' => true,
                'action' => $action,
                'message' => $this->trans('Tab saved', array(), 'Modules.IqitAdditionalTabs.Admin'),
                'tab' => [
                    'id' => $iqitAdditionalTab->id,
                    'title' =>  $iqitAdditionalTab->title
                ]
            );
        } else {
            $return = array(
                'status' => false,
                'message' => $this->trans('An problem occured during adding tab', array(), 'Modules.IqitAdditionalTabs.Admin')
            );
        }

        die(json_encode($return));
    }

    public function ajaxProcessDeleteTabProduct()
    {
        $id_iqitadditionaltab = (int)Tools::getValue('id_iqitadditionaltab');

        $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);
        $iqitAdditionalTab->delete();
        $this->clearCache();
        die(true);
    }

    public function ajaxProcessGetTabProduct()
    {
        header('Content-Type: application/json');
        $id_iqitadditionaltab = (int)Tools::getValue('id_iqitadditionaltab');
        $iqitAdditionalTab = new IqitAdditionalTab((int)$id_iqitadditionaltab);

        $return = array(
            'status' => true,
            'tab' => [
                'id' => $iqitAdditionalTab->id,
                'title' =>  $iqitAdditionalTab->title,
                'description' =>  $iqitAdditionalTab->description,
                'active' => (bool)$iqitAdditionalTab->active,
            ]
        );

        die(json_encode($return));
    }


    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Hook'),
                        'name' => 'hook',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('With other tabs'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('As accordion below "add to cart"'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'name' => 'submitModule',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        if (Shop::isFeatureActive()) {
            $fields_form['form']['description'] = $this->l('The modifications will be applied to') . ' ' . (Shop::getContext() == Shop::CONTEXT_SHOP ? $this->l('shop') . ' ' . $this->context->shop->name : $this->l('all shops'));
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form));
    }


    public function getConfigFieldsValues()
    {
        $var = array();
        foreach ($this->defaults as $default => $value) {
                $var[$default] = Configuration::get($this->cfgName . $default);

        }
        return $var;
    }

    protected function postProcess()
    {
        foreach ($this->defaults as $default => $value) {

            if ($default == 'hook') {
                if ((bool)Tools::getValue($default)) {
                    $this->registerHook('displayReassurance');
                    $this->unregisterHook('displayProductExtraContent');
                } else {
                    $this->unregisterHook('displayReassurance');
                    $this->registerHook('displayProductExtraContent');
                }
            }
            Configuration::updateValue($this->cfgName . $default, (Tools::getValue($default)));
        }
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {
            return $this->getWidgetVariables($hookName, $configuration);
        } else{
            if ($this->context->controller->php_self != 'product') {
                return;
            }
            $idProduct = (int) $configuration['smarty']->tpl_vars['product']->value['id_product'];
            $cacheId = 'iqitadditionaltabs|'.$idProduct;

            if (!$this->isCached($this->templateFile, $this->getCacheId($cacheId))) {
                $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
            }
            return $this->fetch($this->templateFile, $this->getCacheId($cacheId));
        }
        return;
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {
            $idProduct = (int) $configuration['product']->id;
            $cacheId = 'IqitAdditionalTabs_' . $idProduct;

            if (!Cache::isStored($cacheId)) {
                $array = array();
                $tabs = IqitAdditionalTab::getTabs('all', $idProduct, true);

                foreach ($tabs as $key => $tab) {
                    if ($tab['title']) {
                        $array[] = (new ProductExtraContent())
                            ->setTitle($tab['title'])
                            ->setContent('<div class="rte-content">'.$tab['description'].'</div>');
                    }
                }
                Cache::store($cacheId, $array);
            }
            return Cache::retrieve($cacheId);
        } else{
            $idProduct = (int) $configuration['smarty']->tpl_vars['product']->value['id_product'];
            $tabs = IqitAdditionalTab::getTabs('all', $idProduct, true);

            return array(
                'tabs' => $tabs,
            );
        }
        return;
    }

    public function hookActionObjectProductDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }

        $idProduct = (int) $params['object']->id;
        $id = IqitAdditionalTab::getIdByProduct($idProduct);

    
        $object = new IqitAdditionalTab($id);

        if (Validate::isLoadedObject($object)) {
            $object->delete();
        }

        $this->clearCache($idProduct);
    }

    public function clearCache($idProduct = 0)
    {
        if ($idProduct) {
            $this->_clearCache($this->templateFile, 'iqitadditionaltabs|' . $idProduct);
        } else {
            $this->_clearCache($this->templateFile);
        }
    }

    public function displayStatus($id_iqitadditionaltab, $active)
    {
        $title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
        $icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
        $class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
        $html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
            '&configure='.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules').
                '&changeStatus&id_iqitadditionaltab='.(int)$id_iqitadditionaltab.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';
        return $html;
    }


    /**
     * Install SQL
     * @return boolean
     */
    private function installSQL()
    {
          if (!file_exists(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__)  . self::INSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }

        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }

    /**
     * Uninstall SQL
     * @return boolean
     */
    private function uninstallSQL()
    {
        if (!file_exists(dirname(__FILE__)  . self::UNINSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::UNINSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }

        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }
}
