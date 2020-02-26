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

class ParentOrderController extends ParentOrderControllerCore
{
    protected function _assignSummaryInformations()
    {
        if (version_compare(_PS_VERSION_, '1.7.0.0', '<') && version_compare(_PS_VERSION_, '1.6.1.0', '>')) {
            $summary = $this->context->cart->getSummaryDetails();
            $customizedDatas = Product::getAllCustomizedDatas($this->context->cart->id);

            // override customization tax rate with real tax (tax rules)
            if ($customizedDatas) {
                foreach ($summary['products'] as &$productUpdate) {
                    $productId = (int)isset($productUpdate['id_product']) ? $productUpdate['id_product'] : $productUpdate['product_id'];
                    $productAttributeId = (int)isset($productUpdate['id_product_attribute']) ? $productUpdate['id_product_attribute'] : $productUpdate['product_attribute_id'];

                    if (isset($customizedDatas[$productId][$productAttributeId])) {
                        $productUpdate['tax_rate'] = Tax::getProductTaxRate($productId, $this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                    }
                }

                Product::addCustomizationPrice($summary['products'], $customizedDatas);
            }

            $cart_product_context = Context::getContext()->cloneContext();
            foreach ($summary['products'] as $key => &$product) {
                $product['quantity'] = $product['cart_quantity'];// for compatibility with 1.2 themes

                if ($cart_product_context->shop->id != $product['id_shop']) {
                    $cart_product_context->shop = new Shop((int)$product['id_shop']);
                }

                if (Product::getTaxCalculationMethod()) {
                    $product['is_discounted'] = Tools::ps_round($product['price_without_specific_price'], _PS_PRICE_COMPUTE_PRECISION_) != Tools::ps_round($product['price'], _PS_PRICE_COMPUTE_PRECISION_);
                } else {
                    $product['is_discounted'] = Tools::ps_round($product['price_without_specific_price'], _PS_PRICE_COMPUTE_PRECISION_) != Tools::ps_round($product['price_wt'], _PS_PRICE_COMPUTE_PRECISION_);
                }
            }

            // Get available cart rules and unset the cart rules already in the cart
            $available_cart_rules = CartRule::getCustomerCartRules($this->context->language->id, (isset($this->context->customer->id) ? $this->context->customer->id : 0), true, true, true, $this->context->cart, false, true);
            $cart_cart_rules = $this->context->cart->getCartRules();
            foreach ($available_cart_rules as $key => $available_cart_rule) {
                foreach ($cart_cart_rules as $cart_cart_rule) {
                    if ($available_cart_rule['id_cart_rule'] == $cart_cart_rule['id_cart_rule']) {
                        unset($available_cart_rules[$key]);
                        continue 2;
                    }
                }
            }

            $show_option_allow_separate_package = (!$this->context->cart->isAllProductsInStock(true) && Configuration::get('PS_SHIP_WHEN_AVAILABLE'));
            $advanced_payment_api = (bool)Configuration::get('PS_ADVANCED_PAYMENT_API');

            $this->context->smarty->assign($summary);
            $this->context->smarty->assign(array(
                'token_cart' => Tools::getToken(false),
                'isLogged' => $this->isLogged,
                'isVirtualCart' => $this->context->cart->isVirtualCart(),
                'productNumber' => $this->context->cart->nbProducts(),
                'voucherAllowed' => CartRule::isFeatureActive(),
                'shippingCost' => $this->context->cart->getOrderTotal(true, Cart::ONLY_SHIPPING),
                'shippingCostTaxExc' => $this->context->cart->getOrderTotal(false, Cart::ONLY_SHIPPING),
                'customizedDatas' => $customizedDatas,
                'CUSTOMIZE_FILE' => Product::CUSTOMIZE_FILE,
                'CUSTOMIZE_TEXTFIELD' => Product::CUSTOMIZE_TEXTFIELD,
                'lastProductAdded' => $this->context->cart->getLastProduct(),
                'displayVouchers' => $available_cart_rules,
                'show_option_allow_separate_package' => $show_option_allow_separate_package,
                'smallSize' => Image::getSize(ImageType::getFormatedName('small')),
                'advanced_payment_api' => $advanced_payment_api

            ));

            $this->context->smarty->assign(array(
                'HOOK_SHOPPING_CART' => Hook::exec('displayShoppingCartFooter', $summary),
                'HOOK_SHOPPING_CART_EXTRA' => Hook::exec('displayShoppingCart', $summary)
            ));
        } else {
            parent::_assignSummaryInformations();
        }
    }
}
