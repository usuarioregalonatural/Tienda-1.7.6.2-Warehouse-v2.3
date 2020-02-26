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
class IqitWishlistProduct extends ObjectModel
{
    public $id_iqitwishlist_product;
    public $id_product;
    public $id_customer;
    public $id_product_attribute;
    public $id_shop;

    public static $definition = array(
        'table' => 'iqitwishlist_product',
        'primary' => 'id_iqitwishlist_product',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_product_attribute' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => true
            ),
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
        ),
    );


    public static function getWishlistProductsNb($idCustomer, Shop $shop = null)
    {
        if (!$idCustomer) {
            return false;
        }
        if (!$shop) {
            $shop = Context::getContext()->shop;
        }
        return Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `' . _DB_PREFIX_ . 'iqitwishlist_product`
			WHERE `id_customer` = ' . (int)$idCustomer . '
			AND `id_shop` = ' . (int)$shop->id);
    }

    public static function isCustomerWishlistProduct($idCustomer, $idProduct, $idProductAttribute, Shop $shop = null)
    {
        if (!$idCustomer) {
            return false;
        }
        if (!$shop) {
            $shop = Context::getContext()->shop;
        }
        return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `' . _DB_PREFIX_ . 'iqitwishlist_product`
			WHERE `id_customer` = ' . (int)$idCustomer . '
			AND `id_product` = ' . (int)$idProduct . '
			AND `id_product_attribute` = ' . (int)$idProductAttribute . '
			AND `id_shop` = ' . (int)$shop->id);
    }

    public static function getWishlistProducts($idCustomer, $id_lang, $full = false)
    {
        $context = Context::getContext();
        $sql = 'SELECT p.*, product_shop.*, pl.*, image_shop.`id_image` id_image, il.`legend`, cl.`name` AS category_default, product_shop.`id_category_default`, a.id_iqitwishlist_product, a.id_product_attribute
				FROM `' . _DB_PREFIX_ . 'iqitwishlist_product` a
				LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.id_product = a.id_product
				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
					ON p.id_product = pl.id_product
					AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int)$context->shop->id . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$id_lang . ')
				' . Shop::addSqlAssociation('product', 'p') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
					ON product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('cl') . '
				WHERE product_shop.`id_shop` = ' . (int)$context->shop->id . '
				AND a.`id_customer` = ' . (int)$idCustomer . '
				GROUP BY a.`id_product`, a.`id_product_attribute`';
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        foreach ($result as &$line) {
            if (Combination::isFeatureActive() && isset($line['id_product_attribute']) && $line['id_product_attribute']) {
                $line['cache_default_attribute'] = $line['id_product_attribute'] = $line['id_product_attribute'];
                $sql = 'SELECT agl.`name` AS group_name, al.`name` AS attribute_name,  pai.`id_image` AS id_product_attribute_image
				FROM `' . _DB_PREFIX_ . 'product_attribute` pa
				' . Shop::addSqlAssociation('product_attribute', 'pa') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_combination` pac ON pac.`id_product_attribute` = ' . $line['id_product_attribute'] . '
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' . (int)Context::getContext()->language->id . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' . (int)Context::getContext()->language->id . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_image` pai ON (' . $line['id_product_attribute'] . ' = pai.`id_product_attribute`)
				WHERE pa.`id_product` = ' . (int)$line['id_product'] . ' AND pa.`id_product_attribute` = ' . $line['id_product_attribute'] . '
				GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
				ORDER BY pa.`id_product_attribute`';
                $attr_name = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
                if (isset($attr_name[0]['id_product_attribute_image']) && $attr_name[0]['id_product_attribute_image']) {
                    $line['id_image'] = $attr_name[0]['id_product_attribute_image'];
                }
            }
            $line = Product::getTaxesInformations($line);
        }
        if (!$full) {
            return $result;
        }
        $array_result = array();
        foreach ($result as $prow) {
            if (!Pack::isPack($prow['id_product'])) {
                $prow['id_product_attribute'] = (int)$prow['id_product_attribute'];
                $prow['cover'] = 'aaaa';
                $array_result[] = Product::getProductProperties($id_lang, $prow);
            }
        }
        return $array_result;
    }


    public static function getOrderProducts(array $productIds = array())
    {
        $context = Context::getContext();
        $order_products = array();

        $q_orders = 'SELECT o.id_order
        FROM ' . _DB_PREFIX_ . 'orders o
        LEFT JOIN ' . _DB_PREFIX_ . 'order_detail od ON (od.id_order = o.id_order)
        WHERE o.valid = 1
        AND od.product_id IN (' . implode(',', $productIds) . ')';
        $orders = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($q_orders);
        if (0 < count($orders)) {
            $list = '';
            foreach ($orders as $order) {
                $list .= (int)$order['id_order'] . ',';
            }
            $list = rtrim($list, ',');
            $list_product_ids = join(',', $productIds);
            if (Group::isFeatureActive()) {
                $sql_groups_join = '
                LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON (cp.`id_category` = product_shop.id_category_default AND cp.id_product = product_shop.id_product)
                LEFT JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.`id_category` = cg.`id_category`)';
                $groups = FrontController::getCurrentCustomerGroups();
                $sql_groups_where = 'AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',',
                            $groups) . ')' : '=' . (int)Group::getCurrent()->id);
            }
            $order_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT DISTINCT od.product_id
                FROM ' . _DB_PREFIX_ . 'order_detail od
                LEFT JOIN ' . _DB_PREFIX_ . 'product p ON (p.id_product = od.product_id)
                ' . Shop::addSqlAssociation('product', 'p') .
                (Combination::isFeatureActive() ? 'LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
                ' . Shop::addSqlAssociation(
                        'product_attribute',
                        'pa',
                        false,
                        'product_attribute_shop.`default_on` = 1'
                    ) . '
                ' . Product::sqlStock(
                        'p',
                        'product_attribute_shop',
                        false,
                        $context->shop
                    ) : Product::sqlStock(
                    'p',
                    'product',
                    false,
                    $context->shop
                )) . '
                LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON (pl.id_product = od.product_id' .
                Shop::addSqlRestrictionOnLang('pl') . ')
                LEFT JOIN ' . _DB_PREFIX_ . 'category_lang cl ON (cl.id_category = product_shop.id_category_default'
                . Shop::addSqlRestrictionOnLang('cl') . ')
                LEFT JOIN ' . _DB_PREFIX_ . 'image i ON (i.id_product = od.product_id)
                ' . (Group::isFeatureActive() ? $sql_groups_join : '') . '
                WHERE od.id_order IN (' . $list . ')
                AND pl.id_lang = ' . (int)$context->language->id . '
                AND cl.id_lang = ' . (int)$context->language->id . '
                AND od.product_id NOT IN (' . $list_product_ids . ')
                AND i.cover = 1
                AND product_shop.active = 1
                ' . (Group::isFeatureActive() ? $sql_groups_where : '') . '
                ORDER BY RAND()
                LIMIT ' . (int)Configuration::get('CROSSSELLING_NBR')
            );
        }

        return $order_products;
    }
}
