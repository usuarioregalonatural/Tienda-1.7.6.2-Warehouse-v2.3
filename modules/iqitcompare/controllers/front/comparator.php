<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

/**
 * @since 1.5.0
 */


use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class IqitCompareComparatorModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();
    }

    public function initContent()
    {
        parent::initContent();

        $presentedCompareProducts = array();
        $compareProducts = array();
        $orderedFeatures = array();
        $listFeatures = array();

        $idLang = (int)$this->context->language->id;
        $idShop = (int)$this->context->shop->id;
        $productsIds = $this->context->cookie->iqitCompare;

        if ($productsIds) {
            $productsIds = json_decode($productsIds, true);
            foreach ($productsIds as $idProduct) {
                $product =  new Product($idProduct, false, $idLang, $idShop, $this->context);

                if (Validate::isLoadedObject($product)) {
                    $product->id_product = $product->id;
                    $compareProducts[] = (array) $product;
                }
            }

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

            foreach ($compareProducts as $item) {
                $presentedProduct = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($item),
                    $this->context->language
                );

                $presentedCompareProducts[] = $presentedProduct;


                foreach ($presentedProduct['features'] as $feature) {
                    $listFeatures[$presentedProduct['id_product']][$feature['id_feature']][] = $feature['value']." \n";
                }
            }

            $orderedFeatures = $this->module->getFeaturesForComparison($productsIds, $idLang);
        }

        $this->context->smarty->assign(array(
            'compareProducts' => $presentedCompareProducts,
            'orderedFeatures' => $orderedFeatures,
            'listFeatures' => $listFeatures
        ));

        $this->setTemplate('module:iqitcompare/views/templates/front/comparator.tpl');
    }
}
