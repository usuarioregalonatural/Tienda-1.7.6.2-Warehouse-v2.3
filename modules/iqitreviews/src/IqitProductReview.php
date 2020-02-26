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

class IqitProductReview extends ObjectModel
{
    public $id_review;
    public $id_product;
    public $id_customer;
    public $id_guest;
    public $customer_name;
    public $title;
    public $comment;
    public $rating;
    /**
     * @var int 0=hidden 1=published
     */
    public $status;
    public $date_add;

    /**
     * @see ObjectModel::$definition
     */

    public static $definition = array(
        'table' => 'iqitreviews_products',
        'primary' => 'id_review',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'id_guest' => array('type' => self::TYPE_INT),
            'customer_name' => array('type' => self::TYPE_STRING, 'size' => 255),
            'title' => array('type' => self::TYPE_STRING, 'size' => 255, 'required' => true),
            'comment' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 65535, 'required' => true),
            'rating' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'status' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE),
        ),
    );

    public static function clearProductReviews($idProduct)
    {
        if (!Validate::isUnsignedInt($idProduct)) {
            return;
        }
        Db::getInstance()->delete(self::$definition['table'], 'id_product = ' . (int) $idProduct);
    }



    public static function getByCustomer($idProduct, $idCustomer, $getLast = false, $idGuest = false)
    {
        $cacheId = 'IqitProductReview::getByCustomer_'.(int)$idProduct.'-'.(int)$idCustomer.'-'.(bool)$getLast.'-'.(int)$idGuest;
        if (!Cache::isStored($cacheId)) {
            $results = Db::getInstance()->executeS('
				SELECT *
				FROM `'._DB_PREFIX_.self::$definition['table'].'` pr
				WHERE pr.`id_product` = '.(int)$idProduct.'
				AND '.(!$idGuest ? 'pr.`id_customer` = '.(int)$idCustomer : 'pr.`id_guest` = '.(int) $idGuest).'
				ORDER BY pr.`date_add` DESC '
                .($getLast ? 'LIMIT 1' : ''));
            if ($getLast && count($results)) {
                $results = array_shift($results);
            }
            Cache::store($cacheId, $results);
        }
        return Cache::retrieve($cacheId);
    }

    public static function getByProduct($idProduct, $status = 1)
    {
        if (!Validate::isUnsignedId($idProduct)) {
            return false;
        }
        if (!Validate::isUnsignedId($status)) {
            return false;
        }

        $cacheId = 'IqitProductReview::getByProduct_'.(int)$idProduct;
        if (!Cache::isStored($cacheId)) {
            $result = Db::getInstance()->executeS('
				SELECT *
				FROM `'._DB_PREFIX_.self::$definition['table'].'` pr
				WHERE pr.`id_product` = '.(int)$idProduct
                .($status  ? ' AND pr.`status` = 1' : '').'
				ORDER BY pr.`date_add` DESC ');

            Cache::store($cacheId, $result);
        }
        return Cache::retrieve($cacheId);
    }

    public static function getSnippetData($idProduct)
    {
        if (!Validate::isUnsignedId($idProduct)) {
            return false;
        }

        $cacheId = 'IqitProductReview::getSnippetData_'.(int)$idProduct;
        if (!Cache::isStored($cacheId)) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
				SELECT (SUM(pr.`rating`) / COUNT(pr.`rating`)) AS avarageRating, COUNT(pr.`rating`) as reviewsNb
				FROM `'._DB_PREFIX_.self::$definition['table'].'` pr
				WHERE pr.`status` = 1  AND pr.`id_product` = '.(int)$idProduct);

            Cache::store($cacheId, $result);
        }
        return Cache::retrieve($cacheId);
    }
}
