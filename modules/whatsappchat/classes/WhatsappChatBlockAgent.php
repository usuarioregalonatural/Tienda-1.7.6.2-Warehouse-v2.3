<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

class WhatsappChatBlockAgent extends ObjectModel
{
    public $id_whatsappchatblock_agent;
    public $id_whatsappchatblock;
    public $name;
    public $department;
    public $mobile_phone;
    public $image;
    public $position;
    public $active;
    public $schedule;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'whatsappchatblock_agent',
        'primary' => 'id_whatsappchatblock_agent',
        'multilang' => true,
        'fields' => array(
            'id_whatsappchatblock' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'name'                 => array('type' => self::TYPE_STRING),
            'department'           => array('type' => self::TYPE_STRING, 'lang' => true),
            'mobile_phone'         => array('type' => self::TYPE_STRING),
            'image'                => array('type' => self::TYPE_STRING),
            'position'             => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active'               => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'schedule'             => array('type' => self::TYPE_STRING),
        ),
    );

    public function add($autodate = true, $null_values = true)
    {
        $this->id_shop = ($this->id_shop) ? $this->id_shop : Context::getContext()->shop->id;
        return parent::add($autodate, $null_values);
    }

    public function getWhatsappChatAgents($id_whatsappchatblock = false, $active = false)
    {
        $langID = Context::getContext()->language->id;
        $sql = 'SELECT *
            FROM `' . _DB_PREFIX_ . bqSQL($this->def['table']) . '` LEFT JOIN `'
            . _DB_PREFIX_ . bqSQL($this->def['table']) . '_lang` ON (`' . _DB_PREFIX_ . bqSQL($this->def['table'])
            . '`.`id_whatsappchatblock_agent` = `' . _DB_PREFIX_ . bqSQL($this->def['table'])
            . '_lang`.`id_whatsappchatblock_agent` AND `id_lang` = ' . (int)$langID.')'
            . ' WHERE 1 = 1'
            . ($id_whatsappchatblock ? ' AND `' . _DB_PREFIX_ . bqSQL($this->def['table']) . '`.`id_whatsappchatblock` = ' . (int)$id_whatsappchatblock : '')
            . ($active ? ' AND `active` = 1' : '')
            . ' ORDER BY position';
        return Db::getInstance()->executeS($sql);
    }

    public static function getNbObjects()
    {
        $sql = 'SELECT COUNT(w.`id_whatsappchatblock_agent`) AS nb
                FROM `' . _DB_PREFIX_ . 'whatsappchatblock_agent` w';
        return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }
}
