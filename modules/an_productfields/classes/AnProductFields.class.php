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
 * Class AnProductFields
 */

class AnProductFields extends ObjectModel
{
    const FILES_DIR = 'files';

    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $id_an_productfields;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $code;
    /**
     * @var string
     */
    public $type = 'text';
    /**
     * @var int
     */
    public $is_enabled = 1;
    /**
     * @var int
     */
    public $apply_for_all_products = 0;
    /**
     * @var int
     */
    public $sort_order = 0;
    /**
     * @var int
     */
    public $required = 0;
    /**
     * @var string
     */
    public $validation;
    /**
     * @var string
     */
    public $values;
    /**
     * @var int
     */
    public $max_text_length;
    /**
     * @var string
     */
    public $date_add;
    /**
     * @var string
     */
    public $date_upd;
    /**
     * @var string
     */
    public $groups;
    /**
     * @var string
     */
    public $categories;
    /**
     * @var string
     */
    public $placeholder;

    public $price = 0;

    /**
     * @var array
     */
    protected static $_types = array(
        'Text'=>'text',
        'Textarea'=>'textarea',
        'Date'=>'date',
        'Radiobutton'=>'radio',
        'Multiselect'=>'multiselect',
        'Dropdown'=>'dropdown',
        'Checkbox'=>'checkbox',
        //'image'
    );

    /**
     * @var array
     */
    protected static $_fields_relations = array(
        'placeholder',
        'values',
        'validation',
        'max_text_length'
    );

    /**
     * @var array
     */
    protected static $_type_fields_hider = array(
        'text' => array('validation', 'max_text_length', 'placeholder'),
        'textarea' => array('validation', 'max_text_length'),
        'radio' => array('values'),
        'multiselect' => array('values'),
        'dropdown' => array('values'),
        'image' => array(),
        'checkbox' => array('values')
    );

    /**
     * @var array
     */
    protected static $_validations = array(
        'isCarrierName' => 'Alphanumeric',
        'isFloat' => 'Numeric',
        'isName' => 'Alphabetic',
        'isUrl' => 'URL',
        'isEmail' => 'Email',
    );

    /**
     * @var array
     */
    protected static $_allowedImagesExt = array(
        'jpg',
        'jpeg',
        'png',
        'gif'
    );

    /**
     * @var array
     */
    public static $definition = array(
        'table' => "an_productfields",
        'primary' => 'id_an_productfields',
        'multilang' => true,
        'fields' => array(
            'code' => array('type' => self::TYPE_STRING, 'validate' => 'isTableOrIdentifier', 'required' => true),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isTableOrIdentifier', 'required' => true),
            'is_enabled' => array('type' => self::TYPE_INT),
            'apply_for_all_products' => array('type' => self::TYPE_INT),
            'sort_order' => array('type' => self::TYPE_INT),
            'placeholder' => array('type' => self::TYPE_STRING),
            'required' => array('type' => self::TYPE_INT),
            'validation' => array('type' => self::TYPE_STRING),
            //'values' => array('type' => self::TYPE_HTML),
            'groups' => array('type' => self::TYPE_HTML),
            'categories' => array('type' => self::TYPE_HTML),
            'max_text_length' => array('type' => self::TYPE_INT),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
            'price' => array('type' => self::TYPE_FLOAT),
            'name' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isString',
                'size' => 3999999999999,
                'required' => true
            ),
            'values' => array(
                'type' => self::TYPE_HTML,
                'lang' => true)
        )
    );

    /**
     * AnProductFields constructor.
     * @param null $id
     * @param null $id_lang
     */
    public function __construct($id = null, $id_lang = null)
    {
        Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
        parent::__construct($id, $id_lang, null);
    }

    public function __toString()
    {
        return (string)$this->id_an_productfields;
    }

    /**
     * @param $id_cart
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public static function getCartProductFields($id_cart)
    {
        $_cart = Db::getInstance()->ExecuteS('
			SELECT * FROM `' . _DB_PREFIX_ . 'an_productfields_cart`
			WHERE `id_cart` = ' . (int)$id_cart . '
			ORDER BY `id_product`, `id_product_attribute`
		');

        $_fields = array();
        foreach ($_cart as $field) {
            $key = $field['id_product'] . '_' . $field['id_product_attribute'];
            $_fields[$key]['product'] = Product::getProductName($field['id_product'], $field['id_product_attribute']);
            $_field = new AnProductFields($field['id_an_productfields'], Context::getContext()->language->id);
            $_field->value = $field['value'];
            $_fields[$key]['fields'][] = $_field;
        }

        return $_fields;
    }

    /**
     * @param $id_cart
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public static function getCartProductFieldsWithQty($id_cart)
    {
        $_cart = Db::getInstance()->ExecuteS('
			SELECT cp.*, cpv.*, p.reference FROM `' . _DB_PREFIX_ . 'an_productfields_cart` cp
			INNER JOIN `' . _DB_PREFIX_ . 'an_productfields_cart_values` cpv ON (cp.`values_hash` = cpv.`values_hash`)
			INNER JOIN `' . _DB_PREFIX_ . 'product` p ON (cp.`id_product` = p.`id_product`)
			WHERE cp.`id_cart` = ' . (int)$id_cart . '
			ORDER BY cp.`values_hash`, cp.`id_product`, cp.`id_product_attribute`
		');

        $_fields = array();

        foreach ($_cart as $field) {
            $key = $field['values_hash'];
            $_fields[$key]['product'] = Product::getProductName($field['id_product'], $field['id_product_attribute']);
            $_field = new AnProductFields($field['id_an_productfields'], Context::getContext()->language->id);
            $_field->value = $field['value'];
            $_fields[$key]['fields'][] = $_field;
            $_fields[$key]['qty'] = $field['qty'];
            $_fields[$key]['reference'] = $field['reference'];
            $_fields[$key]['id_cart'] = $field['id_cart'];
            $_fields[$key]['id_product_attribute'] = $field['id_product_attribute'];
            $_fields[$key]['id_product'] = $field['id_product'];
        }

        return $_fields;
    }

    /**
     * @param $id_cart
     * @param $id_product
     * @param $id_product_attribute
     * @return int
     */
    public static function hasItemInCart($id_cart, $id_product, $id_product_attribute)
    {
        return (int)Db::getInstance()->getValue('
			SELECT COUNT(*) FROM `' . _DB_PREFIX_ . 'an_productfields_cart`
			WHERE `id_cart` = ' . (int)$id_cart . '
			AND `id_product` = ' . (int)$id_product . '
			AND `id_product_attribute` = ' . (int)$id_product_attribute . '
		');
    }

    /**
     * @return Module
     */
    public static function getModule()
    {
        return Module::getInstanceByName('an_productfields');
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return self::$_types;
    }

    /**
     * @return array
     */
    public static function getValidations()
    {
        return self::$_validations;
    }

    /**
     * @return array
     */
    public static function getFieldsRelations()
    {
        return self::$_fields_relations;
    }

    /**
     * @return array
     */
    public static function getTypeFieldsHider()
    {
        return self::$_type_fields_hider;
    }

    /**
     * @return bool
     */
    public function toggleStatus()
    {
        if ($this->is_enabled) {
            $this->is_enabled = 0;
        } else {
            $this->is_enabled = 1;
        }

        return $this->save();
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return explode(';', $this->groups);
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return explode(';', $this->categories);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return explode(';', $this->values);
    }
}
