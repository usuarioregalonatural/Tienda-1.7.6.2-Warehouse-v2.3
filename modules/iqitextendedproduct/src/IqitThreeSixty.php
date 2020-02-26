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

class IqitThreeSixty extends ObjectModel
{
    public $id_threesixty;
    public $id_product;
    public $content;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iqit_threesixty',
        'primary' => 'id_threesixty',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'content' => array('type' => self::TYPE_STRING, 'validate' => 'isJson'),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);

        if ($this->id) {
            $this->content = json_decode($this->content, true);
        }
    }

    public function add($auto_date = true, $null_values = false)
    {
        if (is_array($this->content)) {
            $this->content = json_encode($this->content);
        }

        $return = parent::add($auto_date, $null_values);
        $this->content = json_decode($this->content, true);
        return $return;
    }

    public function update($auto_date = true, $null_values = false)
    {
        if (is_array($this->content)) {
            $this->content = json_encode($this->content);
        }

        $return = parent::update($auto_date, $null_values);
        $this->content = json_decode($this->content, true);
        return $return;
    }

    public static function getIdByProduct($id_product)
    {
        if (!Validate::isUnsignedInt($id_product)) {
            return;
        }

        $sql = 'SELECT id_threesixty FROM ' . _DB_PREFIX_ . 'iqit_threesixty WHERE id_product = ' . (int) $id_product;
        $id_threesixty = Db::getInstance()->getValue($sql);

        return $id_threesixty;
    }
}
