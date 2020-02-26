<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class IqitElementorLanding extends ObjectModel
{
	public $id;
    public $id_iqit_elementor_landing;
	public $id_shop;
    public $title;
    // Lang fields
    public $text;
    public $data;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'iqit_elementor_landing',
		'primary' => 'id_iqit_elementor_landing',
		'multilang' => true,
		'fields' => array(
			'id_shop' =>			array('type' => self::TYPE_NOTHING, 'validate' => 'isUnsignedId'),
            'title' =>              array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
			// Lang fields
            'data' =>           array('type' => self::TYPE_HTML,  'lang' => true, 'validate' => 'isJson'),
		)
	);

    public static function getLandingPages(){
        $sql = new DbQuery();
        $sql->select('id_iqit_elementor_landing, title');
        $sql->from('iqit_elementor_landing', 'iel');
        $sql->where('iel.id_shop = ' . (int) Context::getContext()->shop->id);
        $sqlResult = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $landingPages = array();
        foreach ($sqlResult as $p) {
            $landingPages[$p['id_iqit_elementor_landing']] = array(
                'id' => $p['id_iqit_elementor_landing'],
                'name' => $p['title']
            );
        }

        return  $landingPages;
    }
}
