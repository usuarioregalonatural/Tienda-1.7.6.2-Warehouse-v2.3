<?php
/**
 * 2019 Anvanto
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author Anvanto (anvantoco@gmail.com)
 *  @copyright  2019 anvanto.com

 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . 'an_productfields/includer.php';

/**
 * Class an_productfields
 */
class an_productfields extends Module
{
    /**
     * @var []
     */
    protected $_hooks = array(
        'displayOrderDetail',
        'displayAdminOrderTabOrder',
        'displayAdminOrderContentOrder',
        'displayAdminProductsExtra',
        'displayProductButtons',
        'actionProductUpdate',
        'actionCartSave',
        'displayHeader',
        'displayCartExtraProductActions',
        'actionCartUpdateQuantityBefore',
        'actionBeforeCartUpdateQty',
        'displayPDFInvoice',
        'sendMailAlterTemplateVars',
    );

    /**
     * @var []
     */
    protected $_tabs = array(
        array(
            'class_name' => 'AdminAnProductFields',
            'parent' => 'AdminCatalog',
            'name' => 'AN Product Fields'
        )
    );

    /**
     * an_productfields constructor.
     */
    public function __construct()
    {
        $this->name = 'an_productfields';
        $this->tab = 'front_office_features';
        $this->version = '2.3.9';
        $this->author = 'Anvanto';
        $this->need_instance = 0;
        $this->module_key = '287371d6b8342faf7eb9100e091c7e07';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product Fields manager');
        $this->description = $this->l('Easy product fields manager for PrestaShop v.1.7.x');
        $this->new = version_compare(_PS_VERSION_, '1.6.9.9', '>') ? true : false;
        $this->morenew =  version_compare(_PS_VERSION_, '1.7.3', '<') ? false : true;
        $this->displayProduct = false;
        $this->firsttime = true;
    }

