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

require_once _PS_MODULE_DIR_ . 'an_productfields/includer.php';

/**
 * Class AdminAnProductFieldsController
 */
class AdminAnProductFieldsController extends ModuleAdminController
{
    /**
     * @var string
     */
    protected $position_identifier = 'id_an_productfields';

    /**
     * AdminAnProductFieldsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'an_productfields';
        $this->identifier = 'id_an_productfields';
        $this->className = 'AnProductFields';
        $this->name = 'AnProductFields';
        $this->lang = true;
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id_an_productfields' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 30),
            //'name' => array('title' => $this->l('Name'), 'width' => 70),
            'code' => array('title' => $this->l('Internal name'), 'width' => 70),
            'price' => array('title' => $this->l('Price'), 'width' => 70, 'type' => 'price'),
            'type' => array('title' => $this->l('Type'), 'width' => 70),
            'sort_order' => array('title' => $this->l('Sort Order'), 'width' => 70),
            'date_add' => array('title' => $this->l('Date Add'), 'width' => 70),
            'date_upd' => array('title' => $this->l('Date Last Update'), 'width' => 50),
            'is_enabled' => array(
                'title' => $this->l('Enabled'),
                'width' => 25,
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
            ));

        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_ALL) {
            $this->_where .= ' AND a.' . pSQL($this->identifier) . ' IN (
                SELECT sa.' . pSQL($this->identifier) . '
                FROM `' . _DB_PREFIX_ . pSQL($this->table) . '_shop` sa
                WHERE sa.id_shop IN (' . pSQL(implode(', ', Shop::
                getContextListShopID())) . ')
            )';
        }

        $this->_orderBy = 'id_an_productfields';
        $this->identifiersDnd = array('id_an_productfields' => 'id_sslide_to_move');
    }

    /**
     * @return string|void
     */
    public function renderForm()
    {
        $this->display = 'edit';
        $this->initToolbar();
        if (!$obj = $this->loadObject(true)) {
            return;
        }

        $types = array();
        foreach ($obj->getTypes() as $key => $type) {
            $types[] = array(
                'id' => 'active_' . $type,
                'value' => $type,
                'class' => 'attribute_type',
                'label' => $this->l($key),
            );
        }

        $valnames = $this->module->translateValidator();

        $validation = array(array(
            'id' => 'active_none',
            'value' => '',
            'label' => $valnames['None']
        ));

        foreach ($obj->getValidations() as $method => $type) {
            $validation[] = array(
                'id' => 'active_' . $method,
                'value' => $method,
                'label' => Tools::ucfirst($valnames[$type])
            );
        }

        if (Configuration::get('an_pf_customvalidator')) {
            $validation[] = array(
                'id' => 'active_custom',
                'value' => 'custom',
                'label' => $valnames['Custom']
            );
        }

        $groups = Group::getGroups(Context::getContext()->language->id);

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array('title' => $this->l('Product Attribute'), 'image' =>
                '../img/admin/add.gif'),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'id' => 'name',
                    'required' => true,
                    'size' => 50,
                    'maxlength' => 50,
                    'lang' => true,
                    'desc' => 'For proper displaying of fields do not use the following symbols in the name: “;”, “:”, “,”, “-”',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Internal name'),
                    'name' => 'code',
                    'id' => 'code',
                    'required' => true,
                    'size' => 50,
                    'maxlength' => 50,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Price'),
                    'name' => 'price',
                    'id' => 'price',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Status'),
                    'name' => 'is_enabled',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'active_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'active_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Sort Order'),
                    'name' => 'sort_order',
                    'id' => 'sort_order',
                    'required' => false,
                    'size' => 50,
                    'maxlength' => 50,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Required'),
                    'name' => 'required',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'required_on',
                        'value' => 1,
                        'label' => $this->l('Yes')), array(
                        'id' => 'required_off',
                        'value' => 0,
                        'label' => $this->l('No'))),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Type'),
                    'name' => 'type',
                    'required' => false,
                    'class' => 't',
                    'values' => $types,
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Validation'),
                    'name' => 'validation',
                    'required' => false,
                    'class' => 't',
                    'values' => $validation,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Values'),
                    'name' => 'values',
                    'id' => 'values',
                    'required' => true,
                    'size' => 50,
                    'desc' => array(
                        $this->l('Semicolon as delimiter. For example: value1;value2;value3'),
                        $this->l('If you need to set a separate price for some field values, enter the value in the format value$price, for example, Extra warranty$120. Other values has the same cost that is set in the field "Price"'),
                        $this->l('More info about interaction between field price and custom value price is available in the module documentation'),
                    ),
                    'lang' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Placeholder'),
                    'name' => 'placeholder',
                    'id' => 'placeholder',
                    'required' => false,
                    'size' => 50,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Max Text Length'),
                    'name' => 'max_text_length',
                    'id' => 'max_text_length',
                    'required' => false,
                    'size' => 50,
                    'maxlength' => 50,
                    'desc' => $this->l('Leave the field empty if text length is required to be unlimited'),
                ),
                array(
                    'type' => 'group',
                    'label' => $this->l('Customer Groups'),
                    'name' => 'type',
                    'required' => true,
                    'class' => 't',
                    'values' => $groups,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Apply this field for all products'),
                    'name' => 'apply_for_all_products',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'apply_active_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'apply_active_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type'  => 'categories',
                    'label' => $this->l('Apply to all products in selected categories'),
                    'name'  => 'id_categories',
                    'tree'  => array(
                        'id' => 'id_root_category',
                        'use_checkbox' => true,
                        'selected_categories' => $obj->getCategories()
                    )
                ),
            ),
            'submit' => array('title' => $this->l('Save')));

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }

        foreach ($groups as $group) {
            $this->fields_value['groupBox_' . $group['id_group']] = in_array($group['id_group'], $obj->getGroups());
        }

        $this->context->smarty->assign(array(
            'an_getFieldsRelations'=>Tools::jsonEncode($obj->getFieldsRelations()),
            'an_getTypeFieldsHider'=>Tools::jsonEncode($obj->getTypeFieldsHider()),
        ));

        $display = $this->context->smarty->fetch(_PS_MODULE_DIR_ . '/' . $this->module->name . '/views/templates/admin/script.tpl');
        return parent::renderForm() . $display;
    }

    /**
     * @return false|ObjectModel|void
     */
    public function processSave()
    {
        $languages = Language::getLanguages();
        if (Tools::getIsset('groupBox')) {
            if (!$obj = $this->loadObject(true)) {
                return;
            }

            $obj->groups = implode(';', Tools::getValue('groupBox'));
            $_POST['groups'] = $obj->groups;
            $obj->categories = Tools::getValue('id_categories') ? implode(';', Tools::getValue('id_categories')) : '';
            $_POST['categories'] = $obj->categories;
        }

        if (Tools::getIsset('sort_order')) {
            if (!Validate::isFloat(Tools::getValue('sort_order')) && Tools::getValue('sort_order') != '') {
                $this->errors[] = $this->l('The sort order field is required to be numeric.');
            }
        }
        if (Tools::getIsset('price')) {
            if (!Validate::isFloat(Tools::getValue('price')) && Tools::getValue('price') != '') {
                $this->errors[] = $this->l('The price field is required to be numeric.');
            }
        }
        if (!Tools::getIsset('groupBox') || count(Tools::getValue('groupBox')) == 0) {
                $this->errors[] = $this->l('Please select at least one Customer Group.');
        }
        if ((
                Tools::getValue('type') == 'checkbox'
                || Tools::getValue('type') == 'dropdown'
                || Tools::getValue('type') == 'multiselect'
                || Tools::getValue('type') == 'radio'
            )
        ) {
            $emptyval = false;
            foreach ($languages as $language) {
                if (!Tools::getIsset('values_' . $language['id_lang']) || Tools::getValue('values_' . $language['id_lang']) == '') {
                    $emptyval = true;
                }
            }
            if ($emptyval) {
                $this->errors[] = $this->l('Please fill the "Values" field for all languages.');
            }
        }
        $emtyname = false;
        foreach ($languages as $language) {
            if (!Tools::getIsset('name_' . $language['id_lang']) || Tools::getValue('name_' . $language['id_lang']) == '') {
                $emtyname = true;
            }
        }
        if ($emtyname) {
            $this->errors[] = $this->l('Please fill the "Name" field for all languages.');
        }
        if (!empty($this->errors)) {
            // if we have errors, we stay on the form instead of going back to the list
            $this->display = 'edit';
            return false;
        }

        return parent::processSave();
    }

    /**
     * @param bool $class_name
     */
    public function validateRules($class_name = false)
    {
        foreach ($_POST as &$post) {
            if (!is_array($post)) {
                $post = trim($post);
            }
        }

        return parent::validateRules($class_name);
    }

    /**
     * @param int $id_object
     * @return bool|void
     * @throws PrestaShopDatabaseException
     */
    protected function updateAssoShop($id_object)
    {
        if (!Shop::isFeatureActive()) {
            return;
        }

        $assos_data = $this->getSelectedAssoShop($this->table, $id_object);

        $exclude_ids = $assos_data;
        foreach (Db::getInstance()->executeS('SELECT id_shop FROM ' . _DB_PREFIX_ .
            'shop') as $row) {
            if (!$this->context->employee->hasAuthOnShop($row['id_shop'])) {
                $exclude_ids[] = (int)$row['id_shop'];
            }
        }

        Db::getInstance()->delete($this->table . '_shop', '`' . $this->identifier .
            '` = ' . (int)$id_object . ($exclude_ids ? ' AND id_shop NOT IN (' . implode(
                ', ',
                $exclude_ids
            ) . ')' : ''));

        $insert = array();
        foreach ($assos_data as $id_shop) {
            $insert[] = array(
                $this->identifier => (int)$id_object,
                'id_shop' => (int)$id_shop,
            );
        }

        return Db::getInstance()->insert(
            $this->table . '_shop',
            $insert,
            false,
            true,
            Db::INSERT_IGNORE
        );
    }

    /**
     * @param string $table
     * @return array
     */
    protected function getSelectedAssoShop($table)
    {
        if (!Shop::isFeatureActive()) {
            return array();
        }

        $shops = Shop::getShops(true, null, true);
        if (count($shops) == 1 && isset($shops[0])) {
            return array($shops[0], 'shop');
        }

        $assos = array();
        if (Tools::isSubmit('checkBoxShopAsso_' . $table)) {
            foreach (Tools::getValue('checkBoxShopAsso_' . $table) as $id_shop => $value) {
                $assos[] = (int)$id_shop;
            }
        } else {
            if (Shop::getTotalShops(false) == 1) {
                // if we do not have the checkBox multishop, we can have an admin with only one shop and being in multishop
                $assos[] = (int)Shop::getContextShopID();
            }
        }

        return $assos;
    }

    public function renderList()
    {
        if (Tools::isSubmit('submitAdminAnProductFields')) {
            Configuration::updateValue('an_pf_js_position', Tools::getValue('an_pf_js_position'));
            Configuration::updateValue('an_pf_customvalidator', Tools::getValue('an_pf_customvalidator'));
            Configuration::updateValue('an_pf_js_position_type', Tools::getValue('an_pf_js_position_type'));

            Configuration::updateValue('an_pf_separate', (string)Tools::getValue('an_pf_separate'));
            if (Configuration::get('an_pf_modal_type') != (string)Tools::getValue('an_pf_modal_type')) {
                $this->module->new ?
                $this->changeModalType((string)Tools::getValue('an_pf_modal_type', '0')) :
                $this->changeModalTypeOld((string)Tools::getValue('an_pf_modal_type', '0'));
            }
            Configuration::updateValue('an_pf_include_tax', (int)Tools::getValue('an_pf_include_tax'));
            Configuration::updateValue('an_pf_include_specific', (int)Tools::getValue('an_pf_include_specific'));
            Configuration::updateValue('an_pf_override_payment_module', (int)Tools::getValue('an_pf_override_payment_module'));
            Configuration::updateValue('an_pf_dynamic_price', (int)Tools::getValue('an_pf_dynamic_price'));
            Configuration::updateValue('an_pf_text_counter', (int)Tools::getValue('an_pf_text_counter'));

            $languages = Language::getLanguages(false);

            $valuesPfHeader = array();
            foreach ($languages as $lang) {
                $valuesPfHeader[$lang['id_lang']] = Tools::getValue('an_pf_header_text_' . $lang['id_lang']);
            }

            Configuration::updateValue('an_pf_header_text', $valuesPfHeader);

            if (Tools::getValue('an_pf_soft_reset')) {
                $this->module->uninstall(true);
                $this->module->install(true);
                $this->informations[] = 'Module has been reseted';
            }
            if (Tools::getValue('an_pf_clear_prestashop_cache')) {
                $this->module->clearPrestashopCache();
                $this->informations[] = 'Prestashop cache cleaned';
            }
        }

        $this->context->controller->addCSS(_PS_MODULE_DIR_ . '/' . $this->module->name . '/views/css/back/back.css');
        $this->context->smarty->assign(array(
            'an_pf_feildslist' => parent::renderList(),
            'an_pf_settings' => $this->displayForm(),
        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . '/' . $this->module->name . '/views/templates/admin/fields.tpl');
    }

    public function changeModalType($type)
    {
        if (!file_exists(_PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal-original.tpl')) {
            @copy(
                _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl',
                _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal-original.tpl'
            );
        }
        switch ($type) {
            case 1:
                @unlink(_PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl');
                @copy(
                    _PS_MODULE_DIR_.'/'.$this->module->name.'/views/templates/overwrite/modal-simple.tpl',
                    _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl'
                );
                break;
            case 2:
                @unlink(_PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl');
                @copy(
                    _PS_MODULE_DIR_.'/'.$this->module->name.'/views/templates/overwrite/modal-empty.tpl',
                    _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl'
                );
                break;
            default:
                @unlink(_PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl');
                @copy(
                    _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal-original.tpl',
                    _PS_ALL_THEMES_DIR_.'/classic/modules/ps_shoppingcart/modal.tpl'
                );
                break;
        }
        Configuration::updateValue('an_pf_modal_type', $type);
    }

    public function clearPrestashopCache()
    {
        Tools::clearSmartyCache();
        Tools::clearXMLCache();
        Media::clearCache();
        Tools::generateIndex();
    }

    public function changeModalTypeOld($type)
    {
        if (!file_exists(_PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart-original.tpl')) {
            @copy(
                _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl',
                _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart-original.tpl'
            );
        }
        switch ($type) {
            case 1:
                @unlink(_PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl');
                @copy(
                    _PS_MODULE_DIR_.'/'.$this->module->name.'/views/templates/overwrite/blockcart-simple.tpl',
                    _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl'
                );
                break;
            case 2:
                @unlink(_PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl');
                @copy(
                    _PS_MODULE_DIR_.'/'.$this->module->name.'/views/templates/overwrite/blockcart-empty.tpl',
                    _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl'
                );
                break;
            default:
                @unlink(_PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl');
                @copy(
                    _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart-original.tpl',
                    _PS_ALL_THEMES_DIR_.'/default-bootstrap/modules/blockcart/blockcart.tpl'
                );
                break;
        }
        Configuration::updateValue('an_pf_modal_type', $type);
    }

    public function displayForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $fields_form = array();

        // Init Fields form array
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Expert Settings'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable display in a separate table'),
                    'name' => 'an_pf_separate',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_separate_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_separate_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Apply tax to fields value'),
                    'name' => 'an_pf_include_tax',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_include_tax_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_include_tax_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Apply specific price for this field'),
                    'name' => 'an_pf_include_specific',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_include_specific_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_include_specific_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Productfields header text'),
                    'name' => 'an_pf_header_text',
                    'id' => 'an_pf_header_text',
                    'required' => false,
                    'size' => 128,
                    'maxlength' => 128,
                    'lang' => true,
                    'desc' => 'Leave this field empty if you don’t want the block with productfields to have a header.',
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Product added to cart modal'),
                    'name' => 'an_pf_modal_type',
                    'default_value' => 0,
                    'values' => array(
                        array(
                            'id' => 'original',
                            'value' => 0,
                            'label' => $this->l('Original')),
                        array(
                            'id' => 'simple',
                            'value' => 1,
                            'label' => $this->l('Simple')),
                        array(
                            'id' => 'none',
                            'value' => 2,
                            'label' => $this->l('None')),
                    ),
                    'desc' => 'This option does not work if your theme override\'s "ps_shoppingcart/modal.tpl"',
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Dynamic product price change for storefront'),
                    'name' => 'an_pf_dynamic_price',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_dynamic_price_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_dynamic_price_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display symbol counter for text fields'),
                    'name' => 'an_pf_text_counter',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_text_counter_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_text_counter_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),


                array(
                    'type' => 'text',
                    'label' => $this->l('HTML tag for product fields'),
                    'name' => 'an_pf_js_position',
                    'size' => 20,
                    'desc' => array(
                        'The option is used in case when your theme was changed a lot.  It\'s recommended not to use it without instructions of the developer.'
                    )
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('JS position for product fields'),
                    'name' => 'an_pf_js_position_type',
                    'default_value' => 0,
                    'values' => array(
                        array(
                            'id' => 'before',
                            'value' => 'before',
                            'label' => $this->l('Before')),
                        array(
                            'id' => 'after',
                            'value' => 'after',
                            'label' => $this->l('After')),
                        array(
                            'id' => 'prepend',
                            'value' => 'prepend',
                            'label' => $this->l('Prepend')),
                        array(
                            'id' => 'append',
                            'value' => 'append',
                            'label' => $this->l('Append')),
                    ),
                    'desc' => array(
                        'The option is used in case when your theme was changed a lot.  It\'s recommended not to use it without instructions of the developer.'
                    )
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Custom validator'),
                    'name' => 'an_pf_customvalidator',
                    'desc' => array(
                        'Enter the characters to be successfully validated.'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Override original PaymentModule class'),
                    'desc' => $this->l('Fix display price in customer e-mail\'s'),
                    'name' => 'an_pf_override_payment_module',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_override_payment_module_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_override_payment_module_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Clear Prestashop Cache'),
                    'name' => 'an_pf_clear_prestashop_cache',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_clear_prestashop_cache_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_clear_prestashop_cache_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Soft reset module'),
                    'desc' => $this->l('If a different theme is selected, you must restart the module with the same parameters'),
                    'name' => 'an_pf_soft_reset',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'an_pf_soft_reset_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')), array(
                        'id' => 'an_pf_soft_reset_off',
                        'value' => 0,
                        'label' => $this->l('Disabled'))),
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = 'AdminAnProductFields';
        $helper->token = Tools::getAdminTokenLite('AdminAnProductFields');
        $helper->currentIndex = AdminController::$currentIndex;

        // Language
        $helper->allow_employee_form_lang = $default_lang;
        $helper->default_form_language    = $this->context->language->id;
        $helper->tpl_vars = array(
            'languages'    => $this->context->controller->getLanguages(),
            'id_language'  => $this->context->language->id,
        );

        // Title and toolbar
        $helper->title = 'AdminAnProductFields';
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submitAdminAnProductFields';

        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex,
                ),
        );

        // Load current value
        $helper->fields_value['an_pf_js_position'] = Configuration::get('an_pf_js_position', null, null, null, '.product-add-to-cart');
        $helper->fields_value['an_pf_customvalidator'] = Configuration::get('an_pf_customvalidator');
        $helper->fields_value['an_pf_js_position_type'] = Configuration::get('an_pf_js_position_type', null, null, null, 'before');
        $helper->fields_value['an_pf_separate'] = Configuration::get('an_pf_separate');
        $helper->fields_value['an_pf_modal_type'] = Configuration::get('an_pf_modal_type');
        $helper->fields_value['an_pf_include_tax'] = Configuration::get('an_pf_include_tax');
        $helper->fields_value['an_pf_include_specific'] = Configuration::get('an_pf_include_specific');
        $helper->fields_value['an_pf_override_payment_module'] = Configuration::get('an_pf_override_payment_module');
        $helper->fields_value['an_pf_dynamic_price'] = Configuration::get('an_pf_dynamic_price');
        $helper->fields_value['an_pf_text_counter'] = Configuration::get('an_pf_text_counter');
        $helper->fields_value['an_pf_clear_prestashop_cache'] = 0;
        $helper->fields_value['an_pf_soft_reset'] = 0;
        $languages = Language::getLanguages(false);

        $an_pf_header_text = array();
        foreach ($languages as $lang) {
            $an_pf_header_text[$lang['id_lang']] = Configuration::get('an_pf_header_text', $lang['id_lang']);
        }
        $helper->fields_value['an_pf_header_text'] = $an_pf_header_text;

        return $helper->generateForm($fields_form);
    }
}
