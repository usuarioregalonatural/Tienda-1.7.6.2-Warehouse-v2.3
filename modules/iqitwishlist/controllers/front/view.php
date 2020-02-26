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

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;


class IqitWishlistViewModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();

        require_once $this->module->getLocalPath() . 'src/IqitWishlistProduct.php';
    }

    public function initContent()
    {
        parent::initContent();

        $engine = new PhpEncryption(_NEW_COOKIE_KEY_);

        $idCustomerToken = '';
        if (Context::getContext()->customer->isLogged()) {
            $idCustomer = (int)Context::getContext()->customer->id;
            $idCustomerToken = $engine->encrypt($idCustomer);
            $readOnly = false;
        } else {
            $encryptedValue = Tools::getValue('wishlistToken');
            if (!$encryptedValue) {
                Tools::redirect('index.php?controller=authentication&back=my-account');
            }

            $readOnly = true;
            $idCustomer = (int) $engine->decrypt($encryptedValue);

            if (!$idCustomer) {
                Tools::redirect('index.php?controller=authentication&back=my-account');
            }
        }


        $idLang = (int)Context::getContext()->language->id;
        $productsIds = array();
        $crosselingProducts = array();

        $wishlistProducts = IqitWishlistProduct::getWishlistProducts($idCustomer, $idLang);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $assembler = new ProductAssembler($this->context);
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->getTranslator()
        );

        $presentedWishlistProducts = array();
        foreach ($wishlistProducts as $item) {
            $productsIds[] = $item['id_product'];
            $presentedWishlistProducts[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($item),
                $this->context->language
            );
        }

        if ($productsIds) {
            $crosselingProducts = $this->getCrosselingProducts(array_unique($productsIds));
        }


        $this->context->smarty->assign(array(
            'wishlistProducts' => $presentedWishlistProducts,
            'idCustomer' => $idCustomer,
            'crosselingProducts' => $crosselingProducts,
            'token' => $idCustomerToken,
            'readOnly' => $readOnly,
        ));

        $this->setTemplate('module:iqitwishlist/views/templates/front/iqitwishlist-account.tpl');
    }

    public function getCrosselingProducts(array $productsIds = array())
    {
        $crosseling = (bool)Configuration::get('iqitwish_crosseling');

        if (!$crosseling) {
            return false;
        }

        $order_products = IqitWishlistProduct::getOrderProducts($productsIds);

        if (!empty($order_products)) {
            $assembler = new ProductAssembler($this->context);
            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever(
                    $this->context->link
                ),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );
            $productsForTemplate = array();
            if (is_array($order_products)) {
                foreach ($order_products as $productId) {
                    $productsForTemplate[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct(array('id_product' => $productId['product_id'])),
                        $this->context->language
                    );
                }
            }
            return $productsForTemplate;
        }
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();

        return $breadcrumb;
    }
}
