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
 * Class AnProductFieldsProduct
 */
class AnProductFieldsProduct extends ObjectModel
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $id_an_productfields;
    /**
     * @var int
     */
    public $id_product;
    /**
     * @var int
     */
    public $position;
    /**
     * @var int
     */
    public $is_enabled = 1;

    /**
     * @var array
     */
    public static $definition = array(
        'table' => "an_productfields_product",
        'primary' => 'id_an_productfields',
        'multilang' => false,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT),
            'position' => array('type' => self::TYPE_INT),
            'is_enabled' => array('type' => self::TYPE_INT),
        )
    );

    /**
     * @param $id_product
     * @param null $id_an_productfield
     * @return mixed
     */
    public static function getData($id_product, $id_an_productfield = null)
    {
        $data = new Collection('AnProductFieldsProduct');
        $data->where('id_product', '=', (int)$id_product);
        if (!is_null($id_an_productfield)) {
            $data->where('id_an_productfields', '=', (int)$id_an_productfield);
            return $data->getFirst();
        }
        return $data->orderBy('position');
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function setData($data)
    {
        return Db::getInstance()->insert('an_productfields_product', $data, true, false, Db::REPLACE);
    }

    /**
     * @param $id_product
     * @return array
     */
    public static function getAllProductFields($id_product)
    {
        $context = Context::getContext();
        $fields = AnProductFieldsProduct::getData($id_product)->where('is_enabled', '=', 1);
        $directFields = new Collection('AnProductFields', $context->language->id);
        $directFields->where('is_enabled', '=', 1)
            ->where('apply_for_all_products', '=', 1)
            ->orderBy('sort_order');

        $_fields = array();
        foreach ($fields as $field) {
            $_field = new AnProductFields($field->id_an_productfields, $context->language->id);
            if ($_field->is_enabled && in_array($context->customer->id_default_group, $_field->getGroups())) {
                $_fields[$_field->code] = $_field;
            }
        }

        foreach ($directFields as $_field) {
            if ($_field->is_enabled && in_array($context->customer->id_default_group, $_field->getGroups())) {
                $_fields[$_field->code] = $_field;
            }
        }



        $product_categories = Product::getProductCategories($id_product);
        $categoriesFields = new Collection('AnProductFields', $context->language->id);
        $categoriesFields->where('is_enabled', '=', 1)
            ->where('categories', '!=', '')
            ->orderBy('sort_order');

        $module = Module::getInstanceByName('an_productfields');
        foreach ($categoriesFields as $field) {
            $_field = new AnProductFields($field->id_an_productfields, $context->language->id);
            if ($_field->is_enabled
                && in_array($context->customer->id_default_group, $_field->getGroups())
                && $module->arrayHasSimilar($product_categories, $_field->getCategories())
            ) {
                $_fields[$_field->code] = $_field;
            }
        }
        return array_unique($_fields);
    }
}
