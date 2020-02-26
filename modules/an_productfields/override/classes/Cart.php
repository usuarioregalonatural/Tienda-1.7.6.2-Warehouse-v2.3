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

class Cart extends CartCore
{
    public function getProducts($refresh = false, $id_product = false, $id_country = null, $fullInfos = true)
    {
        $parent = parent::getProducts($refresh, $id_product, $id_country, $fullInfos);

        $ret = array();
        $iteration = 0;
        $module = Module::getInstanceByName('an_productfields');
        $cart_product_context = Context::getContext()->cloneContext();
        $this->productfieldsaddon = 0;
        $this->productfieldsaddon_without_tax = 0;
        foreach ($parent as $product) {
            $product['price_without_specific_price'] = Product::getPriceStatic(
                $product['id_product'],
                !Product::getTaxCalculationMethod(),
                $product['id_product_attribute'],
                6,
                null,
                false,
                false,
                1,
                false,
                null,
                null,
                null,
                $null,
                true,
                true,
                $cart_product_context
            );
            $cartItemData = $module->getCartItemData(
                $this->id,
                $product['id_product'],
                $product['id_product_attribute']
            );

            if (count($cartItemData)) {
                if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_invoice') {
                    $address_id = (int)$this->id_address_invoice;
                } else {
                    $address_id = (int)$product['id_address_delivery'];
                }
                if (!Address::addressExists($address_id)) {
                    $address_id = null;
                }
                $context = Context::getContext()->cloneContext();
                if ($context->shop->id != $product['id_shop']) {
                    $context->shop = new Shop((int)$product['id_shop']);
                }
                $address = Address::initialize($address_id, true);
                if (Configuration::get('an_pf_include_tax')) {
                    $tax_manager = TaxManagerFactory::getManager(
                        $address,
                        Product::getIdTaxRulesGroupByIdProduct(
                            (int)$product['id_product'],
                            $context
                        )
                    );
                    $product_tax_calculator = $tax_manager->getTaxCalculator();
                } else {
                    $product_tax_calculator = null;
                }

                if (Configuration::get('an_pf_include_specific')
                    && array_key_exists("price_without_reduction", $product)
                    && array_key_exists("price_with_reduction", $product)
                    && $product['price_with_reduction'] != 0
                    && $product['price_without_reduction'] != 0
                ) {
                    $reduction = ($product['price_without_reduction']-$product['price_with_reduction'])/$product['price_without_reduction'];
                } else {
                    $reduction = 0;
                }

                $quantity = $product['quantity'];
                foreach ($cartItemData as $hash => $data) {
                    $ret[$iteration] = $product;
                    $ret[$iteration]['cart_quantity'] = $data['qty'];
                    $ret[$iteration]['quantity'] = $data['qty'];
                    $quantity = $quantity - $data['qty'];
                    $ret[$iteration]['hash'] = $hash;
                    $attributesstring = '';
                    foreach ($data['fieldvalues'] as $name => $values) {
                        $price = '';
                        if ($values['price'] > 0) {
                            $currency = new Currency(
                                $this->id_currency ? $this->id_currency : Configuration::get('PS_CURRENCY_DEFAULT')
                            );

                            $this->addFieldsPrices($ret[$iteration], $values['price'], $product_tax_calculator, $reduction);
                            $this->productfieldsaddon_without_tax += $data['qty'] * ($values['price'] - ($values['price']*$reduction));

                            $price = ' (+' ;
                            if ($product_tax_calculator != null) {
                                $price .= Tools::convertPriceFull($product_tax_calculator->addTaxes($values['price'] - ($values['price']*$reduction)), null, $currency);
                                $this->productfieldsaddon += $data['qty'] * $product_tax_calculator->addTaxes($values['price'] - ($values['price']*$reduction));
                            } else {
                                $price .= Tools::convertPriceFull($values['price'] - ($values['price']*$reduction), null, $currency);
                                $this->productfieldsaddon += $data['qty'] * ($values['price'] - ($values['price']*$reduction));
                            }

                            $price .= ' ' .$currency->sign . ')';
                        }
                        $keyprice = $module->getKeyPriceBothViewsFromString($values['value'], $product_tax_calculator, $reduction);
                        $attributesstring .= ' - ' . $name . $price . ': ';
                        foreach ($keyprice as $key => $pricesarray) {
                            if (
                                $values['field_type'] === 'date'
                                && !strpos($key, '-')//these checks are needed for
                                && !strpos($key, '/')// older versions of an_productfields compability
                            ) {//Display date in prestashop current format
                                $endash = html_entity_decode('&#x2013;', ENT_COMPAT, 'UTF-8');
                                $key = str_replace('-', $endash, Tools::displayDate(date("Y-m-d", $key)));
                            }

                            $attributesstring .= $key . $pricesarray['string'] . '; ';
                            $this->addFieldsPrices($ret[$iteration], $pricesarray['num'], $product_tax_calculator, $reduction);
                            if ($product_tax_calculator != null) {
                                $this->productfieldsaddon += $data['qty'] * $product_tax_calculator->addTaxes($pricesarray['num'] - ($pricesarray['num']*$reduction));
                            } else {
                                $this->productfieldsaddon += $data['qty'] * ($pricesarray['num'] - ($pricesarray['num']*$reduction));
                            }
                            $this->productfieldsaddon_without_tax += $data['qty'] * ($pricesarray['num'] - ($pricesarray['num'] * $reduction));
                        }
                    }
                    if (version_compare(_PS_VERSION_, '1.7.4.9', '>')
                        && Tools::strtolower(Dispatcher::getInstance()->getController()) == 'cart'
                    ) {
                        $attributesstring .= ' - productfields_hash: '.$hash;
                    }
                    $attributesstring = rtrim($attributesstring, '; ');
                    if (array_key_exists('attributes', $ret[$iteration])) {
                        $ret[$iteration]['attributes'] .= $attributesstring;
                    } else {
                        $ret[$iteration]['attributes'] = ltrim($attributesstring, ' -');
                    }
                    if (array_key_exists('price_with_reduction_without_tax', $product) && array_key_exists('total', $product)) {
                        $ret[$iteration]['total'] = $ret[$iteration]['price_with_reduction_without_tax'] * $data['qty'];
                    }
                    if (array_key_exists('price_with_reduction', $product) && array_key_exists('total_wt', $product)) {
                        $ret[$iteration]['total_wt'] = $ret[$iteration]['price_with_reduction'] * $data['qty'];
                    }
                    if (array_key_exists('price_without_reduction', $product) && array_key_exists('price_without_specific_price', $product)) {
                        $ret[$iteration]['price_without_specific_price'] = $ret[$iteration]['price_without_reduction'];
                    }

                    $ret[$iteration]['cart_quantity'] = $data['qty'];
                    $ret[$iteration]['quantity'] = $data['qty'];
                    $iteration++;
                }
                if ($quantity > 0) {
                    $ret[$iteration] = $product;
                    $ret[$iteration]['quantity'] = $quantity;
                    $ret[$iteration]['cart_quantity'] = $quantity;
                    $ret[$iteration]['total'] = $product['price'] * $quantity;
                    if (array_key_exists('price_wt', $ret[$iteration])) {
                        $ret[$iteration]['total_wt'] = $ret[$iteration]['price_wt'] * $quantity;
                    }
                    $iteration++;
                }
            } else {
                $ret[$iteration] = $product;
                $iteration++;
            }
        }
        if (
            version_compare(_PS_VERSION_, '1.7.4.9', '>')
            && Tools::getIsset('update')
            && Tools::getIsset('op')
            && Tools::getValue('op', 'up') == 'down'
        ) {
            return $parent;
        }
        return $ret;
    }

    protected function addFieldsPrices(&$product, $fieldPrice, $taxCalculator, $reduction = 0)
    {
        if (!Product::getTaxCalculationMethod()) {
            $product['price_without_specific_price']
                += $taxCalculator != null ? $taxCalculator->addTaxes($fieldPrice) : $fieldPrice;
        } else {
            $product['price_without_specific_price'] += $fieldPrice;
        }
        $product['price'] += $fieldPrice - ($fieldPrice*$reduction);
        if (array_key_exists('price_without_reduction', $product)) {
            $product['price_without_reduction']
                += $taxCalculator != null ? $taxCalculator->addTaxes($fieldPrice) : $fieldPrice;
        }
        if (array_key_exists('price_with_reduction', $product)) {
            $product['price_with_reduction']
                += $taxCalculator != null ? $taxCalculator->addTaxes($fieldPrice - ($fieldPrice*$reduction)) :
                $fieldPrice - ($fieldPrice*$reduction);
        }
        if (array_key_exists('price_wt', $product)) {
            $product['price_wt']
                += $taxCalculator != null ? $taxCalculator->addTaxes($fieldPrice - ($fieldPrice*$reduction)) :
                $fieldPrice - ($fieldPrice*$reduction);
        } else {
            $product['price_wt'] = $taxCalculator != null ? $taxCalculator->addTaxes($product['price']) :
                $product['price'];
        }

        if (array_key_exists('price_with_reduction_without_tax', $product)) {
            $product['price_with_reduction_without_tax'] += $fieldPrice - ($fieldPrice*$reduction);
        }
    }

    public function getSummaryDetails($id_lang = null, $refresh = false)
    {
        if (
            version_compare(_PS_VERSION_, '1.7.0.0', '<')
            && isset($this->productfieldsaddon)
            && !(Context::getContext()->controller instanceof OrderOpcController)
        ) {
            $summary = parent::getSummaryDetails($id_lang, $refresh);
            $summary['total_products_wt']
                = round($summary['total_products_wt'] + $this->productfieldsaddon, 2, PHP_ROUND_HALF_UP);
            $summary['total_products']
                = round($summary['total_products'] + $this->productfieldsaddon_without_tax, 2, PHP_ROUND_HALF_UP);
            $summary['total_price']
                = round($summary['total_price'] + $this->productfieldsaddon, 2, PHP_ROUND_HALF_UP);
            $summary['total_tax']
                = round($summary['total_tax'] + $this->productfieldsaddon - $this->productfieldsaddon_without_tax, 2, PHP_ROUND_HALF_UP);
            $summary['total_price_without_tax']
                = round($summary['total_price_without_tax'] + $this->productfieldsaddon_without_tax, 2, PHP_ROUND_HALF_UP);
            $this->summary_pf_added = true;
            return $summary;
        } else {
            return parent::getSummaryDetails($id_lang, $refresh);
        }
    }

    public function getOrderTotal(
        $with_taxes = true,
        $type = Cart::BOTH,
        $products = null,
        $id_carrier = null,
        $use_cache = true,
        $paymentmodule =  false
    ) {
        $parent = parent::getOrderTotal(
            $with_taxes,
            $type,
            $products,
            $id_carrier,
            $use_cache
        );
        if (
            (
                isset($this->summary_pf_added)
                && $this->summary_pf_added
                && !isset($this->total_firsttime)
            ) || (
                $paymentmodule
                || version_compare(_PS_VERSION_, '1.6.9.9', '>')
                || !(Context::getContext()->controller instanceof OrderController)
                /*|| (!(Context::getContext()->controller instanceof OrderController)
                && !(Context::getContext()->controller instanceof OrderOpcController))*/
            ) && (
                $type == Cart::ONLY_PRODUCTS
                || $type == Cart::BOTH
                || $type == Cart::BOTH_WITHOUT_SHIPPING
                || $type == Cart::ONLY_PRODUCTS_WITHOUT_SHIPPING
                || $type == Cart::ONLY_PHYSICAL_PRODUCTS_WITHOUT_SHIPPING
            )
        ) {
            $discount = 0;
            if (
                $type != Cart::ONLY_PRODUCTS
            ) {

                $sql = '
                SELECT * FROM `' . _DB_PREFIX_ . 'cart_cart_rule` ccr';

                $sql .= '
                LEFT JOIN ' . _DB_PREFIX_ . 'cart_rule cr ON cr.`id_cart_rule` = ccr.`id_cart_rule`';

                $sql .= '
                AND ccr.`id_cart` = ' . (int)$this->id;

                $rows = Db::getInstance()->ExecuteS($sql);

                if (count($rows)) {
                    foreach ($rows as $row) {
                        $discount += $row['reduction_percent'];
                    }
                }
            }

            $reduction = $discount / 100;

            $this->total_firsttime = true;
            if (!isset($this->productfieldsaddon)) {
                $this->getProducts();
            }
            if ($with_taxes) {
                return round($parent + $this->productfieldsaddon - ($this->productfieldsaddon * $reduction), 2, PHP_ROUND_HALF_UP);
            } else {
                return round($parent + $this->productfieldsaddon_without_tax - ($this->productfieldsaddon_without_tax * $reduction), 2, PHP_ROUND_HALF_UP);
            }
        } elseif (
            (
                version_compare(_PS_VERSION_, '1.6.9.9', '>') || !(Context::getContext()->controller instanceof OrderController)
                /*(!(Context::getContext()->controller instanceof OrderController)
                && !(Context::getContext()->controller instanceof OrderOpcController))*/
            )
            && $type == Cart::ONLY_DISCOUNTS
        ) {
            if (!isset($this->productfieldsaddon)) {
                $this->getProducts();
            }
            $discount = 0;

            $sql = '
                SELECT * FROM `' . _DB_PREFIX_ . 'cart_cart_rule` ccr';

            $sql .= '
                LEFT JOIN ' . _DB_PREFIX_ . 'cart_rule cr ON cr.`id_cart_rule` = ccr.`id_cart_rule`';

            $sql .= '
                AND ccr.`id_cart` = ' . (int)$this->id;

            $rows = Db::getInstance()->ExecuteS($sql);

            if (count($rows)) {
                foreach ($rows as $row) {
                    $discount += $row['reduction_percent'];
                }
            }
            $reduction = $discount / 100;

            return round($parent + ($this->productfieldsaddon * $reduction), 2, PHP_ROUND_HALF_UP);
        } else {
            return $parent;
        }
    }

    public function deleteProduct(
        $id_product,
        $id_product_attribute = null,
        $id_customization = null,
        $id_address_delivery = 0,
        $auto_add_cart_rule = false
    ) {
        $module = Module::getInstanceByName('an_productfields');
        if (Tools::getIsset('anproductfieldshash') && Tools::getValue('anproductfieldshash') != 'no') {
            $quantity = $module->deleteByHash(Tools::getValue('anproductfieldshash'));
            $product_total_quantity = (int)Db::getInstance()->getValue(
                'SELECT `quantity`
				FROM `'._DB_PREFIX_.'cart_product`
				WHERE `id_product` = '.(int)$id_product.'
				AND `id_cart` = '.(int)$this->id.'
				AND `id_product_attribute` = '.(int)$id_product_attribute
            );
            $diference =$product_total_quantity-$quantity;
            if ($diference < 1) {
                return parent::deleteProduct($id_product, $id_product_attribute, $id_customization, $id_address_delivery, $auto_add_cart_rule);
            }
            return $this->updateQty(
                $quantity,
                $id_product,
                $id_product_attribute,
                $id_customization,
                'down',
                $id_address_delivery
            );
        }
        if (Tools::getIsset('anproductfieldshash') && Tools::getValue('anproductfieldshash') == 'no') {
            $cartItemData = $module->getCartItemData(
                $this->id,
                $id_product,
                $id_product_attribute
            );
            if (count($cartItemData)) {
                $fieldsquantity = 0;
                foreach ($cartItemData as $hash => $data) {
                    $fieldsquantity += $data['qty'];
                }
                $row = '
                    SELECT quantity
                    FROM `'._DB_PREFIX_.'cart_product`
                    WHERE `id_cart` = '.(int)$this->id.'
                    AND `id_product` = '.(int)$id_product;
                if ($id_customization != null) {
                    $row .= ' AND `id_customization` = '.(int)$id_customization;
                }
                if ($id_product_attribute != null) {
                    $row .= ' AND `id_product_attribute` = '.(int)$id_product_attribute;
                }
                $result = Db::getInstance()->getRow($row);
                $quantity = $result['quantity'] - $fieldsquantity;
                if ($quantity < 1) {
                    return parent::deleteProduct($id_product, $id_product_attribute, $id_customization, $id_address_delivery, $auto_add_cart_rule);
                }
                if ($quantity > 0) {
                    return $this->updateQty(
                        $quantity,
                        $id_product,
                        $id_product_attribute,
                        $id_customization,
                        'down',
                        $id_address_delivery
                    );
                } else {
                    return false;
                }
            }
        }
        $cartItemData = $module->getCartItemData(
            $this->id,
            $id_product,
            $id_product_attribute
        );
        if (count($cartItemData)) {
            foreach ($cartItemData as $hash => $data) {
                $module->deleteByHash($hash);
            }
        }
        return parent::deleteProduct($id_product, $id_product_attribute, $id_customization, $id_address_delivery, $auto_add_cart_rule);
    }

    public function duplicate()
    {
        $parent = parent::duplicate();
        if ($parent['success']) {
            $module = Module::getInstanceByName('an_productfields');
            $products = parent::getProducts();
            foreach ($products as $product) {
                $cartItemData = $module->getRawCartItemData(
                    $this->id,
                    $product['id_product'],
                    $product['id_product_attribute']
                );
                if (count($cartItemData)) {
                    $hashData = '';
                    $values = array();
                    foreach ($cartItemData as $data) {
                        $hashData .= $data['id_an_productfields'] . '_' . $this->id . '_' . $product['id_product']
                            . '_' . $product['id_product_attribute'] . '_' . pSQL($data['value']) . '_' . (float)$data['price'];
                        $values[] = array(
                            'id_an_productfields' => (int)$data['id_an_productfields'],
                            'id_cart' => (int)$parent['cart']->id,
                            'id_product' => (int)$product['id_product'],
                            'id_product_attribute' => (int)$product['id_product_attribute'],
                            'value' => pSQL($data['value']),
                            'field_name' => pSQL($data['field_name']),
                            'field_type' => pSQL($data['field_type']),
                            'price' => (float)$data['price'],
                        );
                        $values_hash = md5($hashData);
                        foreach ($values as $value) {
                            $value['values_hash'] = pSQL($values_hash);
                            Db::getInstance()->insert('an_productfields_cart', $value, true, false, Db::REPLACE);
                        }
                        $cart_values = array(
                            'values_hash' => pSQL($values_hash),
                            'qty' => (int)$data['qty']
                        );
                        Db::getInstance()->insert('an_productfields_cart_values', $cart_values, true, false, Db::REPLACE);
                    }
                }
            }
        }
        return $parent;
    }
}
