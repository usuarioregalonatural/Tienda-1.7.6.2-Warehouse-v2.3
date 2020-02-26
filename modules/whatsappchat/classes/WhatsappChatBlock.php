<?php
/**
 * WhatsApp Chat
 *
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
 *  @author    idnovate
 *  @copyright 2019 idnovate
 *  @license   See above
*/

class WhatsappChatBlock extends ObjectModel
{
    public $id_whatsappchatblock;
    public $id_shop;
    public $id_hook;
    public $open_chat;
    public $message;
    public $def_message;
    public $offline_message;
    public $offline_link;
    public $position;
    public $color = '#25d366';
    public $mobile_phone;
    public $active;
    public $only_home;
    public $customer_groups;
    public $chat_group = '';
    public $badge_width;
    public $only_mobile;
    public $only_desktop;
    public $only_tablet;
    public $custom_css;
    public $custom_js;
    public $share_option;
    public $schedule;
    public $display_on;
    public $display_on_selection;
    public $filter_by_customer;
    public $customers;
    public $countries;
    public $zones;
    public $languages;
    public $currencies;
    public $pos;
    public $positions;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'whatsappchatblock',
        'primary' => 'id_whatsappchatblock',
        'multilang' => true,
        'fields' => array(
            'id_shop'               => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_hook'               => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'open_chat'             => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'message'               => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'lang' => true),
            'def_message'           => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'lang' => true),
            'offline_message'       => array('type' => self::TYPE_STRING, 'lang' => true),
            'offline_link'          => array('type' => self::TYPE_STRING, 'lang' => true),
            'pos'                   => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'color'                 => array('type' => self::TYPE_STRING, 'validate' => 'isColor'),
            'mobile_phone'          => array('type' => self::TYPE_STRING, 'size' => 32, 'lang' => true),
            'active'                => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'only_home'             => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'customer_groups'       => array('type' => self::TYPE_STRING),
            'chat_group'            => array('type' => self::TYPE_STRING),
            'badge_width'           => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'only_mobile'           => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'only_desktop'          => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'only_tablet'           => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'share_option'          => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'schedule'              => array('type' => self::TYPE_STRING),
            'custom_css'            => array('type' => self::TYPE_STRING),
            'custom_js'             => array('type' => self::TYPE_STRING),
            'display_on'            => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'display_on_selection'  => array('type' => self::TYPE_STRING),
            'filter_by_customer'    => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'customers'             => array('type' => self::TYPE_STRING),
            'countries'             => array('type' => self::TYPE_STRING),
            'zones'                 => array('type' => self::TYPE_STRING),
            'languages'             => array('type' => self::TYPE_STRING),
            'currencies'            => array('type' => self::TYPE_STRING),
            'position'              => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'positions'             => array('type' => self::TYPE_STRING),
        ),
    );

    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
    }

    public function add($autodate = true, $null_values = true)
    {
        $this->id_shop = ($this->id_shop) ? $this->id_shop : Context::getContext()->shop->id;
        return parent::add($autodate, $null_values);
    }

    public function getWhatsappChatByHook($id_hook, $active = false, $from_bo = false, $id_whatsappchatblock = false, $pos = false)
    {
        $context = Context::getContext();
        $shopID = ($this->id_shop) ? $this->id_shop : $context->shop->id;
        $langID = $context->language->id;
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . bqSQL($this->def['table']) . '` LEFT JOIN `'
            . _DB_PREFIX_ . bqSQL($this->def['table']) . '_lang` ON (`' . _DB_PREFIX_ . bqSQL($this->def['table'])
            . '`.`id_whatsappchatblock` = `' . _DB_PREFIX_ . bqSQL($this->def['table'])
            . '_lang`.`id_whatsappchatblock` AND `id_lang` = ' . (int)$langID.')'
            . ' WHERE `id_hook` = "' . bqSQL($id_hook) . '"'
            . (!$from_bo ? ' AND `id_shop` = ' . (int)$shopID : '')
            . ($id_whatsappchatblock ? ' AND `' . _DB_PREFIX_ . bqSQL($this->def['table']) . '`.`id_whatsappchatblock` = ' . (int)$id_whatsappchatblock : '')
            . ($active ? ' AND `active` = 1' : '')
            . ($pos ? ' AND `pos` = "'.$pos.'"' : '')
            . ' ORDER BY position DESC;'
        ;
        $configs = Db::getInstance()->executeS($sql);
        if ($configs === false) {
            return false;
        }
        if (isset($context->currency) && !empty($context->currency)) {
            $id_currency = $context->currency->id;
        }
        $id_customer = 0;
        if (isset($context->customer) && !empty($context->customer)) {
            $id_customer = $context->customer->id;
        }
        $id_country = 0;
        $id_state = 0;
        if (isset($context->cart) && !empty($context->cart)) {
            $id_address_delivery = $context->cart->id_address_delivery;
            $address = new Address($id_address_delivery);
            $id_country = $address->id_country;
            if ($id_country == 0) {
                $id_country = $context->country->id;
            }
            $id_state = $address->id_state;
        }
        $customer = new Customer((int)$id_customer);
        $customer_groups = $customer->getGroupsStatic((int)$customer->id);
        $country = new Country((int)$id_country);
        $zone = 0;
        if ($id_state > 0) {
            $zone = State::getIdZone($id_state);
        } elseif ($id_country != null and $id_country > 0) {
            $zone = $country->getIdZone($id_country);
        }
        $array_configurations_result = array();
        foreach ($configs as $conf) {
            if ((($conf['currencies'] == '' || $conf['currencies'] == 'all') &&
                ($conf['languages'] == '' || $conf['languages'] == 'all') &&
                ($conf['customer_groups'] == '' || $conf['customer_groups'] == 'all') &&
                ($conf['customers'] == '' || $conf['customers'] == 'all') &&
                ($conf['countries'] == '' || $conf['countries'] == 'all') &&
                ($conf['zones'] == '' || $conf['zones'] == 'all')) || $from_bo) {
                $array_configurations_result[] = $conf;
                continue;
            }
            if ($conf['customer_groups'] === 'all') {
                $conf['customer_groups'] = '';
            }
            if ($conf['currencies'] === 'all') {
                $conf['currencies'] = '';
            }
            if ($conf['languages'] === 'all') {
                $conf['languages'] = '';
            }
            if ($conf['customers'] === 'all') {
                $conf['customers'] = '';
            }
            if ($conf['countries'] === 'all') {
                $conf['countries'] = '';
            }
            if ($conf['zones'] === 'all') {
                $conf['zones'] = '';
            }
            $filter_currencies = true;
            if ($conf['currencies'] !== '') {
                $currencies_array = explode(';', $conf['currencies']);
                if (!in_array($id_currency, $currencies_array)) {
                    $filter_currencies = false;
                }
            }
            $filter_languages = true;
            if ($conf['languages'] !== '') {
                $languages_array = explode(';', $conf['languages']);
                if (!in_array($langID, $languages_array)) {
                    $filter_languages = false;
                }
            }
            $filter_groups = true;
            $filter_customers = true;
            if ($conf['customer_groups'] !== '' && $conf['customers'] == '') {
                $groups_array = explode(';', $conf['customer_groups']);
                foreach ($customer_groups as $group) {
                    if (!in_array($group, $groups_array)) {
                        $filter_groups = false;
                    } else {
                        $filter_groups = true;
                        break;
                    }
                }
                if (!$filter_groups) {
                    $filter_customers = false;
                }
            } elseif ($conf['customer_groups'] == '' && $conf['customers'] !== '') {
                $customers_array = explode(';', $conf['customers']);
                if (!in_array($id_customer, $customers_array)) {
                    $filter_customers = false;
                }
            } elseif ($conf['customer_groups'] !== '' && $conf['customers'] !== '') {
                $groups_array = explode(';', $conf['customer_groups']);
                foreach ($customer_groups as $group) {
                    if (!in_array($group, $groups_array)) {
                        $filter_groups = false;
                    } else {
                        $filter_groups = true;
                    }
                }
                if (!$filter_groups) {
                    $customers_array = explode(';', $conf['customers']);
                    if (!in_array($id_customer, $customers_array)) {
                        $filter_customers = false;
                    } else {
                        $filter_customers = true;
                    }
                } else {
                    $customers_array = explode(';', $conf['customers']);
                    if (!in_array($id_customer, $customers_array)) {
                        $filter_customers = false;
                    }
                }
            }
            if ($conf['filter_by_customer'] != '1') {
                $filter_customers = true;
            }
            $filter_countries = true;
            if ($conf['countries'] !== '') {
                $countries_array = explode(';', $conf['countries']);

                if (!in_array($country->id, $countries_array)) {
                    $filter_countries = false;
                }
            }
            $filter_zones = true;
            if ($conf['zones'] !== '') {
                $zones_array = explode(';', $conf['zones']);
                if (!in_array($zone, $zones_array)) {
                    $filter_zones = false;
                }
            }
            if ($filter_currencies && $filter_languages && $filter_groups && $filter_customers && $filter_countries && $filter_zones) {
                $array_configurations_result[] = $conf;
                continue;
            }
        }
        if (count($array_configurations_result) > 0) {
            return $array_configurations_result;
        }
        return false;
    }

    public static function getNbObjects()
    {
        $sql = 'SELECT COUNT(w.`id_whatsappchatblock`) AS nb
                FROM `' . _DB_PREFIX_ . 'whatsappchatblock` w
                WHERE `id_shop` = '.(int)Context::getContext()->shop->id;

        return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }
}
