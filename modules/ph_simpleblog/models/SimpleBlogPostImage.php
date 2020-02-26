<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2017 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';

class SimpleBlogPostImage extends ObjectModel
{
    public $id;
    public $id_simpleblog_post_image;
    public $id_simpleblog_post;
    public $position;
    public $image;

    public static $definition = array(
        'table' => 'simpleblog_post_image',
        'primary' => 'id_simpleblog_post_image',
        'multilang' => false,
        'fields' => array(
            'id_simpleblog_post' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'position' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'image' => array(
                'type' => self::TYPE_STRING
            ),
        ),
    );

    public function __construct($id_simpleblog_post_image = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_simpleblog_post_image, $id_lang, $id_shop);
    }

    public function delete()
    {
        if (!parent::delete()) {
            return false;
        }

        if (!$this->deletePostImage()) {
            return false;
        }

        if (!$this->cleanPositions($this->id_simpleblog_post)) {
            return false;
        }

        return true;
    }

    public static function getAll()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('simpleblog_post_image', 'sbpi');
        $sql->orderBy('position ASC');

        return Db::getInstance()->executeS($sql);
    }

    public static function getAllById($id_simpleblog_post)
    {
        if (!Validate::isUnsignedInt($id_simpleblog_post)) {
            die('getAllById - invalid ID');
        }

        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('simpleblog_post_image', 'sbpi');
        $sql->where('id_simpleblog_post = '.(int) $id_simpleblog_post);
        $sql->orderBy('position ASC');

        return Db::getInstance()->executeS($sql);
    }

    public static function getNewLastPosition($id_simpleblog_post)
    {
        return Db::getInstance()->getValue('
            SELECT IFNULL(MAX(position),0)+1
            FROM `'._DB_PREFIX_.'simpleblog_post_image`
            WHERE `id_simpleblog_post` = '.(int) $id_simpleblog_post);
    }

    public function cleanPositions($id_simpleblog_post)
    {
        $result = Db::getInstance()->executeS('
            SELECT `id_simpleblog_post_image`
            FROM `'._DB_PREFIX_.'simpleblog_post_image`
            WHERE `id_simpleblog_post` = '.(int) $id_simpleblog_post.'
            ORDER BY `position`
        ');
        $sizeof = count($result);
        for ($i = 0; $i < $sizeof; ++$i) {
            Db::getInstance()->execute('
                UPDATE `'._DB_PREFIX_.'simpleblog_post_image`
                SET `position` = '.($i + 1).'
                WHERE `id_simpleblog_post_image` = '.(int) $result[$i]['id_simpleblog_post_image']);
        }

        return true;
    }

    public function deletePostImage()
    {
        $response = true;

        $images = glob(_SIMPLEBLOG_GALLERY_DIR_.(int) $this->id.'-'.(int) $this->id_simpleblog_post.'-*');

        foreach ($images as $image) {
            $response &= @unlink($image);
        }

        return $response;
    }
}
