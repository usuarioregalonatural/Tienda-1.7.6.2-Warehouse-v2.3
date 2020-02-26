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

/**
 * @since 1.5.0
 */
class IqitWishlistActionsModuleFrontController extends ModuleFrontController
{
    /**
     * @var int
     */
    public $id_product;
    public $id_product_attribute;


    public function init()
    {
        parent::init();

        require_once $this->module->getLocalPath() . 'src/IqitWishlistProduct.php';
        $this->id_product = (int)Tools::getValue('id_product');
        $this->id_product_attribute = (int)Tools::getValue('id_product_attribute');
    }

    public function postProcess()
    {
        if (Tools::getValue('process') == 'remove') {
            $this->processRemove();
        } elseif (Tools::getValue('process') == 'add') {
            $this->processAdd();
        }
    }

    /**
     * Remove a wishlist product.
     */
    public function processRemove()
    {
        header('Content-Type: application/json');

        $context = Context::getContext();

        if (!$context->customer->isLogged()) {
            $this->ajaxDie(json_encode(array(
                'success' => false,
                'data' => [
                    'message' => $this->l('You need to log in first'),
                    'type' => 'notLogged'
                ]
            )));
        }

        $wishlistProduct = new IqitWishlistProduct((int)Tools::getValue('idProduct'));
        $wishlistProduct->delete();

        $this->ajaxDie(json_encode(array(
            'success' => true,
            'data' => [
                'message' => $this->l('Product removed from wishlist'),
                'type' => 'removed'
            ]
        )));
    }

    /**
     * Add a wishlist product.
     */
    public function processAdd()
    {
        header('Content-Type: application/json');

        $context = Context::getContext();

        if (!$context->customer->isLogged()) {
            $this->ajaxDie(json_encode(array(
                'success' => false,
                'data' => [
                    'message' => $this->l('You need to log in first'),
                    'type' => 'notLogged'
                ]
            )));
        }

        $idProduct = (int)Tools::getValue('idProduct');
        $idProductAttribute = (int)Tools::getValue('idProductAttribute');
        $idCustomer = (int)$context->customer->id;
        $idShop = (int)$context->shop->id;
        $idLang = (int)$context->language->id;

        $product = new Product($idProduct, false, $idLang, $idShop, $context);

        if (!Validate::isLoadedObject($product) || IqitWishlistProduct::isCustomerWishlistProduct($idCustomer, (int)$product->id, $idProductAttribute)) {
            $this->ajaxDie(json_encode(array(
                'success' => false,
                'data' => [
                    'message' => $this->l('You need to log in first'),
                    'type' => 'inWishlit'
                ]
            )));
        } else {
            $wishlistProduct = new IqitWishlistProduct();
            $wishlistProduct->id_product = $idProduct;
            $wishlistProduct->id_customer = $idCustomer;
            $wishlistProduct->id_product_attribute = $idProductAttribute;
            $wishlistProduct->id_shop = $idShop;

            if ($wishlistProduct->add()) {
                $this->ajaxDie(json_encode(array(
                    'success' => true,
                    'data' => [
                        'message' => $this->l('Product added to wishlist'),
                        'type' => 'added'
                    ]
                )));
            }
        }
    }
}
