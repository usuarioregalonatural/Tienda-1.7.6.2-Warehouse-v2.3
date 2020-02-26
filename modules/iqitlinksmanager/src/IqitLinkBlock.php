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

class IqitLinkBlock extends ObjectModel
{
    public $id_iqit_link_block;
    public $name;
    public $id_hook;
    public $position;
    public $id_shop;
    public $content;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iqit_link_block',
        'primary' => 'id_iqit_link_block',
        'multilang' => true,
        'fields' => array(
            'name' =>       array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'size' => 128),
            'id_hook' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'position' =>   array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'content' =>    array('type' => self::TYPE_STRING, 'validate' => 'isJson'),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);

        if ($this->id) {
            $this->content = json_decode($this->content, true);
        }

        if (is_null($this->content)) {
            $this->content = array();
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            if (!isset($this->name[$lang['id_lang']])){
                $this->name[$lang['id_lang']] = '';
            }
        }
    }

    public function add($auto_date = true, $null_values = false)
    {
        if (is_array($this->content)) {
            $this->content = json_encode($this->content);
        }

        if (!$this->position) {
            $this->position = IqitLinkBlock::getNextPosition($this->id_hook);
        }

        $return = parent::add($auto_date, $null_values);
        $this->content = json_decode($this->content, true);
        $this->associateTo($this->id_shop);
        return $return;
    }

    public function update($auto_date = true, $null_values = false)
    {
        if (is_array($this->content)) {
            $this->content = json_encode($this->content);
        }

        $return = parent::update($auto_date, $null_values);
        $this->content = json_decode($this->content, true);
        $this->associateTo($this->id_shop);
        return $return;
    }

    public function delete()
    {
        $res = true;
        $res &= Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'iqit_link_block_shop`
			WHERE `id_iqit_link_block` = ' . (int) $this->id);

        $res &= parent::delete();
        return $res;
    }

    public static function updateBlockPosition($id_iqit_link_block, $position)
    {
        $query = 'UPDATE `'._DB_PREFIX_.'iqit_link_block`
            SET `position` = '.(int)$position.'
            WHERE `id_iqit_link_block` = '.(int)$id_iqit_link_block;

        Db::getInstance()->execute($query);
    }

    public static function getNextPosition($id_hook)
    {
        $sql = 'SELECT MAX(`position`)
            FROM `'._DB_PREFIX_.'iqit_link_block`
            WHERE `id_hook` = '.(int)$id_hook;

        return Db::getInstance()->getValue($sql) + 1;
    }
}
