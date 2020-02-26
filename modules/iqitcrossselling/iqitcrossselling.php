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
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2017 IQIT-COMMERCE.COM
 * @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

if (!defined('_PS_VERSION_')) {
    exit;
}

class IqitCrossselling extends Module implements WidgetInterface
{
    private $templateFileAll;
    private $templateFileModal;

    public function __construct()
    {
        $this->name = 'iqitcrossselling';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = array(
            'min' => '1.7.2.0',
            'max' => _PS_VERSION_,
        );

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IQITCROSSELING - products');
        $this->description = $this->l('Adds a "Customers who bought this product also bought..." section on product page, cart and modal');

        $this->templateFileAll = 'module:iqitcrossselling/views/templates/hook/other.tpl';
        $this->templateFileModal = 'module:iqitcrossselling/views/templates/hook/modal.tpl';
    }

    public function install()
    {

        return parent::install()
            && $this->registerHook('displayFooterProduct')
            && $this->registerHook('displayModalCartCrosseling')
            && $this->registerHook('displayShoppingCart')
            && $this->registerHook('actionOrderStatusPostUpdate');
    }

    public function uninstall()
    {

        return parent::uninstall();
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
    }

    protected function _clearCache($template, $cacheId = null, $compileId = null)
    {
        parent::_clearCache($this->templateFileAll);
        parent::_clearCache($this->templateFileModal);
    }


    public function getCacheIdKey($productIds)
    {
        return parent::getCacheId('iqitcrossselling|' . implode('|', $productIds));
    }

    private function getProductIds($hookName, array $configuration)
    {
        if ('displayShoppingCart' === $hookName) {
            $productIds = array_map(function ($elem) {
                return $elem['id_product'];
            }, $configuration['cart']->getProducts());
        } else {
            $productIds = array($configuration['product']['id_product']);
        }

        return array_unique($productIds);
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $productIds = $this->getProductIds($hookName, $configuration);
        if (!empty($productIds)) {
            $products = $this->getOrderProducts($productIds);

            if (!empty($products)) {
                return array(
                    'products' => $products,
                );
            }
        }
        return false;
    }

    public function renderWidget($hookName, array $configuration)
    {

        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayModalCartCrosseling\d*$/', $hookName)) {
            $templateFile = $this->templateFileModal;
        }  else {
            $templateFile = $this->templateFileAll;
        }

        $productIds = $this->getProductIds($hookName, $configuration);

        if (empty($productIds)) {
            return;
        }


            $variables = $this->getWidgetVariables($hookName, $configuration);

            if (empty($variables)) {
                return false;
            }

            $this->smarty->assign($variables);


        return $this->fetch($templateFile);
    }

    protected function getOrderProducts(array $productIds = array())
    {
        $q_orders = 'SELECT o.id_order
        FROM '._DB_PREFIX_.'orders o
        LEFT JOIN '._DB_PREFIX_.'order_detail od ON (od.id_order = o.id_order)
        WHERE o.valid = 1
        AND od.product_id IN ('.implode(',', $productIds).')';

        $orders = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($q_orders);

        if (0 < count($orders)) {
            $list = '';
            foreach ($orders as $order) {
                $list .= (int)$order['id_order'].',';
            }
            $list = rtrim($list, ',');
            $list_product_ids = join(',', $productIds);

            if (Group::isFeatureActive()) {
                $sql_groups_join = '
                LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = product_shop.id_category_default AND cp.id_product = product_shop.id_product)
                LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.`id_category` = cg.`id_category`)';
                $groups = FrontController::getCurrentCustomerGroups();
                $sql_groups_where = 'AND cg.`id_group` '. (count($groups) ? 'IN ('.implode(',', $groups) . ')' : '=' . (int)Group::getCurrent()->id);
            }

            $order_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT DISTINCT od.product_id
                FROM '._DB_PREFIX_.'order_detail od
                LEFT JOIN '._DB_PREFIX_.'product p ON (p.id_product = od.product_id)
                '.Shop::addSqlAssociation('product', 'p').
                (Combination::isFeatureActive() ? 'LEFT JOIN `' . _DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
                ' . Shop::addSqlAssociation(
                        'product_attribute',
                        'pa',
                        false,
                        'product_attribute_shop.`default_on` = 1'
                    ).'
                ' . Product::sqlStock(
                        'p',
                        'product_attribute_shop',
                        false,
                        $this->context->shop
                    ) :  Product::sqlStock(
                    'p',
                    'product',
                    false,
                    $this->context->shop
                )).'
                LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (pl.id_product = od.product_id' .
                Shop::addSqlRestrictionOnLang('pl').')
                LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = product_shop.id_category_default'
                .Shop::addSqlRestrictionOnLang('cl').')
                LEFT JOIN '._DB_PREFIX_.'image i ON (i.id_product = od.product_id)
                '.(Group::isFeatureActive() ? $sql_groups_join : '').'
                WHERE od.id_order IN ('.$list.')
                AND pl.id_lang = '.(int)$this->context->language->id.'
                AND cl.id_lang = '.(int)$this->context->language->id.'
                AND od.product_id NOT IN ('.$list_product_ids.')
                AND i.cover = 1
                AND p.visibility  IN ("both", "catalog")
                AND product_shop.active = 1
                '.(Group::isFeatureActive() ? $sql_groups_where : '').'
                ORDER BY RAND()
                LIMIT 10'
            );
        }

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

        return false;
    }
}
