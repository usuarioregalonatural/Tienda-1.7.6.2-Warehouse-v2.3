<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';

class SimpleBlogPostAuthor extends ObjectModel
{
    public $id_simpleblog_author;
    public $firstname;
    public $lastname;
    public $photo;
    public $email;
    public $facebook;
    public $google;
    public $linkedin;
    public $twitter;
    public $instagram;
    public $phone;
    public $www;
    public $active = 1;

    public $bio;
    public $additional_info;

    public $posts;

    public static $definition = array(
        'table' => 'simpleblog_author',
        'primary' => 'id_simpleblog_author',
        'multilang' => true,
        'fields' => array(
            'firstname' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 255
            ),
            'lastname' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 255
            ),
            'photo' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything',
                'size' => 9999
            ),
            'email' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isEmail',
                'size' => 140
            ),
            'facebook' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'google' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'linkedin' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'twitter' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'instagram' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'phone' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isPhoneNumber'
            ),
            'www' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isUrl'
            ),
            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool'
            ),
            'bio' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHtml',
                'lang' => true,
            ),
            'additional_info' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHtml',
                'lang' => true,
            ),
        ),
    );

    public function __construct($id_simpleblog_author = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_simpleblog_author, $id_lang, $id_shop);

        if ($this->id_simpleblog_author && !isset(Context::getContext()->employee)) {
            $finder = new BlogPostsFinder;
            $finder->setAuthor($this->id_simpleblog_author);
            $this->posts = $finder->findPosts();
        }
    }

    public static function getAll()
    {
        $sql = new DbQuery();
        $sql->select('CONCAT (sba.`firstname`, " ", sba.`lastname`) as name, sba.*, sbal.bio, sbal. additional_info');
        $sql->from('simpleblog_author', 'sba');
        $sql->leftJoin('simpleblog_author_lang', 'sbal', 'sba.`id_simpleblog_author` = sbal.`id_simpleblog_author` AND sbal.`id_lang` = '.Context::getContext()->language->id);
        $sql->where('sba.active = 1');
        $sql->orderBy('id_simpleblog_author ASC');

        return Db::getInstance()->executeS($sql);
    }
}
