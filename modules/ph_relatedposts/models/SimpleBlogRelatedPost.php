<?php
require_once _PS_MODULE_DIR_ . 'ph_relatedposts/ph_relatedposts.php';


class SimpleBlogRelatedPost extends ObjectModel
{
    /** @var string Name */
    public $id;
    public $id_simpleblog_related_post;
    public $id_simpleblog_post;
    public $id_product;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'simpleblog_related_post',
        'primary' => 'id_simpleblog_related_post',
        'fields' => array(
            'id_simpleblog_post' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
        ),
    );

    public static function getByProductId($id_product)
    {
        if(!Validate::isUnsignedInt($id_product))
            die(Tools::displayError());

        $sql = new DbQuery();
        $sql->select('id_simpleblog_post, id_product');
        $sql->from('simpleblog_related_post');
        $sql->where('id_product = '.$id_product);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }

    public static function cleanRelatedForProduct($id_product)
    {
        if(!Validate::isUnsignedInt($id_product))
            die(Tools::displayError());

        return Db::getInstance()->delete('simpleblog_related_post', 'id_product = '.(int)$id_product);
    }

    public static function cleanRelatedForPost($id_simpleblog_post)
    {
        if(!Validate::isUnsignedInt($id_simpleblog_post))
            die(Tools::displayError());

        return Db::getInstance()->delete('simpleblog_related_post', 'id_simpleblog_post = '.(int)$id_simpleblog_post);
    }
}