    /**
     * @return bool
     */
    public function install($reset = false)
    {
        if (parent::install()) {
            if (!$reset) {
                $sql = array();
                include($this->getDir('sql/install.php'));
                foreach ($sql as $_sql) {
                    Db::getInstance()->Execute($_sql);
                }
            }

            foreach ($this->_hooks as $hook) {
                if (!$this->registerHook($hook)) {
                    return false;
                }
            }

            $languages = Language::getLanguages();
            foreach ($this->_tabs as $tab) {
                $_tab = new Tab();
                $_tab->class_name = $tab['class_name'];
                $_tab->id_parent = ($tab['parent'] != false ? Tab::getIdFromClassName($tab['parent']) : 0);
                if (empty($_tab->id_parent)) {
                    $_tab->id_parent = 0;
                }
                $_tab->module = $this->name;
                foreach ($languages as $language) {
                    $_tab->name[$language['id_lang']] = $this->l($tab['name']);
                }
                $_tab->add();
            }
            $return = Configuration::updateValue('an_pf_include_tax', true);
            $return &= Configuration::updateValue('an_pf_include_specific', true);
            $return &= Configuration::updateValue('an_pf_dynamic_price', true);
            $return &= Configuration::updateValue('an_pf_text_counter', false);
            if ($this->new) {
                $return &= Configuration::updateValue('an_pf_js_position', '.product-add-to-cart');
            } else {
                $return &= Configuration::updateValue('an_pf_js_position', '.box-cart-bottom');
            }
            $return &= Configuration::updateValue('an_pf_js_position_type', 'before');

            $languages = Language::getLanguages(false);

            $valuesPfHeader = array();
            foreach ($languages as $lang) {
                $valuesPfHeader[$lang['id_lang']] = 'Additional information';
            }

            $return &= Configuration::updateValue('an_pf_header_text', $valuesPfHeader);

            return $return;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function uninstall($reset = false)
    {
        if (parent::uninstall()) {
            if (!$reset) {
                $sql = array();
                include($this->getDir('sql/uninstall.php'));
                foreach ($sql as $_sql) {
                    Db::getInstance()->Execute($_sql);
                }
            }
            foreach ($this->_tabs as $tab) {
                $_tab_id = Tab::getIdFromClassName($tab['class_name']);
                $_tab = new Tab($_tab_id);
                $_tab->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function reset($without_delete = true)
    {
        if (!$this->uninstall($without_delete)) {
            return false;
        }
        if (!$this->install($without_delete)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $file
     * @return string
     */
    public function getDir($file = '')
    {
        return _PS_MODULE_DIR_ . $this->name . DIRECTORY_SEPARATOR . $file;
    }

    /**
     *
     */
    public function getContent()
    {
        if (Tools::getIsset('an_pf_reset')) {
            die($this->uninstall(true) && $this->install(true));
        }
        $redirect = $this->context->link->getAdminLink('AdminAnProductFields');
        Tools::redirectAdmin($redirect);
    }

    /**
     * @param $params
     * @return mixed|string
     */
    public function hookDisplayAdminProductsExtra($params)
    {
        $id_product = $this->new ? (int)$params['id_product'] : Tools::getValue('id_product');
        if ($id_product) {
            $stores = Shop::getContextListShopID();
            if (count($stores) > 1) {
                return $this->l('Please select a shop!');
            }

            $helper = new HelperForm();
            $helper->base_folder = realpath($this->context->smarty->getTemplateDir(0) . '../../default/template') . '/';
            $helper->base_tpl = 'helpers/form/form.tpl';
            $helper->first_call = false;

            $name = $this->display(__FILE__, 'views/templates/admin/fieldname.tpl');
            $this->fields_form[0]['form'] = array(
                'tinymce' => false,
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'an_productfields[id_product]',
                    ),
                    array(
                        'type' => 'free',
                        'label' => $name,
                        'name' => 'header_line'
                    )
                ),
                'submit' => array(
                    'name' => 'submitAddproductAndStay',
                    'title' => $this->l('   Save And Stay  '),
                ),
            );

            $this->context->smarty->assign(array(
                'morenew' => $this->morenew
            ));
            $helper->fields_value['an_productfields[id_product]'] = $id_product;
            $helper->fields_value['header_line'] = $this->display($this->name, 'product_edit_header.tpl');

            $fields = new Collection('AnProductFields', $this->context->language->id);
            $fields->where('is_enabled', '=', 1);
            $fields->orderBy('sort_order');

            if (count($fields)) {
                foreach ($fields as $field) {
                    $inputName = 'an_productfields[fields][' . $field->id . ']';
                    $this->fields_form[0]['form']['input'][] = array(
                        'type' => 'free',
                        'label' => $field->code,
                        'name' => $inputName
                    );
                    $disabled = false;
                    $product_categories = Product::getProductCategories($id_product);
                    if ((bool)$field->apply_for_all_products
                        || ((bool)$field->categories && $this->arrayHasSimilar($product_categories, explode(';', $field->categories)))
                    ) {
                        $disabled = true;
                    }

                    $this->context->smarty->assign(array(
                        'morenew' => $this->morenew,
                        'inputName' => $inputName,
                        'fieldObj' => $field,
                        'productData' => AnProductFieldsProduct::getData($id_product, $field->id),
                        'an_new' => $this->new,
                        'an_disabledfield' => $disabled
                    ));

                    $helper->fields_value[$inputName] = $this->display($this->name, 'product_edit_field.tpl');
                }
            } else {
                $this->fields_form[0]['form']['input'][] = array(
                    'type' => 'free',
                    'label' => $this->l('There are no one field.'),
                    'name' => 'none_fields'
                );
            }

            $html = $helper->generateForm($this->fields_form);
            $replasefrom = array('< form ', ' < /form > ', 'panel');
            $replaseto = array('< div ', ' < /div > ', 'paneldef');
            $replasefrom = $this->trimspasesarray($replasefrom);
            $replaseto = $this->trimspasesarray($replaseto);

            $return = '';

            if (!$this->new) {
                $return .= $this->display(__FILE__, '/views/templates/admin/product_tab_header.tpl');
            }

            $return .= str_replace($replasefrom, $replaseto, $html);

            if (!$this->new) {
                $return .= $this->display(__FILE__, '/views/templates/admin/product_tab_footer.tpl');
            }

            return $return;
        }

        return $this->l('Please save the product!');
    }

    public function arrayHasSimilar($arr1, $arr2) {
        foreach($arr2 as $val) {
            if (in_array($val, $arr1)) {
                return true;
            }
        }
        return false;
    }

    public function trimspasesarray($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = str_replace(' ', '', $value);
            if ($value == '< form ' || $value == '< div ') {
                $array[$key] = $array[$key] . ' ';
            }
        }
        return $array;
    }
    /**
     * @param $params
     */
    public function hookActionProductUpdate($params)
    {
        if (Tools::getIsset('an_productfields')) {
            $_data = Tools::getValue('an_productfields');
            if (isset($_data['fields'])) {
                $fields = (array)$_data['fields'];
                foreach ($fields as $fieldId => $field) {
                    $data = array(
                        'id_an_productfields' => (int)$fieldId,
                        'id_product' => (int)$_data['id_product'],
                        'is_enabled' => (array_key_exists('is_enabled', $field) && $field['is_enabled'] == 'on' ? 1 : 0),
                        'position' => (int)$field['position'],
                    );

                    AnProductFieldsProduct::setData($data);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addCss($this->_path . 'views/css/front/sweet-alert.css', 'all');
        $this->context->controller->addCss($this->_path . 'views/css/front/front.css', 'all');
        $this->context->controller->addJqueryUI('ui.datepicker');

        if ($this->new) {
            $this->context->controller->registerJavascript('modules-PRODUCTFIELDS', 'modules/'.$this->name.'/views/js/front/front.js', array('position' => 'bottom', 'priority' => 500));
            $this->context->controller->registerJavascript('modules-PRODUCTFIELDS-sa', 'modules/'.$this->name.'/views/js/front/sweet-alert.min.js', array('position' => 'top', 'priority' => 150));
        } else {
            $this->context->controller->addJS($this->_path . 'views/js/front/sweet-alert.min.js');
            $this->context->controller->addJS($this->_path . 'views/js/front/front.js');
        }

        if (($this->new && $this->context->controller instanceof CartController) || (!$this->new  && $this->context->controller instanceof OrderController) || (!$this->new  && $this->context->controller instanceof OrderOpcController)) {
            if ($this->new) {
                $this->context->controller->registerJavascript('modules-PRODUCTFIELDS-order', 'modules/'.$this->name.'/views/js/front/order.js', array('position' => 'top', 'priority' => 150));
            } else {
                $this->context->controller->addJS($this->_path . 'views/js/front/order.js');
            }
        }

        if (($this->new && $this->context->controller instanceof OrderDetailController) ||
            (!$this->new && ($this->context->controller instanceof HistoryController || $this->context->controller instanceof OrderDetailController))) {
            if ($this->new) {
                $this->context->controller->registerJavascript('modules-PRODUCTFIELDS-od', 'modules/'.$this->name.'/views/js/front/order-detail.js', array('position' => 'top', 'priority' => 150));
            } else {
                $this->context->controller->addJS($this->_path . 'views/js/front/order-detail.js');
            }
        }

        $an_date_format = strtolower(Context::getContext()->language->date_format_lite);

        if (
            strpos($an_date_format, 'yy') === false
            && strpos($an_date_format, 'y') !== false
            //strict because the 0 is correct answer
        ) {
            $an_date_format = str_replace('y','yy',$an_date_format);
        }
        if (
            strpos($an_date_format, 'mm') === false
            && strpos($an_date_format, 'm') !== false
        ) {
            $an_date_format = str_replace('m','mm',$an_date_format);
        }
        if (
            strpos($an_date_format, 'dd') === false
            && strpos($an_date_format, 'd') !== false
        ) {
            $an_date_format = str_replace('d','dd',$an_date_format);
        }

        $this->context->smarty->assign(array(
            'an_pf_js_position'=> Configuration::get('an_pf_js_position', null, null, null, '.product-add-to-cart'),
            'an_pf_js_position_type'=> Configuration::get('an_pf_js_position_type', null, null, null, 'before'),
            'an_pf_dynamic_price'=> Configuration::get('an_pf_dynamic_price'),
            'an_pf_text_counter'=> Configuration::get('an_pf_text_counter'),
            'an_date_format' => $an_date_format,
            'an_new' => $this->new
        ));
        return $this->display($this->name, 'order_header.tpl');
    }

    /**
     * @param $params
     * @return string
     */
    public function displayProductExtra($params)
    {
        $isset = $this->new ? isset($params['product']['id_product']) : isset($params['product']->id);
        if ($isset) {
            if (is_array($params['product']) && isset($params['product']['id_product_attribute'])) {
                $an_ipa = $params['product']['id_product_attribute'];
            } elseif (isset($params['product']->id_product_attribute)) {
                $an_ipa = $params['product']->id_product_attribute;
            } else {
                $an_ipa = null;
            }
        }
        if (!Tools::getIsset('ajax') && $isset) {
            $id_product = $this->new ? (int)$params['product']['id_product'] : (int)$params['product']->id;
            $id_category = $this->new ? (int)$params['product']['id_category_default'] : (int)$params['product']->id_category_default;
            $_fields = AnProductFieldsProduct::getAllProductFields($id_product, $id_category);
            if (count($_fields)) {
                $context = Context::getContext();
                $cur_cart = $context->cart;
                $id_address = $cur_cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
                $address = Address::initialize($id_address, true);
                $tax_manager = TaxManagerFactory::getManager($address, Product::getIdTaxRulesGroupByIdProduct((int)$id_product, $context));
                $this->displayProduct = true;
                if (Configuration::get('an_pf_include_tax')) {
                    $this->taxCalculator = $tax_manager->getTaxCalculator();
                } else {
                    $this->taxCalculator = false;
                }
                $currency = new Currency(
                    $this->context->cart->id_currency ? $this->context->cart->id_currency : Configuration::get('PS_CURRENCY_DEFAULT')
                );
                $specific_price = $this->new ? $params['product']['specific_prices'] : $params['product']->specificPrice;

                if (is_array($specific_price)
                    && count($specific_price)
                    && $specific_price['reduction_type'] == 'percentage'
                    && Configuration::get('an_pf_include_specific')
                ) {
                    $this->reduction = $specific_price['reduction'];
                } else {
                    $this->reduction = 0;
                }
                foreach ($_fields as &$field) {
                    if (isset($field->price)) {
                        if (!$this->taxCalculator) {
                            $field->price = Tools::convertPriceFull(
                                $field->price - ($field->price*$this->reduction),
                                null,
                                $currency
                            );
                        } else {
                            $field->price = Tools::convertPriceFull(
                                $this->taxCalculator->addTaxes($field->price - ($field->price*$this->reduction)),
                                null,
                                $currency
                            );
                        }
                    }
                }

                $this->context->smarty->assign(array(
                    'an_attributes' => $_fields,
                    'an_ipa' => $an_ipa,
                    'an_new' => $this->new,
                    'an_pf_header_text' => Configuration::get('an_pf_header_text', $this->context->language->id),
                ));
                return $this->display($this->name, 'product_buttons.tpl') . $this->display($this->name, 'product_buttons_ipa.tpl');
            }
        }
        if ($isset && !is_null($an_ipa)) {
            $this->context->smarty->assign(array(
                'an_ipa' => $an_ipa
            ));
            return $this->display($this->name, 'product_buttons_ipa.tpl');
        }
        return '';
    }

    /**
     * @param $params
     * @return null
     * @throws PrestaShopDatabaseException
     */
    public function hookActionCartSave($params)
    {
        if (!$this->firsttime) {
            return null;
        }
        $this->firsttime = false;
        if (Tools::getIsset('anproductfieldshash') && !Tools::getIsset('delete') && Tools::getValue('anproductfieldshash') !='no') {
            //productfieldsqtyupdate
            $qty = Tools::getValue('qty', 1);
            $direction = Tools::getValue('op', 'up');
            $this->updateQtyByHash(Tools::getValue('anproductfieldshash', false), $qty, $direction);
            return null;
        }

        if (isset($params['cart'])) {
            $cart = $params['cart'];
        } elseif (isset($params['object'])) {
            $cart = $params['object'];
        } elseif (isset(Context::getContext()->cart->id)) {
            $cart = Context::getContext()->cart;
        } else {
            $this->firsttime = true;
            return null;
        }

        $id_product = (int)Tools::getValue('id_product', null);
        if ($id_product == 0) {
            return null;
        }
        if ($this->new) {
            $id_product_attribute = false;
            if ((bool)Tools::getValue('id_product_attribute', false)) {
                $id_product_attribute = Tools::getValue('id_product_attribute', null);
            }
            if ((bool)Tools::getValue('group', false)) {
                $id_product_attribute = (int)Product::getIdProductAttributesByIdAttributes(
                    $id_product,
                    Tools::getValue('group')
                );
            }
            if (!$id_product_attribute) {
                $product = new Product($id_product);
                if ($product->cache_default_attribute) {
                    $id_product_attribute = $product->cache_default_attribute;
                }
            }
        } else {
            $id_product_attribute = (bool)Tools::getValue('ipa', false) ? Tools::getValue('ipa', null) : Tools::getValue('id_product_attribute', null);
        }

        $qty = max(1, (int)Tools::getValue('qty', 1));

        if (Tools::getIsset('an_productfields') && (!Tools::getIsset('delete') || !(bool)Tools::getValue('delete', false))) {
            $context = Context::getContext();
            $hashData = '';
            $values = array();
            foreach ($_REQUEST as $param => $value) {
                if (substr_count($param, 'an_productfields_') && $value != '') {
                    $id_field = (int)str_replace('an_productfields_', '', $param);
                    $_field = new AnProductFields($id_field, $context->language->id);
                    if ($id_field && $value) {
                        if (is_array($value)) {
                            if (!$value[0] || $value[0] == 'null') {
                                continue;
                            }
                            $value = implode('; ', $value);
                        }

                        if ($_field->type == 'date') {
                            $date = DateTime::createFromFormat($context->language->date_format_lite, $value);
                            $value = $date->getTimestamp();
                        }
                        $hashData .= $id_field . '_' . $cart->id . '_' . $id_product
                            . '_' . $id_product_attribute . '_' . pSQL($value) . '_' . (float)$_field->price;

                        $values[] = array(
                            'id_an_productfields' => (int)$id_field,
                            'id_cart' => (int)$cart->id,
                            'id_product' => (int)$id_product,
                            'id_product_attribute' => (int)$id_product_attribute,
                            'value' => pSQL($value),
                            'field_name' => pSQL($_field->name),
                            'field_type' => pSQL($_field->type),
                            'price' => (float)$_field->price,
                        );
                    }
                }
            }

            $values_hash = md5($hashData);
            if ($hashData == '' || $this->updateQtyByHash($values_hash, $qty, 'up')) {
                return;
            }
            foreach ($values as $data) {
                $data['values_hash'] = pSQL($values_hash);
                Db::getInstance()->insert('an_productfields_cart', $data, true, false, Db::REPLACE);
            }
            $cart_values = array(
                'values_hash' => pSQL($values_hash),
                'qty' => (int)$qty
            );

            Db::getInstance()->insert('an_productfields_cart_values', $cart_values, true, false, Db::REPLACE);
        }
    }

    /**
     * @param $params
     * @return string
     */
    public function hookSendMailAlterTemplateVars($params)
    {
        if (Configuration::get('an_pf_separate')) {
            $tpl_name = (string) $params['template'];
            $tpl_name_exploded = explode('.', $tpl_name);
            if (is_array($tpl_name_exploded)) {
                $tpl_name = (string) $tpl_name_exploded[0];
            }

            if ('order_conf' == $tpl_name) {
                $params['template_vars']['{discounts}'] .= $this->displayOrderDetail($params, true);
            } elseif ('new_order' == $tpl_name) {
                $params['template_vars']['{items}'] .= $this->displayOrderDetail($params, true);
            }
        }
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayPDFInvoice($params)
    {
        if (Configuration::get('an_pf_separate')) {
            $params['order'] = new Order($params['object']->id_order);
            $id_cart = $params['order']->id_cart;
            $fields = AnProductFields::getCartProductFieldsWithQty($id_cart);
            if (count($fields)) {
                foreach ($fields as &$fieldgroup) {
                    foreach ($fieldgroup['fields'] as &$field) {
                        $val = '';
                        foreach ($this->getKeyPriceFromString($field->value) as $key => $value) {
                            $val .= $key . ';';
                        }
                        $field->value = trim($val, ';');
                    }
                }
                $this->context->smarty->assign(array(
                    'product_fields' => $fields,
                ));
                $html = $this->display(
                    __file__,
                    'show_selected_fields_pdf.tpl'
                );
                $html = html_entity_decode($html, ENT_QUOTES, 'utf-8');
                $html = iconv("UTF-8", "windows-1252", $html);
                return $html;
            }

            return $this->displayOrderDetail($params);
        }
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayCartExtraProductActions($params)
    {
        $ret = '';
        if (array_key_exists('hash', $params['product'])) {
            $this->context->smarty->assign('an_product_hash', $params['product']['hash']);
            $ret .= $this->display(__file__, 'cart_hidden_fields.tpl');
        }
        return $ret;
    }

    /**
     * @param $id_cart
     * @param $id_product
     * @param $id_product_attribute
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public static function getRawCartItemData($id_cart, $id_product, $id_product_attribute)
    {
        $sql = '
			SELECT * FROM `' . _DB_PREFIX_ . 'an_productfields_cart` cp
			INNER JOIN `' . _DB_PREFIX_ . 'an_productfields_cart_values` cpv ON (cp.`values_hash` = cpv.`values_hash`)
			WHERE cp.`id_product` = ' . (int)$id_product . '
			AND cp.`id_product_attribute` = ' . (int)$id_product_attribute . '
			AND cp.`id_cart` = ' . (int)$id_cart . '
			ORDER BY cp.`values_hash`';

        $rows = Db::getInstance()->executeS($sql);
        return $rows;
    }

    /**
     * @param $id_cart
     * @param $id_product
     * @param $id_product_attribute
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public static function getCartItemData($id_cart, $id_product, $id_product_attribute, $view_type = false)
    {
        $result = array();
        $sql = '
			SELECT * FROM `' . _DB_PREFIX_ . 'an_productfields_cart` cp
			INNER JOIN `' . _DB_PREFIX_ . 'an_productfields_cart_values` cpv ON (cp.`values_hash` = cpv.`values_hash`)
			WHERE cp.`id_product` = ' . (int)$id_product . '
			AND cp.`id_product_attribute` = ' . (int)$id_product_attribute . '
			AND cp.`id_cart` = ' . (int)$id_cart . '
			ORDER BY cp.`values_hash`';

        $rows = Db::getInstance()->executeS($sql);
        if (count($rows)) {
            $products = array();
            foreach ($rows as $row) {
                $products[$row['values_hash']][] = $row;
            }

            foreach ($products as $index => $product) {
                foreach ($product as $field) {
                    if ($field['field_name'] == null) {
                        continue;
                    }
                    $br_delimiter = '+_-br-_+';
                    $br_real = str_replace(' ', '', ' < br/ > ');
                    $value = str_replace($br_real, $br_delimiter, $field['value']);
                    $value = htmlspecialchars($value);
                    $value = str_replace($br_delimiter, $br_real, $value);

                    $result[$index]['lines'][] = array(
                        'label' => htmlspecialchars(rtrim($field['field_name'], ':')),
                        'value' => $value,
                    );

                    $result[$index]['qty'] = $field['qty'];
                    $result[$index]['hash'] = $field['values_hash'];

                    $result[$index]['fieldvalues'][$field['field_name']]['value'] = $field['value'];
                    $result[$index]['fieldvalues'][$field['field_name']]['price'] = $field['price'];
                    $result[$index]['fieldvalues'][$field['field_name']]['field_type'] = $field['field_type'];
                }
            }
        }
        return $result;
    }

    public function deleteByHash($hash)
    {
        $sql = '
			SELECT * FROM `' . _DB_PREFIX_ . 'an_productfields_cart_values` WHERE `values_hash` = \'' . pSQL($hash). '\'';
        $row = Db::getInstance()->getRow($sql);

        Db::getInstance()->Execute('
				DELETE FROM `' . _DB_PREFIX_ . 'an_productfields_cart`
				WHERE `values_hash` = \'' . pSQL($hash) . '\'
			');

        Db::getInstance()->Execute('
				DELETE FROM `' . _DB_PREFIX_ . 'an_productfields_cart_values`
				WHERE `values_hash` = \'' . pSQL($hash) . '\'
			');

        if(!array_key_exists('qty', $row) || $row['qty'] == null) {
            return 0;
        }
        return $row['qty'];
    }

    public function updateQtyByHash($hash, $qty, $direction)
    {
        if (!$hash) {
            return false;
        }
        $db = Db::getInstance();
        $sql = '
			SELECT * FROM `' . _DB_PREFIX_ . 'an_productfields_cart_values` WHERE `values_hash` = \'' . pSQL($hash). '\'';
        $row = $db->getRow($sql);
        if (!$row) {
            return false;
        }

        if ($direction == 'up') {
            $row['qty'] += $qty;
        } else {
            $row['qty'] -= $qty;
        }

        if ($db->update('an_productfields_cart_values', array('qty'=>(int)$row['qty']), 'values_hash = \'' . pSQL($hash) . '\'')) {
            return true;
        }

        return false;
    }

    /**
     * @param $params
     * @return string
     */
    public function displayOrderDetail($params, $email = false)
    {
        $id_cart = $email ? $params['cart']->id : $params['order']->id_cart;
        $fields = AnProductFields::getCartProductFieldsWithQty($id_cart);
        if (count($fields)) {
            foreach ($fields as &$fieldgroup) {
                foreach ($fieldgroup['fields'] as &$field) {
                    $val = '';
                    foreach ($this->getKeyPriceFromString($field->value) as $key => $value) {
                        $val .= $key . $value . ';';
                    }
                    $field->value = trim($val, ';');
                }
            }
            $this->context->smarty->assign(array(
                'product_fields' => $fields,
            ));
            return $this->display(
                __file__,
                $email ? 'show_selected_fields_email.tpl' : 'show_selected_fields.tpl'
            );
        }
        return '';
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayAdminOrderContentOrder($params)
    {
        return $this->displayOrderDetail($params);
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayOrderDetail($params)
    {
        if (!$this->new) {
            return $this->displayOrderDetail($params);
        }
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayAdminOrderTabOrder($params)
    {
        $fields = AnProductFields::getCartProductFields($params['order']->id_cart);
        if (count($fields)) {
            return $this->display(__file__, 'order_tab.tpl');
        }
        return '';
    }

    public function getKeyPriceFromString($valstring, $priceview = true)
    {
        $keyprice = array();
        foreach (explode(';', $valstring) as $value) {
            $key = $this->cleanFromPrice($value);
            $price = $this->getPriceFromValue($value, $priceview);
            $keyprice[$key] = $price;
        }
        return $keyprice;
    }

    public function getKeyPriceBothViewsFromString($valstring, $taxCalculator = false, $reduction = 0)
    {
        $keyprice = array();
        foreach (explode(';', $valstring) as $value) {
            $key = str_replace(array('-', ':', ';'), '', $this->cleanFromPrice($value));
            $price = $this->getPriceFromValue($value, false);
            $pricestring = $this->getPriceFromValue($value, true, $taxCalculator, $reduction);
            $keyprice[$key]['num'] = $price;
            $keyprice[$key]['string'] = str_replace(array('-', ':', ';'), '', $pricestring);
        }
        return $keyprice;
    }

    public function cleanFromPrice($valstring)
    {
        $right = strstr($valstring, '$');
        return str_replace($right, '', $valstring);
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayProductButtons($params)
    {
        return $this->displayProductExtra($params);
    }

    /**
     * @param $params
     * @return string
     */
    public function hookDisplayProductAdditionalInfo($params)
    {
        return $this->displayProductExtra($params);
    }

    /**
     * @param $string
     * @return bool
     */
    public function customValidatorValidate($string)
    {
        $string = htmlspecialchars($string);
        $customvalarray = str_split(htmlspecialchars(Configuration::get('an_pf_customvalidator')));
        foreach (str_split($string) as $val) {
            if (!in_array($val, $customvalarray)) {
                return false;
            }
        }
        return true;
    }

    public function getPriceFromValue($valstring, $priceview = true, $taxCalculator = false, $reduction = 0)
    {
        $right = strstr($valstring, '$');
        if (!$right && $priceview) {
            return '';
        } elseif (!$right && !$priceview) {
            return 0;
        }

        $currency = new Currency(
            $this->context->cart->id_currency ? $this->context->cart->id_currency : Configuration::get('PS_CURRENCY_DEFAULT')
        );

        if ($this->displayProduct && Configuration::get('an_pf_include_tax')) {
            $taxCalculator = $this->taxCalculator;
            $reduction = $this->reduction;
        }
        if (!Configuration::get('an_pf_include_specific')) {
            $reduction = 0;
        }

        $price = trim($right, '$');
        $ret = $priceview ? ' (+' : '';
        if (!$taxCalculator || !Configuration::get('an_pf_include_tax')) {
            if ($priceview) {
                $ret .= Tools::displayPrice(
                    Tools::convertPriceFull($price - ($price*$reduction), null, $currency)
                );
            } else {
                $ret .= Tools::convertPriceFull($price - ($price*$reduction), null, $currency);
            }
        } else {
            if ($priceview) {
                $ret .= Tools::displayPrice(
                    Tools::convertPriceFull($taxCalculator->addTaxes($price - ($price*$reduction)), null, $currency)
                );
            } else {
                $ret .= Tools::convertPriceFull($taxCalculator->addTaxes($price - ($price*$reduction)), null, $currency);
            }
        }
        $ret .= $priceview ? ')' : '';

        return $ret;
    }

    public function translateOpc()
    {
        return array(
            'the' => $this->l('The'),
            'fieldvalueisrequiredtobe' => $this->l('field value is required to be'),
            'field' => $this->l('Field'),
            'isrequired' => $this->l('is required!'),
            'error' => $this->l('Error'),
            'customvalidatorerror' => $this->l('field value is incorrect'),
        );
    }

    public function translateValidator()
    {
        return array(
            'Alphanumeric' => $this->l('Alphanumeric'),
            'Numeric' => $this->l('Numeric'),
            'Alphabetic' => $this->l('Alphabetic'),
            'URL' => $this->l('URL'),
            'Email' => $this->l('Email'),
            'None' => $this->l('None'),
            'Custom' => $this->l('Custom'),
        );
    }
}
