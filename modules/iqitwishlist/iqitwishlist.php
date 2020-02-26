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

use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/src/IqitWishlistProduct.php';

class IqitWishlist extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';

    protected $config_form = false;
    public $cfgName;

    public function __construct()
    {
        $this->name = 'iqitwishlist';
        $this->version = '1.1.0';
        $this->author = 'iqit-commerce.com';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->tab = 'front_office_features';
        $this->controllers = array('view');

        parent::__construct();
        $this->displayName = $this->l('IQITWISHLIST');
        $this->description = $this->l('Allow customers to create wishlists which can share.');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->cfgName = 'iqitwish_';
        $this->defaults = array(
            'crosseling' => 0,
        );

    }

    public function install()
    {
        return (parent::install()
            && $this->setDefaults()
            && $this->registerHook('header')
            && $this->registerHook('displayNav2')
            && $this->registerHook('actionProductDelete')
            && $this->registerHook('displayAfterProductAddCartBtn')
            && $this->registerHook('displayCustomerAccount')
            && $this->registerHook('displayProductListFunctionalButtons')
            && $this->registerHook('displayBeforeBodyClosingTag')
            && $this->registerHook('registerGDPRConsent')
            && $this->registerHook('actionDeleteGDPRCustomer')
            && $this->registerHook('actionExportGDPRData')
            && $this->installSQL()
        );
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }
        return parent::uninstall() && $this->uninstallSQL();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->cfgName . $default, $value);
        }
        return true;
    }

    public function getContent()
    {
        if (Tools::isSubmit('submitModule')) {
            $this->postProcess();
        }
        $this->context->smarty->assign('module_dir', $this->_path);
        return $this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
        . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show crosseling'),
                        'name' => 'crosseling',
                        'is_bool' => true,
                        'desc' => $this->l('Show frequently bought togeter products with products added to wishlist'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function getConfigFormValues()
    {
        $var = array();
        foreach ($this->defaults as $default => $value) {
            $var[$default] = Configuration::get($this->cfgName  . $default);
        }
        return $var;
    }

    protected function postProcess()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->cfgName . $default, (Tools::getValue($default)));
        }
    }

    public function hookHeader()
    {
        $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-script', 'modules/'.$this->name.'/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);

        Media::addJsDef(array('iqitwishlist' => [
            'nbProducts' => (int) IqitWishlistProduct::getWishlistProductsNb((int)Context::getContext()->customer->id)
        ]));
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }
        $templateFile = 'my-account.tpl';
        if (preg_match('/^displayCustomerAccount\d*$/', $hookName)) {
            $templateFile = 'my-account.tpl';
        } elseif (preg_match('/^displayNav2\d*$/', $hookName) || preg_match('/^displayNav\d*$/', $hookName)) {
            $templateFile = 'display-nav.tpl';
        } elseif (preg_match('/^displayBeforeBodyClosingTag\d*$/', $hookName)) {
            $templateFile = 'display-modal.tpl';
        } elseif (preg_match('/^displayHeaderButtons\d*$/', $hookName)) {
            $templateFile = 'display-header-buttons.tpl';
        } elseif (preg_match('/^displayHeaderButtonsMobile\d*$/', $hookName)) {
            $templateFile = 'display-header-buttons-mobile.tpl';
        }  elseif (preg_match('/^displayProductAdditionalInfo\d*$/', $hookName) || preg_match('/^displayAfterProductAddCartBtn\d*$/', $hookName) ) {
            $templateFile = 'product-page.tpl';
        } elseif (preg_match('/^displayProductListFunctionalButtons\d*$/', $hookName)) {
            $templateFile = 'product-miniature.tpl';
        }

        $assign = $this->getWidgetVariables($hookName, $configuration);
        $this->smarty->assign($assign);
        return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile);
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayBeforeBodyClosingTag\d*$/', $hookName)) {
            if (!Context::getContext()->customer->isLogged()) {
                $form = new CustomerLoginForm(
                    $this->context->smarty,
                    $this->context,
                    $this->getTranslator(),
                    new CustomerLoginFormatter($this->getTranslator()),
                    $this->context->controller->getTemplateVarUrls()
                );

                $form->setAction('index.php?controller=authentication&back=my-account');

                return array(
                    'login_form' => $form->getProxy(),
                );
            }
        } elseif (preg_match('/^displayProductListFunctionalButtons\d*$/', $hookName)) {
            return array(
                'id_product_attribute' => $configuration['smarty']->tpl_vars['product']->value['id_product_attribute'],
                'id_product' => $configuration['smarty']->tpl_vars['product']->value['id_product'],
            );
        }
    }


    private function installSQL()
    {
          if (!file_exists(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }

        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }


    private function uninstallSQL()
    {
        if (!file_exists(dirname(__FILE__)  . self::UNINSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::UNINSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }

            
        unset($sql, $q, $replace);

        return true;
    }

    public function hookActionDeleteGDPRCustomer ($customer)
    {
        if (!empty($customer['id'])) {
            $sql = "DELETE FROM "._DB_PREFIX_."iqitwishlist_product WHERE id_customer = '".(int)pSQL($customer['id'])."'";
            if (Db::getInstance()->execute($sql)) {
                return json_encode(true);
            }
        }
    }

    public function hookActionExportGDPRData ($customer)
    {
        if (!empty($customer['id'])) {
            $sql = "SELECT id_product FROM "._DB_PREFIX_."iqitwishlist_product WHERE id_customer = '".(int)pSQL($customer['id'])."'";
            if ($res = Db::getInstance()->executeS($sql)) {

                $arr = array();
                foreach ($res as $key => $val) {
                    $arr[] = $val['id_product'];
                }
                $productsIds = implode(",",  $arr);

                $sql = 'SELECT p.`id_product` as "Id", p.`reference`, pl.`name`
		        FROM `'._DB_PREFIX_.'product` p
		        '.Shop::addSqlAssociation('product', 'p').'
		        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('pl').')
		        WHERE p.id_product IN ('.$productsIds.')';

                $items = Db::getInstance()->executeS($sql);

                return json_encode($items);
            }
        }

    }


    protected function getProducts($order)
    {
        $products = $order->getProducts();
        foreach ($products as &$product) {
            if ($product['image'] != null) {
                $name = 'product_mini_'.(int)$product['product_id'].(isset($product['product_attribute_id']) ? '_'.(int)$product['product_attribute_id'] : '').'.jpg';
                // generate image cache, only for back office
                $product['image_tag'] = ImageManager::thumbnail(_PS_IMG_DIR_.'p/'.$product['image']->getExistingImgPath().'.jpg', $name, 45, 'jpg');
                if (file_exists(_PS_TMP_IMG_DIR_.$name)) {
                    $product['image_size'] = getimagesize(_PS_TMP_IMG_DIR_.$name);
                } else {
                    $product['image_size'] = false;
                }
            }
        }
        ksort($products);
        return $products;
    }
}
