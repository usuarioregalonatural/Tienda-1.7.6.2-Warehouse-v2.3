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

/**
 * Class an_productfieldsopcModuleFrontController
 */

class an_productfieldsopcModuleFrontController extends ModuleFrontController
{
    /**
     * @var bool
     */
    public $ssl = true;

    /**
     * Init content
     */
    public function initContent()
    {
        $result = array();
        if (Tools::isSubmit('action')) {
            $actionName = Tools::getValue('action', '') . 'Action';
            if (method_exists($this, $actionName)) {
                $result = $this->$actionName();
            }
        }

        die(Tools::jsonEncode($result));
    }

    /**
     * Remove action
     */
    public function removeByHashAction()
    {
        $hash = Tools::getValue('hash');
        $sql = array();
        $sql[] = 'DELETE FROM `' . _DB_PREFIX_ . 'an_productfields_cart`
					WHERE `values_hash` = "' . pSQL($hash) . '"';

        $sql[] = 'DELETE FROM `' . _DB_PREFIX_ . 'an_productfields_cart_values`
					WHERE `values_hash` = "' . pSQL($hash) . '"';

        foreach ($sql as $query) {
            Db::getInstance()->execute($query);
        }
    }

    /**
     * Get Order Details
     */
    public function getOrderDetailsAction()
    {
        $id_order = (int)Tools::getValue('id_order');
        if ($id_order) {
            $params = array(
                'order' => new Order($id_order),
            );
            return array('html' => $this->module->displayOrderDetail($params));
        }
        return array();
    }

    public function updateQtyByHashAction()
    {
        $direction = pSQL(Tools::getValue('direction'));
        $hash = pSQL(Tools::getValue('hash'));

        if ($direction && $hash && $hash != 'no') {
            $hash = Tools::getValue('hash');
            $this->module->updateQtyByHash($hash, 1, $direction);
            return true;
        }
        return false;
    }

    public function validateProductfieldsAction($die = true)
    {
        $module = Module::getInstanceByName('an_productfields');
        $id_product = (int)Tools::getValue('id_product');
        $errors = array();

        $validator = new Validate;
        $_fields = AnProductFieldsProduct::getAllProductFields($id_product);

        $trans = $module->translateOpc();

        foreach ($_fields as $_field) {
            $field_name = 'an_productfields_' . $_field->id;
            if ($_field->type == 'text' || $_field->type == 'textarea') {
                $field_value = urldecode(Tools::getValue($field_name));
            } else {
                $field_value = Tools::getValue($field_name);
            }
            if ($field_value == null && array_key_exists($field_name, $_POST)) {
                $field_value = $_POST[$field_name];
            }
            if ($field_value && ($_field->type == 'text' || $_field->type == 'textarea')) {
                $validation = $_field->validation;
                if (array_key_exists($validation, AnProductFields::getValidations())) {
                    $validations = AnProductFields::getValidations();
                    if (!$validator->$validation($field_value)) {
                        $errors['errors'][]= $trans['the'] . ' ' . $_field->name
                            . ' ' . $trans['fieldvalueisrequiredtobe']
                            . ' ' . $validations[$validation];
                    }
                } elseif ($validation == 'custom') {
                    if (!Module::getInstanceByName('an_productfields')->customValidatorValidate($field_value)) {
                        $errors['errors'][]= $trans['the'] . ' ' . $_field->name
                            . ' ' . $trans['customvalidatorerror'];
                    }
                }
            } elseif ($_field->required && (!$field_value  || ($_field->type == 'multiselect' && array_shift($field_value) == 'null'))) {
                $errors['errors'][] = $trans['field'] . ' ' . $_field->name . ' ' . $trans['isrequired'];
            }
        }

        if (count($errors)) {
            if ($die) {
                $errors['errors'] = implode('
                ', $errors['errors']);
            }
            $errors['an_error']=true;
            $errors['an_error_text'] = $trans['error'];
        } else {
            $errors['an_error']=false;
        }
        if ($die) {
            die(Tools::jsonEncode($errors));
        } else {
            return $errors;
        }
    }

    public function calculateFullpriceAction($die = true)
    {
        $id_product= Tools::getValue('id_product');
        $fieldsPrice = Tools::getValue('fieldsprice');
        $ipa =  null;
        if (Tools::getIsset('id_product_attribute') && Tools::getValue('id_product_attribute') != '') {
            $ipa =  Tools::getValue('id_product_attribute');
        }
        $qty =  Tools::getValue('qty', 1);

        $usetax = (Product::getTaxCalculationMethod((int)$this->context->customer->id) != PS_TAX_EXC);

        $productPrice = round(Product::getPriceStatic((int)$id_product, $usetax, $ipa, 6, null, false, true, $qty), 2, PHP_ROUND_HALF_UP);
        $productPriceNonReduction = round(Product::getPriceStatic((int)$id_product, $usetax, $ipa, 6, null, false, false, $qty), 2, PHP_ROUND_HALF_UP);
        $reduction = $productPrice / $productPriceNonReduction;
        $finalPrice = $fieldsPrice * $reduction + $productPrice;

        die(Tools::displayPrice($finalPrice));
        //die(Tools::displayPrice(Tools::convertPrice($finalPrice)));
        //not need convert price, cuz price static already given from context
    }
}
