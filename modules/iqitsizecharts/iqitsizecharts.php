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
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2017 IQIT-COMMERCE.COM
 * @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

require_once dirname(__FILE__) . '/src/IqitSizeCharts.php';

class IqitSizeCharts extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';

    public $fields_list;
    public $fields_form;

    protected $templateFile;
    protected $templatePath;

    public function __construct()
    {
        $this->name = 'iqitsizecharts';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->tab = 'front_office_features';
        $this->version = '1.2.0';
        $this->cfgName = 'iqitsizecharts_';
        $this->defaults = array(
            'status' => 0,
            'attributes' => 0,
        );

        $this->bootstrap = true;
        parent::__construct();
        Shop::addTableAssociation('iqitsizechart', array('type' => 'shop'));

        $this->displayName = $this->l('IQITSIZECHARTS - table size chars for products');
        $this->description = $this->l('Size charts for your products');

        $this->templatePath = 'module:' . $this->name . '/views/templates/hook/';
        $this->templateFile = 'module:' . $this->name . '/views/templates/hook/' . $this->name . '.tpl';

    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('displayAdminProductsExtra')
            || !$this->registerHook('displayProductVariants')
            || !$this->registerHook('backOfficeHeader')
            || !$this->registerHook('header')
            || !$this->registerHook('actionObjectProductUpdateAfter')
            || !$this->registerHook('actionObjectProductDeleteAfter')
            || !$this->installSQL()
        ) {
            return false;
        }

        $this->setDefaults();

        return true;
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }

        return $this->uninstallSQL() && parent::uninstall();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->cfgName . $default, $value);
        }
    }

    public function hookBackOfficeHeader()
    {
        Media::addJsDef(array(
            'iqitModulesSizeCharts' => [
                'ajaxUrl' => $this->context->link->getAdminLink('AdminModules',
                        true) . '&ajax=1&configure=' . $this->name
            ]
        ));
    }

    public function hookHeader()
    {
        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style', 'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);
    }


    public function getContent()
    {
        $this->context->controller->addJS($this->_path . '/views/js/bo_module.js');

        $output = '';
        $id_iqitsizechart = (int)Tools::getValue('id_iqitsizechart');

        if (Tools::isSubmit('added')) {
            $output .= '<div class="alert alert-success">' . $this->trans('Chart added', array(),
                    'Modules.IqitSizeCharts.Admin') . '</div>';
        }

        // onSave
        if (Tools::isSubmit('saveIqitSizeChart')) {
            if ($id_iqitsizechart) {
                $iqitAdditionalTab = new IqitSizeChart((int)$id_iqitsizechart);
            } else {
                $iqitAdditionalTab = new IqitSizeChart();
            }
            $iqitAdditionalTab->copyFromPost();

            $id_shop_list = Tools::getValue('checkBoxShopAsso_iqitsizechart');
            if (isset($id_shop_list) && !empty($id_shop_list)) {
                $iqitAdditionalTab->id_shop_list = $id_shop_list;
            } else {
                $iqitAdditionalTab->id_shop_list[] = (int)Context::getContext()->shop->id;
            }

            if ($iqitAdditionalTab->validateFields(false) && $iqitAdditionalTab->validateFieldsLang(false)) {
                $iqitAdditionalTab->save();
                $iqitAdditionalTab->updateCategories(Tools::getValue('categoryBox'));
                $iqitAdditionalTab->updateBrands(Tools::getValue('brands'));


                $this->clearCache();
                Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&added&token=' . Tools::getAdminTokenLite('AdminModules'));
            } else {
                $output .= '<div class="conf error">' . $this->trans('An error occurred while attempting to save.',
                        array(), 'Admin.Notifications.Error') . '</div>';
            }
        }

        if (Tools::isSubmit('submitModule')) {
            $this->postProcess();
        }

        // show edit form
        if (Tools::isSubmit('updateiqitsizecharts') || Tools::isSubmit('addIqitSizeChart')) {
            $helper = $this->initForm();
            foreach (Language::getLanguages(false) as $lang) {
                if ($id_iqitsizechart) {
                    $iqitAdditionalTab = new IqitSizeChart((int)$id_iqitsizechart);
                    $helper->id = (int)$id_iqitsizechart;
                    $helper->fields_value['title'][(int)$lang['id_lang']] = $iqitAdditionalTab->title[(int)$lang['id_lang']];
                    $helper->fields_value['active'] = $iqitAdditionalTab->active;
                    $helper->fields_value['brands[]'] = IqitSizeChart::getChartBrands($id_iqitsizechart);
                    $helper->fields_value['description'][(int)$lang['id_lang']] = $iqitAdditionalTab->description[(int)$lang['id_lang']];
                    $helper->fields_value['description'][(int)$lang['id_lang']] = $iqitAdditionalTab->description[(int)$lang['id_lang']];
                } else {
                    $helper->fields_value['title'][(int)$lang['id_lang']] = Tools::getValue('title_' . (int)$lang['id_lang'],
                        '');
                    $helper->fields_value['active'] = true;
                    $helper->fields_value['brands[]'] = [0];
                    $helper->fields_value['description'][(int)$lang['id_lang']] = Tools::getValue('description_' . (int)$lang['id_lang'],
                        '');
                }
            }
            $helper->table = 'iqitsizechart';
            $helper->identifier = 'id_iqitsizechart';
            if ($id_iqitsizechart = Tools::getValue('id_iqitsizechart')) {
                $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_iqitsizechart');
                $helper->fields_value['id_iqitsizechart'] = (int)$id_iqitsizechart;
            }
            return $output . $helper->generateForm($this->fields_form);
        } elseif (Tools::isSubmit('deleteiqitsizecharts')) {
            $iqitSizeChart = new IqitSizeChart((int)$id_iqitsizechart);
            $iqitSizeChart->delete();
            $this->clearCache();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else {
            $output .= $this->renderForm();
            $output .= $this->initList();
        }


        return $output;
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
                        'type' => 'switch',
                        'label' => $this->l('Show available sizes on products list'),
                        'name' => 'status',
                        'is_bool' => true,
                        'desc' => $this->l('If enabled on products list there will be available sizes box. 
                                            You need to select attributes consider as size'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'attribute_checboxes',
                        'label' => $this->l('Select attribute which you consider as size'),
                        'name' => 'attributes',
                        'desc' => $this->l('You need to select attribute which is consider as size'),
                        'options' => array(
                            'query' => $this->getAttributes(),
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
            if ($default == 'attributes') {
                $selectedSizes = $this->unserializeSizes(Configuration::get($this->cfgName . $default));
                if (is_array($selectedSizes)) {
                    $var[$default] = $selectedSizes;
                } else {
                    $var[$default] = array();
                }
            } else {
                $var[$default] = Configuration::get($this->cfgName . $default);
            }
        }
        return $var;
    }

    protected function postProcess()
    {
        foreach ($this->defaults as $default => $value) {
            if ($default == 'status') {
                if ((bool)Tools::getValue($default)) {
                    $this->registerHook('displayProductListBelowButton');
                } else {
                    $this->unregisterHook('displayProductListBelowButton');
                }
                Configuration::updateValue($this->cfgName . $default, (Tools::getValue($default)));
            } elseif ($default == 'attributes') {
                if (Tools::getValue($default)) {
                    Configuration::updateValue($this->cfgName . $default,
                        $this->serializeSizes(Tools::getValue($default)));
                } else {
                    Configuration::updateValue($this->cfgName . $default, '');
                }
            } else {
                Configuration::updateValue($this->cfgName . $default, (Tools::getValue($default)));
            }
        }
    }

    public function serializeSizes($array)
    {
        return (string)implode(',', $array);
    }

    public function unserializeSizes($string)
    {
        return explode(',', $string);
    }

    public function getAttributes()
    {
        $attributes = AttributeGroup::getAttributesGroups($this->context->language->id);

        $selectAttributes = array();

        foreach ($attributes as $attribute) {
            $selectAttributes[$attribute['id_attribute_group']]['id_option'] = $attribute['id_attribute_group'];
            $selectAttributes[$attribute['id_attribute_group']]['name'] = $attribute['name'];
        }

        return $selectAttributes;
    }

    protected function initList()
    {
        $charts = IqitSizeChart::getCharts();

        foreach ($charts as $key => $chart) {
            $associated_shop_ids = IqitSizeChart::getAssociatedIdsShop((int)$chart['id_iqitsizechart']);
            if ($associated_shop_ids && count($associated_shop_ids) > 1) {
                $charts[$key]['is_shared'] = true;
            } else {
                $charts[$key]['is_shared'] = false;
            }
        }

        $this->context->smarty->assign(array(
            'path' => $this->_path,
            'charts' => $charts,
            'link' => $this->context->link,
            'module' => $this->name,
        ));

        return $this->display(__FILE__, 'views/templates/admin/bo_module.tpl');
    }

    protected function initForm()
    {
        $id_iqitsizechart = (int)Tools::getValue('id_iqitsizechart');
        $selectedCategories = IqitSizeChart::getChartCategories($id_iqitsizechart);



        $brandsSelect =[
            array(
                'id_manufacturer' => 0,
                'name' => '--- All ----',
            )
        ];

        $brandsSoruce = Manufacturer::getManufacturers();
        $brands = array_merge($brandsSelect,$brandsSoruce);


        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->trans('New size Chart', array(), 'Modules.IqitSizeCharts.Admin'),
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
                    'type' => 'categories',
                    'name' => 'categoryBox',
                    'label' => $this->l('Assign to categories'),
                    'desc' => $this->l('If product have selected category set as main category then size chart will be showed on product Page. 
                    You can also assign chart per specified product, during product edit in backfoffice'),
                    'tree' => array(
                        'id' => 'categories-tree',
                        'selected_categories' => $selectedCategories,
                        'root_category' => (int)$this->context->shop->getCategory(),
                        'use_search' => true,
                        'use_checkbox' => true
                    ),
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Assign to brands'),
                    'name' => 'brands',
                    'multiple' => true,
                    'size' => 20,
                    'desc' => $this->l('Will show sizechart only if product is on selected category and brand'),
                    'options' => array(
                        'query' => $brands,
                        'id' => 'id_manufacturer',
                        'name' => 'name',
                    ),
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Description'),
                    'name' => 'description',
                    'autoload_rte' => true,
                    'lang' => true,
                    'class' => 'js-chart-content'
                ),
                array(
                    'type' => 'table_generator',
                    'label' => $this->l('Table generator'),
                    'name' => 'table_generator',
                ),
            ),
            'submit' => array(
                'title' => $this->trans('Save', array(), 'Admin.Actions'),
            ),
            'buttons' => array(
                'cancelBlock' => array(
                    'title' => $this->l('Back to list'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
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
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->tpl_vars = array(
            'module_path' => $this->_path,
        );
        $helper->submit_action = 'saveIqitSizeChart';
        return $helper;
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $idProduct = (int)Tools::getValue('id_product', $params['id_product']);
        $charts = IqitSizeChart::getCharts();
        $selectedChart = IqitSizeChart::getChartAssignedToProduct($idProduct);


        $this->context->smarty->assign(array(
            'path' => $this->_path,
            'charts' => $charts,
            'selectedChart' => $selectedChart,
            'idProduct' => $idProduct,
            'link' => $this->context->link,
            'moduleLink' => $this->context->link->getAdminLink('AdminModules') . '&configure=iqitsizecharts&addIqitSizeChart=1',
            'module' => $this->name,
        ));

        return $this->display(__FILE__, 'views/templates/admin/bo_productab.tpl');
    }


    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {
            return $this->getWidgetVariables($hookName, $configuration);
        } elseif (preg_match('/^displayProductListBelowButton\d*$/', $hookName)) {

            $templateFile = 'available-sizes.tpl';
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

            return $this->fetch($this->templatePath . $templateFile);
        } elseif (preg_match('/^displayProductAdditionalInfo\d*$/', $hookName) || preg_match('/^displayProductVariants\d*$/', $hookName) || preg_match('/^displayAfterProductAddCartBtn\d*$/', $hookName))
        {
            $idProduct = (int)$configuration['smarty']->tpl_vars['product']->value['id_product'];

            $cacheId = 'iqitsizecharts|' . $idProduct;

            if (!$this->isCached($this->templateFile, $this->getCacheId($cacheId))) {
                $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
            }
            return $this->fetch($this->templateFile, $this->getCacheId($cacheId));
        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {
            $array = array();
            $idProduct = (int)$configuration['product']->id;
            $idLang = (int)$this->context->language->id;
            $idShop = (int)$this->context->shop->id;
            $productChart = IqitSizeChart::getChartAssignedToProduct($idProduct);
            $idCategory = (int)$configuration['product']->id_category_default;
            $id_manufacturer = $configuration['product']->id_manufacturer;

            $charts = array();
            if ($productChart > 0) {
                $charts[] = (array)new IqitSizeChart($productChart, $idLang, $idShop);
            } elseif ($productChart == 0) {
                return $array;
            } else {
                $charts = IqitSizeChart::getChartsByCategoryAndBrand($idCategory, $id_manufacturer);
            }

            foreach ($charts as $key => $chart) {
                if ($chart['title']) {
                    $array[] = (new ProductExtraContent())
                        ->setTitle($chart['title'])
                        ->setContent('<div class="rte-content">'.$chart['description'].'</div>');
                }
            }
            return $array;
        } elseif (preg_match('/^displayProductListBelowButton\d*$/', $hookName)) {


            $avaiableSizes = array();
            $checkedSizes = array();
            $idProduct = (int)$configuration['product']['id_product'];
            $sizeAttr = Configuration::get($this->cfgName . 'attributes');

            if ($sizeAttr == '') {
                return;
            }

            $combinations = $this->getAttributeCombinations($idProduct, $sizeAttr);

            foreach ($combinations as $combination) {
                if (!in_array($combination['id_attribute_group'] .'_'.$combination['id_attribute'], $checkedSizes)) {
                    $avaiableSizes[$combination['id_attribute_group'] .'_'.$combination['id_attribute']]['available'] = false;
                    $avaiableSizes[$combination['id_attribute_group'] .'_'.$combination['id_attribute']]['attribute_name'] = $combination['attribute_name'];
                    if (($combination['quantity'] > 0 || !Configuration::get('PS_STOCK_MANAGEMENT'))) {
                        $avaiableSizes[$combination['id_attribute_group'] .'_'.$combination['id_attribute']]['available'] = true;
                        $checkedSizes[] = $combination['id_attribute_group'] .'_'.$combination['id_attribute'];
                    }
                }
            }

            return array(
                'avaiableSizes' => $avaiableSizes,
            );
        } elseif (preg_match('/^displayProductAdditionalInfo\d*$/',
                $hookName) || preg_match('/^displayProductVariants\d*$/', $hookName) || preg_match('/^displayAfterProductAddCartBtn\d*$/', $hookName)
        ) {
            $idProduct = (int)$configuration['product']['id_product'];
            $idCategory = (int)$configuration['product']['id_category_default'];
            $idLang = (int)$this->context->language->id;
            $idShop = (int)$this->context->shop->id;
            $id_manufacturer = $configuration['product']['id_manufacturer'];


            $productChart = IqitSizeChart::getChartAssignedToProduct($idProduct);

            $charts = array();
            if ($productChart > 0) {
                $charts[] = (array)new IqitSizeChart($productChart, $idLang, $idShop);
            } elseif ($productChart == 0) {
                return $charts;
            } else {
                $charts = IqitSizeChart::getChartsByCategoryAndBrand($idCategory, $id_manufacturer);
            }

            return array(
                'charts' => $charts,
            );
        }
    }

    public function getAttributeCombinations(
        $idProduct = null,
        $sizeAttr = null,
        $id_lang = null
    ) {
        if (!Combination::isFeatureActive()) {
            return array();
        }
        if (is_null($id_lang)) {
            $id_lang = Context::getContext()->language->id;
        }
        $sql = 'SELECT pa.id_product_attribute, ag.`id_attribute_group`, ag.`is_color_group`, al.`name` AS attribute_name,
					a.`id_attribute`
				FROM `' . _DB_PREFIX_ . 'product_attribute` pa
				' . Shop::addSqlAssociation('product_attribute', 'pa') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' . (int)$id_lang . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' . (int)$id_lang . ')
				WHERE pa.`id_product` = ' . (int)$idProduct . ' AND ag.`id_attribute_group` IN (' . $sizeAttr . ') 
				GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
				ORDER BY ag.`id_attribute_group`, pa.`id_product_attribute`';
        $res = Db::getInstance()->executeS($sql);
        //Get quantity of each variations
        foreach ($res as $key => $row) {
            $cache_key = $idProduct . '_' . $row['id_product_attribute'] . '_quantity';
            if (!Cache::isStored($cache_key)) {
                Cache::store(
                    $cache_key,
                    StockAvailable::getQuantityAvailableByProduct($idProduct, $row['id_product_attribute'])
                );
            }
            $res[$key]['quantity'] = Cache::retrieve($cache_key);
        }
        return $res;
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }

        $this->joinWithProduct($params['object']->id);
    }

    public function joinWithProduct($idProduct)
    {
        $chart = (int)Tools::getValue('iqitsizecharts')['chart'];

        if ($chart >= 0) {
            IqitSizeChart::assignProduct($idProduct, $chart);
        } else {
            IqitSizeChart::deleteAssignedProduct($idProduct);
        }

        $this->clearCache($idProduct);
    }

    public function hookcActionObjectProductDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }

        IqitSizeChart::deleteAssignedProduct($params['object']->id);

        $this->clearCache($params['object']->id);
    }


    public function clearCache($idProduct = 0)
    {
        if ($idProduct) {
            $this->_clearCache($this->templateFile, $this->name . '|' . $idProduct);
        } else {
            $this->_clearCache($this->templateFile);
        }
    }

    private function installSQL()
    {
          if (!file_exists(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
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
