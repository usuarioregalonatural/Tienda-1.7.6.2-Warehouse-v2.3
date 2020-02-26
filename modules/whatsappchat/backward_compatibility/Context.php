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

// Retro 1.3, 'class_exists' cause problem with autoload...
if (version_compare(_PS_VERSION_, '1.4', '<'))
{
    // Not exist for 1.3
    class Shop extends ObjectModel
    {
        public $id = 1;
        public $id_shop_group = 1;

        public function __construct()
        {
        }


        public static function getShops()
        {
            return array(
                array('id_shop' => 1, 'name' => 'Default shop')
            );
        }

        public static function getCurrentShop()
        {
                return 1;
        }
    }

    class Logger
    {
        public static function AddLog($message, $severity = 2)
        {
            $fp = fopen(dirname(__FILE__).'/../logs.txt', 'a+');
            fwrite($fp, '['.(int)$severity.'] '.Tools::safeOutput($message));
            fclose($fp);
        }
    }

}

// Not exist for 1.3 and 1.4
class Context
{
    /**
     * @var Context
     */
    protected static $instance;

    /**
     * @var Cart
     */
    public $cart;

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var Cookie
     */
    public $cookie;

    /**
     * @var Link
     */
    public $link;

    /**
     * @var Country
     */
    public $country;

    /**
     * @var Employee
     */
    public $employee;

    /**
     * @var Controller
     */
    public $controller;

    /**
     * @var Language
     */
    public $language;

    /**
     * @var Currency
     */
    public $currency;

    /**
     * @var AdminTab
     */
    public $tab;

    /**
     * @var Shop
     */
    public $shop;

    /**
     * @var Smarty
     */
    public $smarty;

    /**
     * @ var Mobile Detect
     */
    public $mobile_detect;

    /**
     * @var boolean|string mobile device of the customer
     */
    protected $mobile_device;

    public function __construct()
    {
        global $cookie, $cart, $smarty, $link;

        $this->tab = null;

        $this->cookie = $cookie;
        $this->cart = $cart;
        $this->smarty = $smarty;
        $this->link = $link;

        $this->controller = new ControllerBackwardModule();
        if (is_object($cookie))
        {
            $this->currency = new Currency((int)$cookie->id_currency);
            $this->language = new Language((int)$cookie->id_lang);
            $this->country = new Country((int)$cookie->id_country);
            $this->customer = new CustomerBackwardModule((int)$cookie->id_customer);
            $this->employee = new Employee((int)$cookie->id_employee);
        }
        else
        {
            $this->currency = null;
            $this->language = null;
            $this->country = null;
            $this->customer = null;
            $this->employee = null;
        }

        $this->shop = new ShopBackwardModule();

        if ((bool)Configuration::get('PS_MOBILE_DEVICE'))
            $this->mobile_detect = new Mobile_Detect();
    }

    public function getMobileDevice()
    {
        if (is_null($this->mobile_device))
        {
            $this->mobile_device = false;
            if ($this->checkMobileContext())
            {
                switch ((int)Configuration::get('PS_MOBILE_DEVICE'))
                {
                    case 0: // Only for mobile device
                        if ($this->mobile_detect->isMobile() && !$this->mobile_detect->isTablet())
                            $this->mobile_device = true;
                        break;
                    case 1: // Only for touchpads
                        if ($this->mobile_detect->isTablet() && !$this->mobile_detect->isMobile())
                            $this->mobile_device = true;
                        break;
                    case 2: // For touchpad or mobile devices
                        if ($this->mobile_detect->isMobile() || $this->mobile_detect->isTablet())
                            $this->mobile_device = true;
                        break;
                }
            }
        }

        return $this->mobile_device;
    }

    protected function checkMobileContext()
    {
        return isset($_SERVER['HTTP_USER_AGENT'])
            && (bool)Configuration::get('PS_MOBILE_DEVICE')
            && !Context::getContext()->cookie->no_mobile;
    }

    /**
     * Sets Mobile_Detect tool object
     *
     * @return Mobile_Detect
     */
    public function getMobileDetect()
    {
        if ($this->mobile_detect === null) {
            require_once('Mobile_Detect.php');
            $this->mobile_detect = new Mobile_Detect();
        }
        return $this->mobile_detect;
    }

    /**
     * Checks if visitor's device is a mobile device
     *
     * @return bool
     */
    public function isMobile()
    {
        if ($this->is_mobile === null) {
            $mobile_detect = $this->getMobileDetect();
            $this->is_mobile = $mobile_detect->isMobile();
        }
        return $this->is_mobile;
    }

    /**
     * Checks if visitor's device is a tablet device
     *
     * @return bool
     */
    public function isTablet()
    {
        if ($this->is_tablet === null) {
            $mobile_detect = $this->getMobileDetect();
            $this->is_tablet = $mobile_detect->isTablet();
        }
        return $this->is_tablet;
    }

    /**
     * Get a singleton context
     *
     * @return Context
     */
    public static function getContext()
    {
        if (!isset(self::$instance))
            self::$instance = new Context();
        return self::$instance;
    }

    /**
     * Clone current context
     *
     * @return Context
     */
    public function cloneContext()
    {
        return clone($this);
    }

    /**
     * @return int Shop context type (Shop::CONTEXT_ALL, etc.)
     */
    public static function shop()
    {
        if (!self::$instance->shop->getContextType())
            return ShopBackwardModule::CONTEXT_ALL;
        return self::$instance->shop->getContextType();
    }
}

/**
 * Class Shop for Backward compatibility
 */
class ShopBackwardModule extends Shop
{
    const CONTEXT_ALL = 1;

    public $id = 1;
    public $id_shop_group = 1;


    public function getContextType()
    {
        return ShopBackwardModule::CONTEXT_ALL;
    }

    // Simulate shop for 1.3 / 1.4
    public function getID()
    {
        return 1;
    }

    /**
     * Get shop theme name
     *
     * @return string
     */
    public function getTheme()
    {
        return _THEME_NAME_;
    }

    public function isFeatureActive()
    {
        return false;
    }
}

/**
 * Class Controller for a Backward compatibility
 * Allow to use method declared in 1.5
 */
class ControllerBackwardModule
{
    /**
     * @param $js_uri
     * @return void
     */
    public function addJS($js_uri)
    {
        Tools::addJS($js_uri);
    }

    /**
     * @param $css_uri
     * @param string $css_media_type
     * @return void
     */
    public function addCSS($css_uri, $css_media_type = 'all')
    {
        Tools::addCSS($css_uri, $css_media_type);
    }

    public function addJquery()
    {
        if (_PS_VERSION_ < '1.5')
            $this->addJS(_PS_JS_DIR_.'jquery/jquery-1.4.4.min.js');
        elseif (_PS_VERSION_ >= '1.5')
            $this->addJS(_PS_JS_DIR_.'jquery/jquery-1.7.2.min.js');
    }

}

/**
 * Class Customer for a Backward compatibility
 * Allow to use method declared in 1.5
 */
class CustomerBackwardModule extends Customer
{
    public $logged = false;
    /**
     * Check customer informations and return customer validity
     *
     * @since 1.5.0
     * @param boolean $with_guest
     * @return boolean customer validity
     */
    public function isLogged($with_guest = false)
    {
        if (!$with_guest && $this->is_guest == 1)
            return false;

        /* Customer is valid only if it can be load and if object password is the same as database one */
        if ($this->logged == 1 && $this->id && Validate::isUnsignedId($this->id) && Customer::checkPassword($this->id, $this->passwd))
            return true;
        return false;
    }
}
