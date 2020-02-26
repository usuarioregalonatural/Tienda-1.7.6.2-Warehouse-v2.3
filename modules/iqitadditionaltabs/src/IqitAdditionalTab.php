<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software)
 *
 */

class IqitAdditionalTab extends ObjectModel
{
    public $id_shop;
    public $id_iqitadditionaltab;
    public $id_product;
    public $position;
    public $active;

    public $title;
    public $description;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iqitadditionaltab',
        'primary' => 'id_iqitadditionaltab',
        'multilang' => true,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'active' =>   array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position' =>        array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),

            // Lang fields
            'title' =>            array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'description' =>    array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),

        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
    }

    public static function getIdByProduct($idProduct)
    {
        if (!Validate::isUnsignedInt($idProduct)) {
            return;
        }

        $sql = 'SELECT id_iqitadditionaltab FROM ' . _DB_PREFIX_ . 'iqitadditionaltab WHERE id_product = ' . (int) $idProduct;
        $return = Db::getInstance()->getValue($sql);

        return $return;
    }

    public function add($autoDate = true, $nullValues = false)
    {
        $this->position = IqitAdditionalTab::getLastPosition((int) $this->id_product);
        return parent::add($autoDate, true);
    }

    public function delete()
    {
        $res = true;
        // $res &= $this->reOrderPositions();
        $res &= Db::getInstance()->execute('
            DELETE FROM `'._DB_PREFIX_.'iqitadditionaltab_shop`
            WHERE `id_iqitadditionaltab` = '.(int)$this->id);
        $res &= parent::delete();
        return $res;
    }

    public function update($null_values = false, $position = false)
    {
        if (!$position) {
            if (isset($this->id)) {
                Db::getInstance()->delete('iqitadditionaltab_shop', 'id_iqitadditionaltab = ' . (int) $this->id);
            }
            $this->associateTo($this->id_shop_list);
        }

        return parent::update();
    }

    public static function getTabs($where = 'all', $idProduct = 0, $active = false, $idLang = null)
    {
        if (!Validate::isUnsignedInt($idProduct)) {
            return;
        }

        $context = Context::getContext();

        if (is_null($idLang)) {
            $idLang = $context->language->id;
        }

        $whereSql = '';
        switch ($where) {
            case 'all':
                $whereSql = '(t.id_product = 0 OR t.id_product = '.(int) $idProduct.')';
                break;
            case 'product':
                $whereSql = '(t.id_product = '.(int) $idProduct.')';
                break;
            case 'global':
                $whereSql = '(t.id_product = 0)';
                break;
        }

        $tabs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
        SELECT *
        FROM '._DB_PREFIX_.'iqitadditionaltab t
        LEFT JOIN '._DB_PREFIX_.'iqitadditionaltab_lang tl ON (t.id_iqitadditionaltab = tl.id_iqitadditionaltab AND tl.id_lang = '.(int) $idLang.')
        '.Shop::addSqlAssociation('iqitadditionaltab', 't').'
        WHERE '. $whereSql . ($active ? ' AND t.`active` = 1 ' : '') . ' GROUP BY t.id_iqitadditionaltab
        ORDER BY t.`position`');


        return $tabs;
    }

    public static function getIdTabs($where = 'all', $idProduct = 0, $active = false)
    {
        if (!Validate::isUnsignedInt($idProduct)) {
            return;
        }

        $whereSql = '';
        switch ($where) {
            case 'all':
                $whereSql = '(t.id_product = 0 OR t.id_product = '.(int) $idProduct.')';
                break;
            case 'product':
                $whereSql = '(t.id_product = '.(int) $idProduct.')';
                break;
            case 'global':
                $whereSql = '(t.id_product = 0)';
                break;
        }

        $tabs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
        SELECT t.id_iqitadditionaltab
        FROM '._DB_PREFIX_.'iqitadditionaltab t
        '.Shop::addSqlAssociation('iqitadditionaltab', 't').'
        WHERE '. $whereSql . ($active ? ' AND t.`active` = 1 ' : '') . ' GROUP BY t.id_iqitadditionaltab
        ORDER BY t.`position`');


        return $tabs;
    }

    public function copyFromPost()
    {
        /* Classical fields */
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $this) and $key != 'id_'.self::$definition['table']) {
                $this->{$key} = $value;
            }
        }

        /* Multilingual fields */
        $class_vars = get_class_vars(get_class($this));
        $fields = array();
        if (isset($class_vars['definition']['fields'])) {
            $fields = $class_vars['definition']['fields'];
        }
        foreach ($fields as $field => $params) {
            if (array_key_exists('lang', $params) && $params['lang']) {
                foreach (Language::getIDs(false) as $id_lang) {
                    if (Tools::isSubmit($field.'_'.(int)$id_lang)) {
                        $this->{$field}[(int)$id_lang] = Tools::getValue($field.'_'.(int)$id_lang);
                    }
                }
            }
        }
    }

    public function copyFromAjax($formFields)
    {
        /* Classical fields */
        foreach ($formFields as $key => $value) {
            if (array_key_exists($key, $this) and $key != 'id_'.self::$definition['table']) {
                $this->{$key} = $value;
            }
        }

        /* Multilingual fields */
        $class_vars = get_class_vars(get_class($this));
        $fields = array();
        if (isset($class_vars['definition']['fields'])) {
            $fields = $class_vars['definition']['fields'];
        }
        foreach ($fields as $field => $params) {
            if (array_key_exists('lang', $params) && $params['lang']) {
                foreach (Language::getIDs(false) as $id_lang) {
                    if (isset($formFields[$field.'_'.(int)$id_lang])) {
                        $this->{$field}[(int)$id_lang] = $formFields[$field.'_'.(int)$id_lang];
                    }
                }
            }
        }
    }




    public static function getLastPosition($idProduct)
    {
        $sql = '
        SELECT MAX(position) + 1
        FROM `'._DB_PREFIX_.'iqitadditionaltab`
        WHERE `id_product` = '.(int) $idProduct;
        return (Db::getInstance()->getValue($sql));
    }

    public static function updatePositions($tabs)
    {
        foreach ($tabs as $position => $id_iqitadditionaltab) {
            $res = Db::getInstance()->execute('
                UPDATE `'._DB_PREFIX_.'iqitadditionaltab` SET `position` = '.(int)$position.'
                WHERE `id_iqitadditionaltab` = '.(int) $id_iqitadditionaltab);
        }
    }

    public static function getAssociatedIdsShop($id_iqitadditionaltab)
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT ts.`id_shop`
            FROM `'._DB_PREFIX_.'iqitadditionaltab_shop` ts
            WHERE ts.`id_iqitadditionaltab` = '.(int)$id_iqitadditionaltab);
        if (!is_array($result)) {
            return false;
        }
        $return = array();
        foreach ($result as $id_shop) {
            $return[] = (int)$id_shop['id_shop'];
        }
        return $return;
    }
}
