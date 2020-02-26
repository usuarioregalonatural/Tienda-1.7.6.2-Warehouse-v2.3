<?php
/**
 * 2007-2015 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2007-2015 IQIT-COMMERCE.COM
 *  @license   GNU General Public License version 2
 *
 * You can not resell or redistribute this software.
 */

class IqitMenuHtml extends ObjectModel
{
    public $title;
    public $html;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iqitmegamenu_htmlc',
        'primary' => 'id_html',
        'multilang' => true,
        'fields' => array(
            'title' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'html' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
        ),
    );

    public function __construct($id_html = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_html, $id_lang, $id_shop);
    }

    public function add($autodate = true, $null_values = false)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;

        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'iqitmegamenu_html` (`id_html`, `id_shop`)
			VALUES(' . (int) $this->id . ', ' . (int) $id_shop . ')');
        return $res;
    }

    public function delete()
    {
        $res = true;

        $res &= Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'iqitmegamenu_html`
			WHERE `id_html` = ' . (int) $this->id);

        $res &= parent::delete();
        return $res;
    }

    public static function getHtmls()
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT hs.`id_html` as id_html, hss.`title`, hssl.`html`
			FROM ' . _DB_PREFIX_ . 'iqitmegamenu_html hs
			LEFT JOIN ' . _DB_PREFIX_ . 'iqitmegamenu_htmlc hss ON (hs.id_html = hss.id_html)
			LEFT JOIN ' . _DB_PREFIX_ . 'iqitmegamenu_htmlc_lang hssl ON (hs.id_html = hssl.id_html)
			WHERE hs.id_shop = ' . (int) $id_shop . '
			AND hssl.id_lang = ' . (int) $id_lang);
    }

    public static function htmlExists($id_html)
    {
        $req = 'SELECT hs.`id_html` as id_html
				FROM `' . _DB_PREFIX_ . 'iqitmegamenu_html` hs
				WHERE hs.`id_html` = ' . (int) $id_html;
        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

        return ($row);
    }
}
