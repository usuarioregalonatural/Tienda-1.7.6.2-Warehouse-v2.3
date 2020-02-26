<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2017 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_ . 'ph_simpleblog/ph_simpleblog.php';

class SimpleBlogPostType extends ObjectModel
{
    public $id;
    public $id_simpleblog_post_type;
    public $name;
    public $slug;
    public $description;

    public static $definition = array(
        'table'                         => 'simpleblog_post_type',
        'primary'                       => 'id_simpleblog_post_type',
        'multilang'                     => false,
        'fields'                        => array(
            'name'                      => array('type' => self::TYPE_STRING),
            'slug'                      => array('type' => self::TYPE_STRING),
            'description'               => array('type' => self::TYPE_STRING),
        ),
    );

    public function __construct($id_simpleblog_post_type = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_simpleblog_post_type, $id_lang, $id_shop);
    }

    public static function getAll()
    {
        $sql = new DbQuery();
        $sql->select('id_simpleblog_post_type, name');
        $sql->from('simpleblog_post_type', 'sbpt');
        $sql->orderBy('id_simpleblog_post_type ASC');

        return Db::getInstance()->executeS($sql);
    }

    public static function getSlugById($id_simpleblog_post_type)
    {
        if (!Validate::isUnsignedInt($id_simpleblog_post_type)) {
            die('getSlugByID - invalid ID');
        }

        $sql = new DbQuery();
        $sql->select('slug');
        $sql->from('simpleblog_post_type', 'sbpt');
        $sql->where('id_simpleblog_post_type = '.(int) $id_simpleblog_post_type);

        return Db::getInstance()->getValue($sql);
    }

    public static function getIdBySlug($slug)
    {
        if (!Validate::isLinkRewrite($slug)) {
            die('getIdBySlug - invalid slug');
        }

        $sql = new DbQuery();
        $sql->select('id_simpleblog_post_type');
        $sql->from('simpleblog_post_type', 'sbpt');
        $sql->where('slug = \''.$slug.'\'');

        return Db::getInstance()->getValue($sql);
    }
}
