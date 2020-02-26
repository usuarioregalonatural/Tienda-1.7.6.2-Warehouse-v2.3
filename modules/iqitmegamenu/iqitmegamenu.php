<?php
/**
 * 2007-2016 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2007-2016 IQIT-COMMERCE.COM
 * @license   GNU General Public License version 2
 *
 * You can not resell or redistribute this software.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

include_once _PS_MODULE_DIR_ . 'iqitmegamenu/models/IqitMenuTab.php';
include_once _PS_MODULE_DIR_ . 'iqitmegamenu/models/IqitMenuHtml.php';
include_once _PS_MODULE_DIR_ . 'iqitmegamenu/models/IqitMenuLinks.php';


class IqitMegaMenu extends Module implements WidgetInterface
{
    protected $config_form = false;
    private $_html = '';
    private $user_groups;
    private $hor_sm_order;

    private $pattern = '/^([A-Z_]*)[0-9]+/';
    private $spacer_size = '5';
    private $verticalPosition;
    private $sidebarHeader;

    public function __construct()
    {
        $this->name = 'iqitmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.2.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->need_instance = 0;
        $this->module_key = '54999588debd277b5118f60eead75dfe';
        $this->iqitdevmode = false;
        $this->iqitTheme = false;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('IQITMEGAMENU -  most powerfull navigation for Prestashop');
        $this->description = $this->l('With drag and drop submenu creator');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->config_name = 'iqitmegamenu';
        $this->defaults_mobile = array(
            'mobile_menu' => 'HOME0,CAT3,CAT26',
            'mobile_menu_depth' => 3,
        );
        $this->defaults_horizontal = array(
            'hor_sm_order' => 0,
        );
        $this->defaults_vertical = array();

        $this->verticalPosition = Configuration::get('iqitthemeed_vm_position');
        $this->sidebarHeader = false;
        $h_layout = Configuration::get('iqitthemeed_h_layout');
        if ($h_layout == 6 || $h_layout == 7) {
            $this->verticalPosition = 'leftColumn';
            $this->sidebarHeader = true;
        }

    }

    public function install()
    {
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayMainMenu') &&
            $this->registerHook('displayVerticalMenuElementor') &&
            $this->registerHook('displayVerticalMenu') &&
            $this->registerHook('actionObjectCategoryUpdateAfter') &&
            $this->registerHook('actionObjectCategoryDeleteAfter') &&
            $this->registerHook('actionObjectCategoryAddAfter') &&
            $this->registerHook('actionObjectCmsUpdateAfter') &&
            $this->registerHook('actionObjectCmsDeleteAfter') &&
            $this->registerHook('actionObjectCmsAddAfter') &&
            $this->registerHook('actionObjectSupplierUpdateAfter') &&
            $this->registerHook('actionObjectSupplierDeleteAfter') &&
            $this->registerHook('actionObjectSupplierAddAfter') &&
            $this->registerHook('actionObjectManufacturerUpdateAfter') &&
            $this->registerHook('actionObjectManufacturerDeleteAfter') &&
            $this->registerHook('actionObjectManufacturerAddAfter') &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('actionObjectProductDeleteAfter') &&
            $this->registerHook('actionObjectProductAddAfter') &&
            $this->registerHook('categoryUpdate') &&
            $this->registerHook('actionShopDataDuplication') &&
            $this->createTables()
        ) {
            $this->installSamples();
            $this->setDefaults();
            $this->generateCss();
            return true;
        } else {
            return false;
        }
    }

    public function uninstall()
    {
        foreach ($this->defaults_mobile as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }
        foreach ($this->defaults_horizontal as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }
        foreach ($this->defaults_vertical as $default => $value) {
            Configuration::deleteByName($this->config_name . '_' . $default);
        }
        return parent::uninstall() && $this->deleteTables();
    }

    protected function createTables()
    {
        /* tabs */
        $res = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_tabs_shop` (
				`id_tab` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_tab`, `id_shop`)
				) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');

        /* tabs configuration */
        $res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_tabs` (
				`id_tab` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`menu_type` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`active_label` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`position` int(10) unsigned NOT NULL DEFAULT \'0\',
				`url_type` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`id_url` varchar(64) NULL,
				`icon_type` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`icon_class` varchar(64) NULL,
				`icon` varchar(255) NULL,
				`legend_icon` varchar(64) NULL,
				`new_window` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`float` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`bg_color` varchar(64) NULL,
				`txt_color` varchar(64) NULL,
				`h_bg_color` varchar(64) NULL,
				`h_txt_color` varchar(64) NULL,
				`labelbg_color` varchar(64) NULL,
				`labeltxt_color` varchar(64) NULL,
				`submenu_content` text NULL,
				`submenu_type` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`submenu_width` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
				`submenu_bg_color` varchar(64) NULL,
				`submenu_image` varchar(255) NULL,
				`submenu_repeat` tinyint(1) unsigned NULL DEFAULT \'0\',
				`submenu_bg_position` tinyint(1) unsigned NULL DEFAULT \'0\',
				`submenu_link_color` varchar(64) NULL,
				`submenu_hover_color` varchar(64) NULL,
				`submenu_title_color` varchar(64) NULL,
				`submenu_title_colorh` varchar(64) NULL,
				`submenu_titleb_color` varchar(64) NULL,
				`submenu_border_t` varchar(64) NULL,
				`submenu_border_r` varchar(64) NULL,
				`submenu_border_b` varchar(64) NULL,
				`submenu_border_l` varchar(64) NULL,
				`submenu_border_i` varchar(64) NULL,
                `group_access` TEXT NOT NULL,
				PRIMARY KEY (`id_tab`)
				) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        /* tabs lang configuration */
        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_tabs_lang` (
		`id_tab` int(10) unsigned NOT NULL,
		`id_lang` int(10) unsigned NOT NULL,
		`title` varchar(255) NOT NULL,
		`label` varchar(255) NULL,
		`url` varchar(255) NULL,
		PRIMARY KEY (`id_tab`,`id_lang`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        /* custom links */
        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmenulinks` (
		`id_iqitmenulinks` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`id_shop` INT(11) UNSIGNED NOT NULL,
		`new_window` TINYINT( 1 ) NOT NULL,
		INDEX (`id_shop`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        /* custom links lang */
        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmenulinks_lang` (
		`id_iqitmenulinks` INT(11) UNSIGNED NOT NULL,
		`id_lang` INT(11) UNSIGNED NOT NULL,
		`id_shop` INT(11) UNSIGNED NOT NULL,
		`label` VARCHAR( 128 ) NOT NULL ,
		`link` VARCHAR( 128 ) NOT NULL ,
		INDEX ( `id_iqitmenulinks` , `id_lang`, `id_shop`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        /* custom html */
        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_html` (
		`id_html` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`id_shop` INT(11) UNSIGNED NOT NULL,
		INDEX (`id_html`, `id_shop`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_htmlc` (
		`id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`title` varchar(255) NOT NULL ,
		PRIMARY KEY (`id_html`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        /* custom html lang */
        $res &= Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_htmlc_lang` (
		`id_html` INT(11) UNSIGNED NOT NULL,
		`id_lang` INT(11) UNSIGNED NOT NULL,
		`id_shop` INT(11) UNSIGNED NOT NULL,
		`html` text NULL,
		INDEX ( `id_html` , `id_lang`, `id_shop`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
');

        return $res;
    }

    /**
     * deletes tables
     */
    protected function deleteTables()
    {
        return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'iqitmegamenu_tabs_shop`, `' . _DB_PREFIX_ . 'iqitmegamenu_tabs`, `' . _DB_PREFIX_ . 'iqitmegamenu_tabs_lang`, `' . _DB_PREFIX_ . 'iqitmenulinks`, `' . _DB_PREFIX_ . 'iqitmenulinks_lang`, `' . _DB_PREFIX_ . 'iqitmegamenu_html`, `' . _DB_PREFIX_ . 'iqitmegamenu_htmlc`, `' . _DB_PREFIX_ . 'iqitmegamenu_htmlc_lang`;
			');
    }

    public function setDefaults()
    {
        foreach ($this->defaults_mobile as $default => $value) {
            Configuration::updateValue($this->config_name . '_' . $default, $value);
        }
        foreach ($this->defaults_horizontal as $default => $value) {
            Configuration::updateValue($this->config_name . '_' . $default, $value);
        }
        foreach ($this->defaults_vertical as $default => $value) {
            Configuration::updateValue($this->config_name . '_' . $default, $value);
        }
    }

    public function getContent()
    {

        if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name) {
            return;
        }
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return $this->getWarningMultishopHtml();
        }
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/jquery.auto-complete.js');
        $this->context->controller->addJS($this->_path . 'views/js/back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        $this->context->controller->addJS($this->_path . 'views/js/fontawesome-iconpicker.min.js');
        $this->context->controller->addCSS($this->_path . 'views/css/fontawesome-iconpicker.min.css');
        $this->context->controller->addCSS($this->_path . 'views/css/font-awesome.min.css');

        $base_url = Tools::getHttpHost(true);  // DON'T TOUCH (base url (only domain) of site (without final /)).
        $base_url = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? $base_url : str_replace('https', 'http', $base_url);

        Media::addJsDef(array(
            'iqitsearch_url' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name,
            'iqitBaseUrl'  => Tools::safeOutput($base_url)
        ));

        $languages = $this->context->controller->getLanguages();
        $default_language = (int)Configuration::get('PS_LANG_DEFAULT');

        $labels = Tools::getValue('label') ? array_filter(Tools::getValue('label'), 'strlen') : array();
        $links_label = Tools::getValue('link') ? array_filter(Tools::getValue('link'), 'strlen') : array();

        if (Tools::isSubmit('addTab') || (Tools::isSubmit('id_tab') && !Tools::isSubmit('submitAddTab') && IqitMenuTab::tabExists((int)Tools::getValue('id_tab')))) {
            return $this->_html .= $this->renderAddForm();
        } elseif (Tools::isSubmit('submitAddTab') || Tools::isSubmit('delete_id_tab') || Tools::isSubmit('duplicateTabC')) {
            if (!Tools::isSubmit('back_to_configuration')) {
                if ($this->_postValidation()) {
                    $this->_postProcess();
                }
            }

            $this->generateCss();
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('addCustomHtml') || (Tools::isSubmit('id_html') && !Tools::isSubmit('submitAddHtml') && IqitMenuHtml::htmlExists((int)Tools::getValue('id_html')))) {
            return $this->_html .= $this->renderAddHtmlForm();
        } elseif (Tools::isSubmit('submitAddHtml') || Tools::isSubmit('delete_id_html')) {
            if (!Tools::isSubmit('back_to_configuration')) {
                if ($this->_postValidationHtml()) {
                    $this->_postProcessHtml();
                }
            }
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('exportConfiguration')) {
            $var = array();

            foreach ($this->defaults_horizontal as $default => $value) {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }
            foreach ($this->defaults_vertical as $default => $value) {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }
            foreach ($this->defaults_mobile as $default => $value) {
                if ($default == 'mobile_menu') {
                    continue;
                } else {
                    $var[$default] = Configuration::get($this->config_name . '_' . $default);
                }
            }

            $file_name = 'iqitmegamenu_config_' . time() . '.csv';
            $fd = fopen($this->getLocalPath() . $file_name, 'w+');
            file_put_contents($this->getLocalPath() . 'export/' . $file_name, print_r(serialize($var), true));
            fclose($fd);
            Tools::redirect(_PS_BASE_URL_ . __PS_BASE_URI__ . 'modules/' . $this->name . '/export/' . $file_name);
        } elseif (Tools::isSubmit('importConfiguration')) {
            if (isset($_FILES['uploadConfig']) && isset($_FILES['uploadConfig']['tmp_name'])) {
                $str = Tools::file_get_contents($_FILES['uploadConfig']['tmp_name']);
                $arr = unserialize($str);
                foreach ($arr as $default => $value) {
                    Configuration::updateValue($this->config_name . '_' . $default, $value);
                }
                $this->generateCss();
                $this->_html .= $this->displayConfirmation($this->l('Configuration imported'));
            } else {
                $this->_html .= $this->displayError($this->l('No config file'));
            }
        } elseif (Tools::isSubmit('exportTabs')) {
            $var = IqitMenuTab::getAllShopTabs();

            $file_name = 'iqitmegamenu_tabs_' . time() . '.csv';
            $fd = fopen($this->getLocalPath() . $file_name, 'w+');
            file_put_contents($this->getLocalPath() . 'export/' . $file_name, print_r(serialize($var), true));
            fclose($fd);
            Tools::redirect(_PS_BASE_URL_ . __PS_BASE_URI__ . 'modules/' . $this->name . '/export/' . $file_name);
        } elseif (Tools::isSubmit('importTabs')) {
            if (isset($_FILES['uploadTabs']) && isset($_FILES['uploadTabs']['tmp_name'])) {
                $str = Tools::file_get_contents($_FILES['uploadTabs']['tmp_name']);
                $arr = unserialize($str);

                $default_language = Configuration::get('PS_LANG_DEFAULT');

                foreach ($arr as $id_tab => $tab) {
                    if (Validate::isLoadedObject($tab)) {
                        $tab->id_shop = (int)Context::getContext()->shop->id;
                        $tab->id_shop_list = (int)Context::getContext()->shop->id;


                        if (!isset($tab->title[$default_language])){
                            $tab->title[$default_language] = 'Tab name ' . $tab->id;

                        }

                        $tab->add();
                    }
                }

                $this->_html .= $this->displayConfirmation($this->l('Tabs imported'));
            } else {
                $this->_html .= $this->displayError($this->l('No tabs data file'));
            }
        } elseif (Tools::isSubmit('submitHorizonalMenuConfig')) {
            foreach ($this->defaults_horizontal as $default => $value) {
                if ($default == 'hor_search_border' || $default == 'hor_titlep_borders' || $default == 'hor_border_top' || $default == 'hor_border_bottom' || $default == 'hor_border_sides' || $default == 'hor_border_inner' || $default == 'hor_sm_border_top' || $default == 'hor_sm_border_bottom' || $default == 'hor_sm_border_sides' || $default == 'hor_sm_border_inner') {
                    Configuration::updateValue($this->config_name . '_' . $default,
                        Tools::getValue($default . '_width') . ';' . Tools::getValue($default . '_type') . ';' . Tools::getValue($default . '_color'));
                } else {
                    Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
                }
            }

            $this->generateCss();
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('submitVerticalMenuConfig')) {
            foreach ($this->defaults_vertical as $default => $value) {
                if ($default == 'ver_border_top' || $default == 'ver_border_bottom' || $default == 'ver_border_sides' || $default == 'ver_border_inner') {
                    Configuration::updateValue($this->config_name . '_' . $default,
                        Tools::getValue($default . '_width') . ';' . Tools::getValue($default . '_type') . ';' . Tools::getValue($default . '_color'));
                } else {
                    Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
                }
            }
            $this->generateCss();
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('submitMobileMenu')) {
            $errors_update_shops = array();
            $items = Tools::getValue('items');
            $shops = Shop::getContextListShopID();
            foreach ($shops as $shop_id) {
                $shop_group_id = Shop::getGroupFromShop($shop_id);
                $updated = true;

                if (count($shops) == 1) {
                    if (is_array($items) && count($items)) {
                        $updated = Configuration::updateValue($this->config_name . '_mobile_menu',
                            (string)implode(',', $items), false, (int)$shop_group_id, (int)$shop_id);
                    } else {
                        $updated = Configuration::updateValue($this->config_name . '_mobile_menu', '', false,
                            (int)$shop_group_id, (int)$shop_id);
                    }
                }

                if (!$updated) {
                    $shop = new Shop($shop_id);
                    $errors_update_shops[] = $shop->name;
                }
            }

            foreach ($this->defaults_mobile as $default => $value) {
                if ($default == 'hor_mb_border' || $default == 'hor_mb_c_border' || $default == 'hor_mb_c_borderi') {
                    Configuration::updateValue($this->config_name . '_' . $default,
                        Tools::getValue($default . '_width') . ';' . Tools::getValue($default . '_type') . ';' . Tools::getValue($default . '_color'));
                } elseif ($default == 'mobile_menu') {
                    continue;
                } else {
                    Configuration::updateValue($this->config_name . '_' . $default, (Tools::getValue($default)));
                }
            }

            if (!count($errors_update_shops)) {
                $this->_html .= $this->displayConfirmation($this->l('The settings have been updated.'));
            } else {
                $this->_html .= $this->displayError(sprintf($this->l('Unable to update settings for the following shop(s): %s'),
                    implode(', ', $errors_update_shops)));
            }
            $this->generateCss();
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('submitBlocktopmenuLinks') || (Tools::isSubmit('updateiqitmenulinks') && Tools::getValue('updatelink'))) {
            $errors_add_link = array();

            foreach ($languages as $key => $val) {
                $links_label[$val['id_lang']] = Tools::getValue('link_' . (int)$val['id_lang']);
                $labels[$val['id_lang']] = Tools::getValue('label_' . (int)$val['id_lang']);
            }

            $count_links_label = count($links_label);
            $count_label = count($labels);

            if ($count_links_label || $count_label) {
                if (!$count_links_label) {
                    $this->_html .= $this->displayError($this->l('Please complete the "Link" field.'));
                } elseif (!$count_label) {
                    $this->_html .= $this->displayError($this->l('Please add a label.'));
                } elseif (!isset($labels[$default_language])) {
                    $this->_html .= $this->displayError($this->l('Please add a label for your default language.'));
                } else {
                    $shops = Shop::getContextListShopID();

                    foreach ($shops as $shop_id) {
                        if (Tools::isSubmit('updateiqitmenulinks')) {
                            $added = IqitMenuLinks::update($links_label, $labels, (int)$shop_id,
                                Tools::getValue('id_iqitmenulinks'), Tools::getValue('new_window', 0));
                        } else {
                            $added = IqitMenuLinks::add($links_label, $labels, (int)$shop_id,
                                Tools::getValue('new_window', 0));
                        }

                        if (!$added) {
                            $shop = new Shop($shop_id);
                            $errors_add_link[] = $shop->name;
                        }
                    }

                    if (!count($errors_add_link)) {
                        $this->_html .= $this->displayConfirmation($this->l('The link has been added.'));
                    } else {
                        $this->_html .= $this->displayError(sprintf($this->l('Unable to add link for the following shop(s): %s'),
                            implode(', ', $errors_add_link)));
                    }
                }
            }
            $this->clearMenuCache();
        } elseif (Tools::isSubmit('deleteiqitmenulinks')) {
            $errors_delete_link = array();
            $id_iqitmenulinks = Tools::getValue('id_iqitmenulinks', 0);
            $shops = Shop::getContextListShopID();

            foreach ($shops as $shop_id) {
                $deleted = IqitMenuLinks::remove($id_iqitmenulinks, (int)$shop_id);
                Configuration::updateValue($this->config_name . '_mobile_menu',
                    str_replace(array('LNK' . $id_iqitmenulinks . ',', 'LNK' . $id_iqitmenulinks), '',
                        Configuration::get($this->config_name . '_mobile_menu')));

                if (!$deleted) {
                    $shop = new Shop($shop_id);
                    $errors_delete_link[] = $shop->name;
                }
            }

            if (!count($errors_delete_link)) {
                $this->_html .= $this->displayConfirmation($this->l('The link has been removed.'));
            } else {
                $this->_html .= $this->displayError(sprintf($this->l('Unable to remove link for the following shop(s): %s'),
                    implode(', ', $errors_delete_link)));
            }

            $this->clearMenuCache();
        }

        $this->_html .= '<div class="list-wrapper list-wrapper-horizontal">' . $this->renderTabsLinks(1) . '</div>';
        $this->_html .= '<div class="list-wrapper list-wrapper-vertical">' . $this->renderTabsLinks(2) . '</div>';
        $this->_html .= '<div class="list-wrapper list-wrapper-submenutabs">' . $this->renderTabsLinks(3) . '</div>';
        $this->_html .= '<div class="list-wrapper list-wrapper-html">' . $this->renderHtmlContents() . '</div>';
        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    private function _postValidation()
    {
        $errors = array();

        /* Validation for tab */
        if (Tools::isSubmit('submitAddTab')) {
            /* If edit : checks id_tab */
            if (Tools::isSubmit('id_tab')) {
                if (!Validate::isInt(Tools::getValue('id_tab')) && !IqitMenuTab::tabExists(Tools::getValue('id_tab'))) {
                    $errors[] = $this->l('Invalid id_tab');
                }
            }
            if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0)) {
                $errors[] = $this->l('Invalid tab position.');
            }

            /* Checks title/description/*/
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                if (Tools::strlen(Tools::getValue('title_' . $language['id_lang'])) > 255) {
                    $errors[] = $this->l('The title is too long.');
                }
                if (Tools::strlen(Tools::getValue('label_' . $language['id_lang'])) > 255) {
                    $errors[] = $this->l('The label is too long.');
                }
            }
            /* Checks title/description for default lang */
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            if (Tools::strlen(Tools::getValue('title_' . $id_lang_default)) == 0) {
                $errors[] = $this->l('The title is not set.');
            }
        } elseif (Tools::isSubmit('delete_id_tab') && (!Validate::isInt(Tools::getValue('delete_id_tab')) || !IqitMenuTab::tabExists((int)Tools::getValue('delete_id_tab')))) {
            $errors[] = $this->l('Invalid id_tab');
        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
            return false;
        }
        return true;
    }

    private function _postProcess()
    {
        $errors = array();

        /* Processes tab */
        if (Tools::isSubmit('submitAddTab')) {
            /* Sets ID if needed */
            if (Tools::getValue('id_tab')) {
                $tab = new IqitMenuTab((int)Tools::getValue('id_tab'));
                if (!Validate::isLoadedObject($tab)) {
                    $this->_html .= $this->displayError($this->l('Invalid id_tab'));

                    return false;
                }
            } else {
                $tab = new IqitMenuTab();
                $tab->menu_type = Tools::getValue('menu_type');
                $tab->position = IqitMenuTab::getNextPosition(Tools::getValue('menu_type'));
            }

            $tab->active = Tools::getValue('active');
            $tab->active_label = Tools::getValue('active_label');

            $tab->url_type = Tools::getValue('url_type');
            $tab->id_url = Tools::getValue('id_url');
            $tab->icon_type = Tools::getValue('icon_type');
            $tab->icon = Tools::getValue('icon');
            $tab->icon_class = Tools::getValue('icon_class');
            $tab->legend_icon = Tools::getValue('legend_icon');
            $tab->new_window = Tools::getValue('new_window');
            $tab->float = Tools::getValue('float');

            //colors
            $tab->bg_color = Tools::getValue('bg_color');
            $tab->txt_color = Tools::getValue('txt_color');
            $tab->h_bg_color = Tools::getValue('h_bg_color');
            $tab->h_txt_color = Tools::getValue('h_txt_color');
            $tab->labelbg_color = Tools::getValue('labelbg_color');
            $tab->labeltxt_color = Tools::getValue('labeltxt_color');

            //submenu
            $submenu_type = Tools::getValue('submenu_type');

            $tab->submenu_type = $submenu_type;
            $tab->submenu_width = Tools::getValue('submenu_width');
            $tab->submenu_bg_color = Tools::getValue('submenu_bg_color');
            $tab->submenu_image = Tools::getValue('submenu_image');
            $tab->submenu_repeat = Tools::getValue('submenu_repeat');
            $tab->submenu_bg_position = Tools::getValue('submenu_bg_position');
            $tab->submenu_link_color = Tools::getValue('submenu_link_color');
            $tab->submenu_hover_color = Tools::getValue('submenu_hover_color');

            $tab->submenu_title_color = Tools::getValue('submenu_title_color');
            $tab->submenu_title_colorh = Tools::getValue('submenu_title_colorh');
            $tab->submenu_titleb_color = Tools::getValue('submenu_titleb_color');
            $tab->submenu_border_t = Tools::getValue('submenu_border_t');
            $tab->submenu_border_r = Tools::getValue('submenu_border_r');
            $tab->submenu_border_b = Tools::getValue('submenu_border_b');
            $tab->submenu_border_l = Tools::getValue('submenu_border_l');
            $tab->submenu_border_i = Tools::getValue('submenu_border_i');

            $id_shop_list = Tools::getValue('checkBoxShopAsso_iqitmegamenu_tabs');

            if (isset($id_shop_list) && !empty($id_shop_list)) {
                $tab->id_shop_list = $id_shop_list;
            } else {
                $tab->id_shop_list = (int)Context::getContext()->shop->id;
            }

            $groups = Group::getGroups($this->context->language->id);
            $groupBox = Tools::getValue('groupBox', array());
            $group_access = array();

            if (!$groupBox) {
                foreach ($groups as $group) {
                    $group_access[$group['id_group']] = false;
                }
            } else {
                foreach ($groups as $group) {
                    $group_access[$group['id_group']] = in_array($group['id_group'], $groupBox);
                }
            }

            $tab->group_access = serialize($group_access);

            $tab->submenu_content = '';

            if ($submenu_type == 1) {
                if (is_array(Tools::getValue('items')) && count(Tools::getValue('items'))) {
                    $tab->submenu_content = (string)implode(',', Tools::getValue('items'));
                } else {
                    $tab->submenu_content = '';
                }
            }

            if ($submenu_type == 2) {
                $tab->submenu_content = urldecode(Tools::getValue('submenu-elements'));
            }

            /* Sets each langue fields */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                $tab->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
                $tab->label[$language['id_lang']] = Tools::getValue('label_' . $language['id_lang']);
                $tab->url[$language['id_lang']] = Tools::getValue('url_' . $language['id_lang']);
            }

            /* Processes if no errors  */
            if (!$errors) {
                /* Adds */
                if (!Tools::getValue('id_tab')) {
                    if (!$tab->add()) {
                        $errors[] = $this->displayError($this->l('The tab could not be added.'));
                    }
                } elseif (!$tab->update()) {
                    $errors[] = $this->displayError($this->l('The tab could not be updated.'));
                }

                $this->clearMenuCache();
            }
        } elseif (Tools::isSubmit('delete_id_tab')) {
            $tab = new IqitMenuTab((int)Tools::getValue('delete_id_tab'));
            $res = $tab->delete();
            $this->clearMenuCache();
            if (!$res) {
                $this->_html .= $this->displayError('Could not delete.');
            } else {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                        true) . '&conf=1&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
            }
        } elseif (Tools::isSubmit('duplicateTabC')) {
            $this->duplicateTab((int)Tools::getValue('duplicateTabC'));
            $this->generateCss();
            $this->clearMenuCache();
        }

        $this->generateCss();
        $this->clearMenuCache();

        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
        } elseif (Tools::isSubmit('submitAddTab') && Tools::getValue('id_tab')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                    true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        } elseif (Tools::isSubmit('submitAddTab')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                    true) . '&conf=3&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        }
    }

    private function _postValidationHtml()
    {
        $errors = array();
        if (Tools::isSubmit('submitAddHtml')) {
            if (Tools::isSubmit('id_html')) {
                if (!Validate::isInt(Tools::getValue('id_html')) && !IqitMenuHtml::htmlExists(Tools::getValue('id_html'))) {
                    $errors[] = $this->l('Invalid id_html');
                }
            }
            if (!Tools::strlen(Tools::getValue('title'))) {
                $errors[] = $this->l('Title is not set');
            }
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            if (Tools::strlen(Tools::getValue('html_' . $id_lang_default)) == 0) {
                $errors[] = $this->l('The html is not set');
            }
        } elseif (Tools::isSubmit('delete_id_html') && (!Validate::isInt(Tools::getValue('delete_id_html')) || !IqitMenuHtml::htmlExists((int)Tools::getValue('delete_id_html')))) {
            $errors[] = $this->l('Invalid id_html');
        }
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));

            return false;
        }
        return true;
    }

    private function _postProcessHtml()
    {
        $errors = array();

        /* Processes tab */
        if (Tools::isSubmit('submitAddHtml')) {
            if (Tools::getValue('id_html')) {
                $tab = new IqitMenuHtml((int)Tools::getValue('id_html'));
                if (!Validate::isLoadedObject($tab)) {
                    $this->_html .= $this->displayError($this->l('Invalid id_tab'));

                    return false;
                }
            } else {
                $tab = new IqitMenuHtml();
            }

            $tab->title = Tools::getValue('title');

            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                $tab->html[$language['id_lang']] = Tools::getValue('html_' . $language['id_lang']);
            }

            if (!$errors) {
                if (!Tools::getValue('id_html')) {
                    if (!$tab->add()) {
                        $errors[] = $this->displayError($this->l('The html content could not be added.'));
                    }
                } elseif (!$tab->update()) {
                    $errors[] = $this->displayError($this->l('The html could not be updated.'));
                }

                $this->clearMenuCache();
            }
        } elseif (Tools::isSubmit('delete_id_html')) {
            $tab = new IqitMenuHtml((int)Tools::getValue('delete_id_html'));
            $res = $tab->delete();
            $this->clearMenuCache();
            if (!$res) {
                $this->_html .= $this->displayError('Could not delete.');
            } else {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                        true) . '&conf=1&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
            }
        }

        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
        } elseif (Tools::isSubmit('submitAddTab') && Tools::getValue('id_tab')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                    true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        } elseif (Tools::isSubmit('submitAddTab')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules',
                    true) . '&conf=3&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        }
    }

    public function renderAddForm()
    {
        if (Tools::getValue('menu_type') == 3) {
            $options_type = array(
                array(
                    'id_option' => 2,
                    'name' => $this->l('Grid submenu'),
                ),
            );
        } else {
            $options_type = array(
                array(
                    'id_option' => 2,
                    'name' => $this->l('Grid submenu'),
                ),
                array(
                    'id_option' => 1,
                    'name' => $this->l('Predefinied tabs'),
                ),
                array(
                    'id_option' => 0,
                    'name' => $this->l('Hidden'),
                ),
            );
        }

        $columns_width = array(
            array(
                'id_option' => 1,
                'name' => $this->l('1/12'),
            ),
            array(
                'id_option' => 2,
                'name' => $this->l('2/12'),
            ),
            array(
                'id_option' => 3,
                'name' => $this->l('3/12'),
            ),
            array(
                'id_option' => 4,
                'name' => $this->l('4/12'),
            ),
            array(
                'id_option' => 5,
                'name' => $this->l('5/12'),
            ),
            array(
                'id_option' => 6,
                'name' => $this->l('6/12'),
            ),
            array(
                'id_option' => 7,
                'name' => $this->l('7/12'),
            ),
            array(
                'id_option' => 8,
                'name' => $this->l('8/12'),
            ),
            array(
                'id_option' => 9,
                'name' => $this->l('9/12'),
            ),
            array(
                'id_option' => 10,
                'name' => $this->l('10/12'),
            ),
            array(
                'id_option' => 11,
                'name' => $this->l('11/12'),
            ),
            array(
                'id_option' => 12,
                'name' => $this->l('12/12'),
            ),
        );

        $unidentified = new Group(Configuration::get('PS_UNIDENTIFIED_GROUP'));
        $guest = new Group(Configuration::get('PS_GUEST_GROUP'));
        $default = new Group(Configuration::get('PS_CUSTOMER_GROUP'));

        $unidentified_group_information = sprintf($this->l('%s - All people without a valid customer account.'),
            '<b>' . $unidentified->name[$this->context->language->id] . '</b>');
        $guest_group_information = sprintf($this->l('%s - Customer who placed an order with the guest checkout.'),
            '<b>' . $guest->name[$this->context->language->id] . '</b>');
        $default_group_information = sprintf($this->l('%s - All people who have created an account on this site.'),
            '<b>' . $default->name[$this->context->language->id] . '</b>');

        $fields_form = array(
            'form' => array(
                'tab_name' => 'main_tab',
                'legend' => array(
                    'title' => $this->l('Add tab'),
                    'icon' => 'icon-cogs',
                    'id' => 'fff',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Active'),
                        'name' => 'active',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'desc' => $this->l('Main title of tab. If you want to manually indicate new line put /n '),
                        'lang' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Hide title'),
                        'desc' => $this->l('Useful if you want to create tab like home link'),
                        'name' => 'active_label',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Icon type'),
                        'name' => 'icon_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Font icon class name'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Image icon'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'icon_selector',
                        'label' => $this->l('Icon class'),
                        'name' => 'icon_class',
                        'desc' => $this->l('For example: "fa-star". You can use font awesome icons here'),
                        'preffix_wrapper' => 'icon-class-wrapper',
                        'wrapper_hidden' => true,
                        'suffix_wrapper' => true,
                    ),
                    array(
                        'type' => 'image_upload',
                        'label' => $this->l('Icon'),
                        'name' => 'icon',
                        'preffix_wrapper' => 'image-icon-wrapper',
                        'wrapper_hidden' => true,
                        'suffix_wrapper' => true,
                    ),

                    array(
                        'type' => 'select',
                        'label' => $this->l('Url type'),
                        'name' => 'url_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('No url'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Custom url'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Content url(category, cms, etc)'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'custom_select',
                        'label' => $this->l('System url'),
                        'name' => 'id_url',
                        'choices' => $this->renderChoicesSelect(true, 'id_url'),
                        'preffix_wrapper' => 'system-url-wrapper',
                        'wrapper_hidden' => true,
                        'suffix_wrapper' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Custom url'),
                        'name' => 'url',
                        'desc' => $this->l('Should be full url with http:// prefix'),
                        'lang' => true,
                        'preffix_wrapper' => 'custom-url-wrapper',
                        'wrapper_hidden' => true,
                        'suffix_wrapper' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Legend'),
                        'name' => 'label',
                        'desc' => $this->l('Additional text showed in tooltip'),
                        'lang' => true,
                    ),
                    array(
                        'type' => 'icon_selector',
                        'label' => $this->l('Legend icon class'),
                        'name' => 'legend_icon',
                        'desc' => $this->l('For example: "fa-star". You can use font awesome icons here'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('New window'),
                        'name' => 'new_window',
                        'hide' => (Tools::getValue('menu_type') == 3 ? true : false),
                        'is_bool' => true,
                        'desc' => $this->l('Open link in new window'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Float right'),
                        'hide' => (Tools::getValue('menu_type') == 3 ? true : false),
                        'name' => 'float',
                        'is_bool' => true,
                        'desc' => $this->l('Position menu on right side of menu. If center option of menu is enabled it do not take effect'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main link background color'),
                        'name' => 'bg_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main link text color'),
                        'name' => 'txt_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main link hover background color'),
                        'name' => 'h_bg_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main link hover text color'),
                        'name' => 'h_txt_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Legend background color'),
                        'name' => 'labelbg_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Legend text color'),
                        'name' => 'labeltxt_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Submenu type and status'),
                        'name' => 'submenu_type',
                        'options' => array(
                            'query' => $options_type,
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Submenu width'),
                        'name' => 'submenu_width',
                        'hide' => (Tools::getValue('menu_type') == 3 ? true : false),
                        'options' => array(
                            'query' => $columns_width,
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),

                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'submenu_content',
                        'autoload_rte' => false,
                        'hide' => true,
                        'lang' => false,
                    ),

                    array(
                        'type' => 'color',
                        'wrapper_hidden' => true,
                        'row_title' => $this->l('Optional submenu style'),
                        'preffix_wrapper' => 'cssstyle-submenu',
                        'accordion_wrapper' => 'cssstyle-submenu-inner',
                        'label' => $this->l('Submenu background color'),
                        'name' => 'submenu_bg_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'image_upload',
                        'label' => $this->l('Background image'),
                        'name' => 'submenu_image',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Submenu Background repeat'),
                        'name' => 'submenu_repeat',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 3,
                                    'name' => $this->l('Repeat XY'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('Repeat X'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Repeat Y'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('No repeat'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Submenu Background position'),
                        'name' => 'submenu_bg_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 8,
                                    'name' => $this->l('left top'),
                                ),
                                array(
                                    'id_option' => 7,
                                    'name' => $this->l('left center'),
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => $this->l('left bottom'),
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => $this->l('right top'),
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => $this->l('right center'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->l('right bottom'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('center top'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('center center'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('center bottom'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Title color'),
                        'name' => 'submenu_title_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Title hover color'),
                        'name' => 'submenu_title_colorh',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Title border color'),
                        'name' => 'submenu_titleb_color',
                        'desc' => $this->l('Optional field. If not set default color will be used.'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu link color'),
                        'name' => 'submenu_link_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu link hover color'),
                        'name' => 'submenu_hover_color',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu border top color'),
                        'name' => 'submenu_border_t',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu border right color'),
                        'name' => 'submenu_border_r',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu border bottom color'),
                        'name' => 'submenu_border_b',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu border left color'),
                        'name' => 'submenu_border_l',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu inner border color'),
                        'name' => 'submenu_border_i',
                        'desc' => $this->l('Optional field. If not set default color will be used'),
                        'size' => 30,
                        'suffix_a_wrapper' => true,
                        'suffix_wrapper' => true,
                    ),
                    array(
                        'type' => 'grid_creator',
                        'label' => '',
                        'col' => 12,
                        'preffix_wrapper' => 'grid-submenu',
                        'wrapper_hidden' => true,
                        'name' => 'grid_creator',
                        'suffix_wrapper' => true,
                    ),
                    array(
                        'type' => 'tabs_choice',
                        'label' => '',
                        'name' => 'tabs_choice',
                        'lang' => true,
                        'suffix_wrapper' => true,
                        'preffix_wrapper' => 'tabs-submenu',
                        'wrapper_hidden' => true,
                    ),
                    array(
                        'type' => 'group',
                        'label' => $this->l('Group access'),
                        'name' => 'groupBox',
                        'values' => Group::getGroups(Context::getContext()->language->id),
                        'info_introduction' => $this->l('You now have three default customer groups.'),
                        'unidentified' => $unidentified_group_information,
                        'guest' => $guest_group_information,
                        'customer' => $default_group_information,
                        'hint' => $this->l('Mark all of the customer groups which you would like to have access to this menu tab.'),
                    ),

                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
        if (Shop::isFeatureActive()) {
            $fields_form['form']['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }

        $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'menu_type');

        $selected_tabs = '';
        $submenu_content = '';
        $submenu_content_format = array();
        if (Tools::isSubmit('id_tab') && IqitMenuTab::tabExists((int)Tools::getValue('id_tab'))) {
            $tab = new IqitMenuTab((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab');

            if ($tab->submenu_type == 1) {
                $selected_tabs = $tab->submenu_content;
            }

            if ($tab->submenu_type == 2 && $tab->submenu_content != '') {
                $submenu_content = $tab->submenu_content;
                $submenu_content_format = $this->buildSubmenuTree(Tools::jsonDecode($tab->submenu_content, true),
                    false);
            }
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = 'iqitmegamenu_tabs';
        $helper->show_cancel_button = true;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->id = (int)Tools::getValue('id_tab');
        $helper->identifier = 'id_tab';
        $helper->submit_action = 'submitAddTab';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code,
            ),
            'fields_value' => $this->getAddFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'module_path' => $this->_path,
            'va_links_select' => $this->renderChoicesSelect(null, null, 'select-links-ids'),
            'custom_html_select' => $this->renderCustomHtmlSelect(),
            'manufacturers_select' => $this->renderManufacturersSelect(),
            'suppliers_select' => $this->renderSuppliersSelect(),
            'categories_select' => $this->renderCategoriesSelect(false),
            'choices_tabs' => $this->renderChoicesTabsSelect(),
            'selected_tabs' => $this->renderSelectedTabsSelect($selected_tabs),
            'submenu_content' => htmlentities($submenu_content, ENT_COMPAT, 'UTF-8'),
            'submenu_content_format' => $submenu_content_format,
            'image_baseurl' => $this->_path . 'images/',
        );

        $helper->override_folder = '/';

        return $helper->generateForm(array($fields_form));
    }

    public function getAddFieldsValues()
    {
        $fields = array();

        $fields['menu_type'] = (int)Tools::getValue('menu_type');

        $fields['active'] = true;
        $fields['active_label'] = false;
        $fields['icon'] = '';
        $fields['icon_class'] = '';
        $fields['legend_icon'] = '';

        $fields['url_type'] = 0;
        $fields['icon_type'] = 0;
        $fields['id_url'] = 0;

        $fields['new_window'] = false;
        $fields['float'] = false;

        $fields['bg_color'] = '';
        $fields['txt_color'] = '';
        $fields['h_bg_color'] = '';
        $fields['h_txt_color'] = '';
        $fields['labelbg_color'] = '';
        $fields['labeltxt_color'] = '';

        //submenu
        $fields['submenu_type'] = 0;
        $fields['submenu_content'] = '';
        $fields['submenu_width'] = 12;
        $fields['submenu_bg_color'] = '';
        $fields['submenu_image'] = '';
        $fields['submenu_repeat'] = '';
        $fields['submenu_bg_position'] = '';
        $fields['submenu_link_color'] = '';
        $fields['submenu_hover_color'] = '';
        $fields['submenu_title_color'] = '';
        $fields['submenu_title_colorh'] = '';
        $fields['submenu_titleb_color'] = '';
        $fields['submenu_border_t'] = '';
        $fields['submenu_border_r'] = '';
        $fields['submenu_border_b'] = '';
        $fields['submenu_border_l'] = '';
        $fields['submenu_border_i'] = '';

        if (Tools::isSubmit('id_tab') && IqitMenuTab::tabExists((int)Tools::getValue('id_tab'))) {
            $tab = new IqitMenuTab((int)Tools::getValue('id_tab'));

            $fields['id_tab'] = (int)Tools::getValue('id_tab', $tab->id);
            $fields['active'] = $tab->active;
            $fields['active_label'] = $tab->active_label;
            $fields['url_type'] = $tab->url_type;
            $fields['icon_type'] = $tab->icon_type;
            $fields['id_url'] = $tab->id_url;
            $fields['new_window'] = $tab->new_window;
            $fields['float'] = $tab->float;
            $fields['icon'] = $tab->icon;
            $fields['icon_class'] = $tab->icon_class;
            $fields['legend_icon'] = $tab->legend_icon;
            $fields['bg_color'] = $tab->bg_color;
            $fields['txt_color'] = $tab->txt_color;
            $fields['h_bg_color'] = $tab->h_bg_color;
            $fields['h_txt_color'] = $tab->h_txt_color;
            $fields['labelbg_color'] = $tab->labelbg_color;
            $fields['labeltxt_color'] = $tab->labeltxt_color;

            //submenu
            $fields['submenu_type'] = $tab->submenu_type;
            $fields['submenu_content'] = $tab->submenu_content;
            $fields['submenu_width'] = $tab->submenu_width;
            $fields['submenu_bg_color'] = $tab->submenu_bg_color;
            $fields['submenu_image'] = $tab->submenu_image;
            $fields['submenu_repeat'] = $tab->submenu_repeat;
            $fields['submenu_bg_position'] = $tab->submenu_bg_position;
            $fields['submenu_link_color'] = $tab->submenu_link_color;
            $fields['submenu_hover_color'] = $tab->submenu_hover_color;
            $fields['submenu_title_color'] = $tab->submenu_title_color;
            $fields['submenu_title_colorh'] = $tab->submenu_title_colorh;
            $fields['submenu_titleb_color'] = $tab->submenu_titleb_color;
            $fields['submenu_border_t'] = $tab->submenu_border_t;
            $fields['submenu_border_r'] = $tab->submenu_border_r;
            $fields['submenu_border_b'] = $tab->submenu_border_b;
            $fields['submenu_border_l'] = $tab->submenu_border_l;
            $fields['submenu_border_i'] = $tab->submenu_border_i;

            $group_access = unserialize($tab->group_access);

            foreach ($group_access as $group => $value) {
                $fields['groupBox_' . $group] = $value;
            }
        } else {
            $tab = new IqitMenuTab();

            $groups = Group::getGroups($this->context->language->id);

            foreach ($groups as $group) {
                $fields['groupBox_' . $group['id_group']] = true;
            }
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields['title'][$lang['id_lang']] = Tools::getValue('title_' . (int)$lang['id_lang'],
                $tab->title[$lang['id_lang']]);
            $fields['url'][$lang['id_lang']] = Tools::getValue('url_' . (int)$lang['id_lang'],
                $tab->url[$lang['id_lang']]);
            $fields['label'][$lang['id_lang']] = Tools::getValue('label_' . (int)$lang['id_lang'],
                $tab->label[$lang['id_lang']]);
        }

        return $fields;
    }

    public function renderAddHtmlForm()
    {
        $fields_form = array(
            'form' => array(
                'tab_name' => 'main_tab',
                'legend' => array(
                    'title' => $this->l('Add custom html'),
                    'icon' => 'icon-cogs',
                    'id' => 'fff',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Name'),
                        'name' => 'title',
                        'desc' => $this->l('Custom html name, Only for backoffice purposes'),
                        'lang' => false,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Html content'),
                        'name' => 'html',
                        'lang' => true,
                        'autoload_rte' => true,
                        'desc' => $this->l('Custom html content which you can later select in submenu'),
                        'cols' => 60,
                        'rows' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    'button' => array(
                        'name' => 'back_to_configuration',
                        'type' => 'submit',
                        'icon' => 'process-icon-back',
                        'class' => 'btn btn-default pull-left',
                        'title' => $this->l('Back'),
                    )
                ),

            ),
        );

        if (Tools::isSubmit('id_html') && IqitMenuHtml::htmlExists((int)Tools::getValue('id_html'))) {
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_html');
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAddHtml';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code,
            ),
            'fields_value' => $this->getAddHtmlFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'module_path' => $this->_path,
            'image_baseurl' => $this->_path . 'images/',
        );

        $helper->override_folder = '/';

        return $helper->generateForm(array($fields_form));
    }

    public function getAddHtmlFieldsValues()
    {
        $fields = array();

        $fields['title'] = '';

        if (Tools::isSubmit('id_html') && IqitMenuHtml::htmlExists((int)Tools::getValue('id_html'))) {
            $html = new IqitMenuHtml((int)Tools::getValue('id_html'));
            $fields['id_html'] = (int)Tools::getValue('id_html', $html->id);
            $fields['title'] = $html->title;
        } else {
            $html = new IqitMenuHtml();
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields['html'][$lang['id_lang']] = Tools::getValue('html_' . (int)$lang['id_lang'],
                $html->html[$lang['id_lang']]);
        }

        return $fields;
    }

    public function buildSubmenuTree(array $dataset, $frontend = false, $cssgenerator = false)
    {
        $id_lang = (int)Context::getContext()->language->id;

        $tree = array();
        foreach ($dataset as $id => &$node) {
            if ($cssgenerator) {

                //set style
                if (isset($node['content_s']['br_top_st'])) {
                    $node['content_s']['br_top_st'] = $this->convertBorderType($node['content_s']['br_top_st']);
                }

                if (isset($node['content_s']['br_right_st'])) {
                    $node['content_s']['br_right_st'] = $this->convertBorderType($node['content_s']['br_right_st']);
                }

                if (isset($node['content_s']['br_bottom_st'])) {
                    $node['content_s']['br_bottom_st'] = $this->convertBorderType($node['content_s']['br_bottom_st']);
                }

                if (isset($node['content_s']['br_left_st'])) {
                    $node['content_s']['br_left_st'] = $this->convertBorderType($node['content_s']['br_left_st']);
                }
            }
            if ($frontend) {
                if (isset($node['content_s']['title'][$id_lang]) && $node['content_s']['title'][$id_lang] != '') {
                    $node['content_s']['title'] = $node['content_s']['title'][$id_lang];
                } else {
                    unset($node['content_s']['title']);
                }

                if (isset($node['content_s']['href'][$id_lang]) && $node['content_s']['href'][$id_lang] != '') {
                    $node['content_s']['href'] = $node['content_s']['href'][$id_lang];
                } else {
                    unset($node['content_s']['href']);
                }

                if (isset($node['content_s']['legend'][$id_lang]) && $node['content_s']['legend'][$id_lang] != '') {
                    $node['content_s']['legend'] = $node['content_s']['legend'][$id_lang];
                } else {
                    unset($node['content_s']['legend']);
                }

                //set variouse links
                if (isset($node['contentType'])) {
                    switch ($node['contentType']) {
                        case 1:
                            if (isset($node['content']['ids'])) {
                                $customhtml = new IqitMenuHtml((int)$node['content']['ids'], $id_lang);

                                if (Validate::isLoadedObject($customhtml)) {
                                    $node['content']['ids'] = $customhtml->html;
                                }
                            }
                            break;
                        case 2:
                            if (isset($node['content']['ids'])) {
                                if ($node['content']['treep']) {
                                    $node['content']['depth']++;
                                }

                                foreach ($node['content']['ids'] as $key => $category) {
                                    $node['content']['ids'][$key] = $this->generateCategoriesMenu(Category::getNestedCategories($node['content']['ids'][$key],
                                        $id_lang, true, $this->user_groups, true, '', $this->hor_sm_order),
                                        $node['content']['depth'], 1, $node['content']['sublimit'], 0, false,
                                        $node['content']);
                                }
                            }
                            break;
                        case 3:
                            if (isset($node['content']['ids'])) {
                                foreach ($node['content']['ids'] as $key => $link) {
                                    $node['content']['ids'][$key] = $this->transformToLink($link, true);
                                }
                            }
                            break;
                        case 6:
                            if (isset($node['content']['source'][$id_lang]) && $node['content']['source'][$id_lang] != '') {
                                $node['content']['source'] = $node['content']['source'][$id_lang];
                            } else {
                                unset($node['content']['source']);
                            }

                            if (isset($node['content']['size'][$id_lang]) && $node['content']['size'][$id_lang] != '') {
                                $node['content']['size'] = $node['content']['size'][$id_lang];
                            } else {
                                unset($node['content']['size']);
                            }

                            if (isset($node['content']['href'][$id_lang]) && $node['content']['href'][$id_lang] != '') {
                                $node['content']['href'] = $node['content']['href'][$id_lang];
                            } else {
                                unset($node['content']['href']);
                            }

                            if (isset($node['content']['alt'][$id_lang]) && $node['content']['alt'][$id_lang] != '') {
                                $node['content']['alt'] = $node['content']['alt'][$id_lang];
                            } else {
                                unset($node['content']['alt']);
                            }

                            break;
                    }
                }
            }

            if (isset($node['contentType']) && $node['contentType'] == 4) {
                if (isset($node['content']['ids']) && !empty($node['content']['ids'])) {
                    $node['content']['ids'] = $this->getProducts($node['content']['ids'], $frontend);
                }
            }

            if ($node['parentId'] === 0) {
                $tree[$id] = &$node;
            } else {
                if (!isset($dataset[$node['parentId']]['children'])) {
                    $dataset[$node['parentId']]['children'] = array();
                }

                $dataset[$node['parentId']]['children'][$id] = &$node;
            }
        }

        $tree = $this->sortArrayTree($tree);
        return $tree;
    }

    public function sortArrayTree($passedTree)
    {
        usort($passedTree, array($this, 'sortByPosition'));

        foreach ($passedTree as $key => $subtree) {
            if (!empty($subtree['children'])) {
                $passedTree[$key]['children'] = $this->sortArrayTree($subtree['children']);
            }
        }

        return $passedTree;
    }

    public function sortByPosition($a, $b)
    {
        return $a['position'] - $b['position'];
    }

    protected function renderForm()
    {
        $fields_form_global = array(
            'form' => array(
                'tab_name' => 'main_tab',
                'legend' => array(
                    'title' => $this->l('Horizontal menu'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l(''),
                        'name' => 'hm_design_info',
                    ),
                ),
            ),
        );

        $fields_form_submenustyl = array(
            'form' => array(
                'tab_name' => 'submenudesign_tab',
                'legend' => array(
                    'title' => $this->l('Submenu options'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l(''),
                        'name' => 'sub_design_info',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Subcategories order'),
                        'name' => 'hor_sm_order',
                        'desc' => $this->l('Affects horizontal, vertical and mobile menu'),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Alphabetical'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->l('Default'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'name' => 'submitHorizonalMenuConfig',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $fields_form_vertical = array(
            'form' => array(
                'tab_name' => 'vertical_tab',
                'legend' => array(
                    'title' => $this->l('Vertical menu'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l(''),
                        'name' => 'vm_design_info',
                    ),
                ),
            ),
        );

        $fields_form_submenutabs = array(
            'form' => array(
                'tab_name' => 'submenutabs_tab',
                'legend' => array(
                    'title' => $this->l('Predefinied submenu tabs'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l('You can select this tabs in vertical or horizontal menu'),
                        'name' => '',
                    ),
                ),
            ),
        );

        $fields_form_html = array(
            'form' => array(
                'tab_name' => 'customhtml_tab',
                'legend' => array(
                    'title' => $this->l('Predefinied custom html content'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l('You can select this html content in submenu'),
                        'name' => '',
                    ),
                ),
            ),
        );

        $fields_form_mobile = array(
            'form' => array(
                'tab_name' => 'mobile_tab',
                'legend' => array(
                    'title' => $this->l('Mobile menu'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'custom_info',
                        'label' => $this->l(''),
                        'name' => 'mm_design_info',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Depth limit'),
                        'name' => 'mobile_menu_depth',
                        'desc' => $this->l('Push menu will float from left site,'),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 4,
                                    'name' => $this->l('4'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->l('3'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('2'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('1'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'link_choice',
                        'label' => '',
                        'name' => 'link',
                        'lang' => true,
                    ),
                ),
                'submit' => array(
                    'name' => 'submitMobileMenu',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $fields_form_custom = array(
            'form' => array(
                'tab_name' => 'customlinks_tab',
                'assigned_list' => $this->renderListCustomLinks(),
                'legend' => array(
                    'title' => $this->l('Custom links'),
                    'icon' => 'icon-link',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Label'),
                        'name' => 'label',
                        'lang' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link'),
                        'name' => 'link',
                        'lang' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('New window'),
                        'name' => 'new_window',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'name' => 'submitBlocktopmenuLinks',
                    'title' => $this->l('Add'),
                ),
            ),
        );

        $fields_form_ietool = array(
            'form' => array(
                'tab_name' => 'ietool_tab',
                'legend' => array(
                    'title' => $this->l('Import/export'),
                    'icon' => 'icon-download',
                ),
                'input' => array(
                    array(
                        'type' => 'ietool',
                        'label' => $this->l('Import export tool'),
                        'name' => 'ietool-name',
                    ),
                ),
            ),

        );

        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitiqitmegamenuModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        if (Tools::getIsset('updateiqitmenulinks') && !Tools::getValue('updateiqitmenulinks')) {
            $fields_form_custom['form']['submit'] = array(
                'name' => 'updateiqitmenulinks',
                'title' => $this->l('Update'),
            );
        }

        if (Tools::isSubmit('updateiqitmenulinks')) {
            $fields_form_custom['form']['input'][] = array('type' => 'hidden', 'name' => 'updatelink');
            $fields_form_custom['form']['input'][] = array('type' => 'hidden', 'name' => 'id_iqitmenulinks');
        }

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'module_path' => $this->_path,
            'id_language' => $this->context->language->id,
            'choices' => $this->renderChoicesSelect(null, null, null, true),
            'selected_links' => $this->makeMenuOptionMobile(),
        );

        return $helper->generateForm(array(
            $fields_form_global,
            $fields_form_vertical,
            $fields_form_mobile,
            $fields_form_submenutabs,
            $fields_form_submenustyl,
            $fields_form_html,
            $fields_form_ietool,
            $fields_form_custom
        ));
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $var = array();
        $id_shop = (int)Context::getContext()->shop->id;

        foreach ($this->defaults_mobile as $default => $value) {
            $var[$default] = Configuration::get($this->config_name . '_' . $default);
        }
        foreach ($this->defaults_horizontal as $default => $value) {
            if ($default == 'hor_search_border' || $default == 'hor_titlep_borders' || $default == 'hor_border_top' || $default == 'hor_border_bottom' || $default == 'hor_border_sides' || $default == 'hor_border_inner' || $default == 'hor_sm_border_top' || $default == 'hor_sm_border_bottom' || $default == 'hor_sm_border_sides' || $default == 'hor_sm_border_inner') {
                $tmpborder = explode(';', Configuration::get($this->config_name . '_' . $default));

                $var[$default]['width'] = $tmpborder[0];
                $var[$default]['type'] = $tmpborder[1];
                $var[$default]['color'] = $tmpborder[2];
            } else {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }
        }
        foreach ($this->defaults_vertical as $default => $value) {
            if ($default == 'ver_border_top' || $default == 'ver_border_bottom' || $default == 'ver_border_sides' || $default == 'ver_border_inner') {
                $tmpborder = explode(';', Configuration::get($this->config_name . '_' . $default));

                $var[$default]['width'] = $tmpborder[0];
                $var[$default]['type'] = $tmpborder[1];
                $var[$default]['color'] = $tmpborder[2];
            } else {
                $var[$default] = Configuration::get($this->config_name . '_' . $default);
            }
        }
        if (Tools::getIsset('updateiqitmenulinks') && (int)Tools::getValue('id_iqitmenulinks') > 0) {
            $var['updatelink'] = true;
            $var['id_iqitmenulinks'] = (int)Tools::getValue('id_iqitmenulinks');

            $link = IqitMenuLinks::getLinkLang((int)Tools::getValue('id_iqitmenulinks'), $id_shop);

            $var['new_window'] = $link['new_window'];

            foreach (Language::getLanguages(false) as $lang) {
                $var['link'][(int)$lang['id_lang']] = (isset($link['link'][$lang['id_lang']]) ? $link['link'][$lang['id_lang']] : '');
                $var['label'][(int)$lang['id_lang']] = (isset($link['label'][$lang['id_lang']]) ? $link['label'][$lang['id_lang']] : '');
            }
        } else {
            foreach (Language::getLanguages(false) as $lang) {
                $var['link'][(int)$lang['id_lang']] = '';
                $var['label'][(int)$lang['id_lang']] = '';
            }
            $var['new_window'] = false;
        }
        return $var;
    }

    public function generateCss($allShops = false)
    {
        $css = '/* IqitMegaMenu */';


        $tabs = array();
        $tabsV = array();
        $tabs = IqitMenuTab::getTabsFrontend(1, true);
        $tabsV = IqitMenuTab::getTabsFrontend(2, true);
        $tabs = array_merge($tabs, $tabsV);

        foreach ($tabs as $key => $tab) {
            if ($tabs[$key]['bg_color'] != '' || $tabs[$key]['txt_color'] != '') {
                $css .= '.cbp-hrmenu > ul > li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' > a, .cbp-hrmenu > ul > li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' > span.cbp-main-link
								{
									' . ($tabs[$key]['bg_color'] != '' ? 'background-color: ' . $tabs[$key]['bg_color'] . ';' : '') . '
									' . ($tabs[$key]['txt_color'] != '' ? 'color: ' . $tabs[$key]['txt_color'] . ';' : '') . '
								}' . PHP_EOL;
            }

            if ($tabs[$key]['h_bg_color'] != '' || $tabs[$key]['h_txt_color'] != '') {
                $css .= '.cbp-hrmenu > ul > li.cbp-hropen#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' > a, .cbp-hrmenu > ul > li.cbp-hropen#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' > a:hover
								{
									' . ($tabs[$key]['h_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['h_bg_color'] . ';' : '') . '
									' . ($tabs[$key]['h_txt_color'] != '' ? 'color: ' . $tabs[$key]['h_txt_color'] . ';' : '') . '
								}' . PHP_EOL;
            }

            if ($tabs[$key]['labeltxt_color'] != '' || $tabs[$key]['labelbg_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-legend-main{
										' . ($tabs[$key]['labelbg_color'] != '' ? 'background-color: ' . $tabs[$key]['labelbg_color'] . ';' : '') . '
										' . ($tabs[$key]['labeltxt_color'] != '' ? 'color: ' . $tabs[$key]['labeltxt_color'] . ';' : '') . '
									}' . PHP_EOL;
            }

            if ($tabs[$key]['labelbg_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-legend-main .cbp-legend-arrow{
											' . ($tabs[$key]['labelbg_color'] != '' ? 'color: ' . $tabs[$key]['labelbg_color'] . ';' : '') . '
										}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_bg_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-triangle-top{
												border-bottom-color: ' . $tabs[$key]['submenu_bg_color'] . ';
											}';
            }

            if ($tabs[$key]['submenu_bg_color'] != '' || $tabs[$key]['submenu_image'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner {
													' . ($tabs[$key]['submenu_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['submenu_bg_color'] . ';' : '') . '
													' . ($tabs[$key]['submenu_image'] != '' ? 'background-image: url(' . $tabs[$key]['submenu_image'] . ');' : '') . '
													background-repeat: ' . $this->convertBgRepeat($tabs[$key]['submenu_repeat']) . ';
													background-position: ' . $this->convertBgPosition($tabs[$key]['submenu_bg_position']) . ';

												}
												.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' ul.cbp-hrsub-level2 {
													' . ($tabs[$key]['submenu_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['submenu_bg_color'] . ';' : '') . '
												}
												';
            }

            if ($tabs[$key]['submenu_title_color'] != '') {
                $css .= '
												.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner .cbp-column-title, .cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner a.cbp-column-title:link {
													color: ' . $tabs[$key]['submenu_title_color'] . '!important;
												}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_title_colorh'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner a.cbp-column-title:hover {
														color: ' . $tabs[$key]['submenu_title_colorh'] . '!important;
													}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_titleb_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner .cbp-column-title {
															border-color: ' . $tabs[$key]['submenu_titleb_color'] . ';
														}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_link_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . '  .cbp-menu-column-inner a:link, .cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner a, .cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-menu-column-inner {
																color: ' . $tabs[$key]['submenu_link_color'] . '!important;
															}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_hover_color'] != '') {
                $css .= '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . '  .cbp-menu-column-inner a:hover {
																	color: ' . $tabs[$key]['submenu_hover_color'] . ' !important;
																}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_border_t'] != '') {
                $css .= '
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner{
																	border-top-color: ' . $tabs[$key]['submenu_border_t'] . ';
																}
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-triangle-top-back{
																	border-bottom-color: ' . $tabs[$key]['submenu_border_t'] . ';
																}
																' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_border_r'] != '') {
                $css .= '
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner{
																	border-right-color: ' . $tabs[$key]['submenu_border_r'] . ';
																}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_border_b'] != '') {
                $css .= '
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner{
																	border-bottom-color: ' . $tabs[$key]['submenu_border_b'] . ';
																}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_border_l'] != '') {
                $css .= '
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner{
																	border-left-color: ' . $tabs[$key]['submenu_border_l'] . ';
																}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_border_i'] != '') {
                $css .= '
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner .menu_column, .cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-tabs-names li,
																.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab'] . ' .cbp-hrsub-inner .cbp-tab-pane
																{
																	border-color: ' . $tabs[$key]['submenu_border_i'] . ';
																}' . PHP_EOL;
            }


            if ($tab['submenu_type'] == 2) {
                if (Tools::strlen(($tab['submenu_content']))) {
                    $css .= $this->generateSubmenuCss($this->buildSubmenuTree(Tools::jsonDecode($tab['submenu_content'],
                        true), true, true), '.cbp-hrmenu li#cbp-hrmenu-tab-' . $tabs[$key]['id_tab']);
                }
            }
        }


        $tabs = IqitMenuTab::getTabsFrontend(3, true);

        foreach ($tabs as $key => $tab) {
            if ($tabs[$key]['bg_color'] != '' || $tabs[$key]['txt_color'] != '') {
                $css .= '.cbp-hrmenu .cbp-hrsub-inner .cbp-tabs-names li.innertab-' . $tabs[$key]['id_tab'] . ' a
																		{
																			' . ($tabs[$key]['bg_color'] != '' ? 'background-color: ' . $tabs[$key]['bg_color'] . '!important;;' : '') . '
																			' . ($tabs[$key]['txt_color'] != '' ? 'color: ' . $tabs[$key]['txt_color'] . '!important;' : '') . '
																		}' . PHP_EOL;
            }

            if ($tabs[$key]['h_bg_color'] != '' || $tabs[$key]['h_txt_color'] != '') {
                $css .= '.cbp-hrmenu .cbp-hrsub-inner .cbp-tabs-names li.innertab-' . $tabs[$key]['id_tab'] . ' a:hover, .cbp-hrmenu .cbp-hrsub-inner .cbp-tabs-names li.innertab-' . $tabs[$key]['id_tab'] . ' a.active,
																		.cbp-tabs-names li.innertab-' . $tabs[$key]['id_tab'] . ' .cbp-inner-border-hider
																		{
																			' . ($tabs[$key]['h_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['h_bg_color'] . '!important;' : '') . '
																			' . ($tabs[$key]['h_txt_color'] != '' ? 'color: ' . $tabs[$key]['h_txt_color'] . '!important;' : '') . '
																		}' . PHP_EOL;
            }

            if ($tabs[$key]['labeltxt_color'] != '' || $tabs[$key]['labelbg_color'] != '') {
                $css .= '.cbp-hrmenu li.innertab-' . $tabs[$key]['id_tab'] . ' .cbp-legend-inner{
																				' . ($tabs[$key]['labelbg_color'] != '' ? 'background-color: ' . $tabs[$key]['labelbg_color'] . ';' : '') . '
																				' . ($tabs[$key]['labeltxt_color'] != '' ? 'color: ' . $tabs[$key]['labeltxt_color'] . ';' : '') . '
																			}' . PHP_EOL;
            }

            if ($tabs[$key]['labelbg_color'] != '') {
                $css .= '.cbp-hrmenu li.innertab-' . $tabs[$key]['id_tab'] . ' .cbp-legend-inner .cbp-legend-arrow{
																					' . ($tabs[$key]['labelbg_color'] != '' ? 'color: ' . $tabs[$key]['labelbg_color'] . ';' : '') . '
																				}' . PHP_EOL;
            }

            if ($tabs[$key]['labelbg_color'] != '') {
                $css .= '.cbp-hrmenu li.innertab-' . $tabs[$key]['id_tab'] . ' .cbp-legend-inner .cbp-legend-arrow{
																						' . ($tabs[$key]['labelbg_color'] != '' ? 'color: ' . $tabs[$key]['labelbg_color'] . ';' : '') . '
																					}' . PHP_EOL;
            }

            if ($tabs[$key]['submenu_bg_color'] != '' || $tabs[$key]['submenu_image'] != '') {
                $css .= '.cbp-hrmenu .innertabcontent-' . $tabs[$key]['id_tab'] . '{
																							' . ($tabs[$key]['submenu_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['submenu_bg_color'] . ';' : '') . '
																							' . ($tabs[$key]['submenu_image'] != '' ? 'background-image: url(' . $tabs[$key]['submenu_image'] . ');' : '') . '
																							background-repeat: ' . $this->convertBgRepeat($tabs[$key]['submenu_repeat']) . ';
																							background-position: ' . $this->convertBgPosition($tabs[$key]['submenu_bg_position']) . ';
																						}
																						.cbp-hrmenu .innertabcontent-' . $tabs[$key]['id_tab'] . ' ul.cbp-hrsub-level2 {
																							' . ($tabs[$key]['submenu_bg_color'] != '' ? 'background-color: ' . $tabs[$key]['submenu_bg_color'] . '!important;' : '') . '
																						}
																						';
            }

            if ($tab['submenu_type'] == 2) {
                if (Tools::strlen(($tab['submenu_content']))) {
                    $css .= $this->generateSubmenuCss($this->buildSubmenuTree(Tools::jsonDecode($tab['submenu_content'],
                        true), true, true), '.cbp-hrmenu .innertabcontent-' . $tabs[$key]['id_tab']);
                }
            }
        }


        $css = trim(preg_replace('/\s+/', ' ', $css));


        if ($allShops) {
            $shops = Shop::getShopsCollection();
            foreach ($shops as $shop) {
                $myFile = $this->local_path . "views/css/iqitmegamenu_s_" . (int)$shop->id . ".css";
                file_put_contents($myFile, $css);
            }
            self::clearAssetsCache();
        } else {
            if (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $myFile = $this->local_path . "views/css/iqitmegamenu_s_" . (int)$this->context->shop->getContextShopID() . ".css";

                if (file_put_contents($myFile, $css)) {
                    self::clearAssetsCache();
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function generateSubmenuCss($submenu, $parent)
    {
        $css = '' . PHP_EOL;
        foreach ($submenu as $key => $element) {
            if (isset($element['content_s']['bg_color']) ||
                isset($element['content_s']['br_top_st']) ||
                isset($element['content_s']['br_right_st']) ||
                isset($element['content_s']['br_bottom_st']) ||
                isset($element['content_s']['br_left_st']) ||
                isset($element['content_s']['c_m_t']) ||
                isset($element['content_s']['c_m_r']) ||
                isset($element['content_s']['c_m_b']) ||
                isset($element['content_s']['c_m_l'])
            ) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner{
															' . (isset($element['content_s']['bg_color']) && $element['content_s']['bg_color'] != '' ? 'background-color: ' . $element['content_s']['bg_color'] . ';' : '') . '
															' . (isset($element['content_s']['br_top_st']) && $element['content_s']['br_top_st'] != '' ? 'border-top-style: ' . $element['content_s']['br_top_st'] . ';' : '') . '
															' . (isset($element['content_s']['br_top_wh']) && $element['content_s']['br_top_wh'] != '' ? 'border-top-width: ' . $element['content_s']['br_top_wh'] . 'px;' : '') . '
															' . (isset($element['content_s']['br_right_st']) && $element['content_s']['br_right_st'] != '' ? 'border-right-style: ' . $element['content_s']['br_right_st'] . ';' : '') . '
															' . (isset($element['content_s']['br_right_wh']) && $element['content_s']['br_right_wh'] != '' ? 'border-right-width: ' . $element['content_s']['br_right_wh'] . 'px;' : '') . '
															' . (isset($element['content_s']['br_bottom_st']) && $element['content_s']['br_bottom_st'] != '' ? 'border-bottom-style: ' . $element['content_s']['br_bottom_st'] . ';' : '') . '
															' . (isset($element['content_s']['br_bottom_wh']) && $element['content_s']['br_bottom_wh'] != '' ? 'border-bottom-width: ' . $element['content_s']['br_bottom_wh'] . 'px;' : '') . '
															' . (isset($element['content_s']['br_left_st']) && $element['content_s']['br_left_st'] != '' ? 'border-left-style: ' . $element['content_s']['br_left_st'] . ';' : '') . '
															' . (isset($element['content_s']['br_left_wh']) && $element['content_s']['br_left_wh'] != '' ? 'border-left-width: ' . $element['content_s']['br_left_wh'] . 'px;' : '') . '

															' . (isset($element['content_s']['br_top_c']) && $element['content_s']['br_top_c'] != '' ? 'border-top-color: ' . $element['content_s']['br_top_c'] . ';' : '') . '
															' . (isset($element['content_s']['br_right_c']) && $element['content_s']['br_right_c'] != '' ? 'border-right-color: ' . $element['content_s']['br_right_c'] . ';' : '') . '
															' . (isset($element['content_s']['br_bottom_c']) && $element['content_s']['br_bottom_c'] != '' ? 'border-bottom-color: ' . $element['content_s']['br_bottom_c'] . ';' : '') . '
															' . (isset($element['content_s']['br_left_c']) && $element['content_s']['br_left_c'] != '' ? 'border-left-color: ' . $element['content_s']['br_left_c'] . ';' : '') . '

															' . (isset($element['content_s']['c_m_t']) ? 'margin-top: -10px;' : '') . '
															' . (isset($element['content_s']['c_m_r']) ? 'margin-right: -10px;' : '') . '
															' . (isset($element['content_s']['c_m_b']) ? 'margin-bottom: -10px;' : '') . '
															' . (isset($element['content_s']['c_m_l']) ? 'margin-left: -10px;' : '') . '

															' . (isset($element['content_s']['c_p_t']) ? 'padding-top: 10px;' : '') . '
															' . (isset($element['content_s']['c_p_r']) ? 'padding-right: 10px;' : '') . '
															' . (isset($element['content_s']['c_p_b']) ? 'padding-bottom: 10px;' : '') . '
															' . (isset($element['content_s']['c_p_l']) ? 'padding-left: 10px;' : '') . '

														}
														' . $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner ul.cbp-hrsub-level2 {
															' . (isset($element['content_s']['bg_color']) && $element['content_s']['bg_color'] != '' ? 'background-color: ' . $element['content_s']['bg_color'] . '!important;' : '') . '
														}

														' . PHP_EOL;
            }

            if (isset($element['content_s']['legend_bg']) || isset($element['content_s']['legend_txt'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner .cbp-legend-inner{
																' . (isset($element['content_s']['legend_bg']) && $element['content_s']['legend_bg'] != '' ? 'background-color: ' . $element['content_s']['legend_bg'] . ';' : '') . '
																' . (isset($element['content_s']['legend_txt']) && $element['content_s']['legend_txt'] != '' ? 'color: ' . $element['content_s']['legend_txt'] . ';' : '') . '

															}' . PHP_EOL;

                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner .cbp-legend-arrow{
																' . (isset($element['content_s']['legend_bg']) && $element['content_s']['legend_bg'] != '' ? 'color: ' . $element['content_s']['legend_bg'] . ';' : '') . '

															}' . PHP_EOL;
            }

            if (isset($element['content_s']['title_color'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner .cbp-column-title{
																color: ' . $element['content_s']['title_color'] . ' !important;
															}' . PHP_EOL;
            }

            if (isset($element['content_s']['title_colorh'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner .cbp-column-title:hover{
																	color: ' . $element['content_s']['title_colorh'] . ' !important;
																}' . PHP_EOL;
            }

            if (isset($element['content_s']['title_borderc'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner .cbp-column-title{
																		border-color: ' . $element['content_s']['title_borderc'] . ' !important;
																	}' . PHP_EOL;
            }

            if (isset($element['content_s']['txt_color'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner a:link, ' . $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner a,' . $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner {
																			color: ' . $element['content_s']['txt_color'] . '!important;
																		}' . PHP_EOL;
            }

            if (isset($element['content_s']['txt_colorh'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . ' > .cbp-menu-column-inner a:hover {
																				color: ' . $element['content_s']['txt_colorh'] . '!important;
																			}' . PHP_EOL;
            }

            if (isset($element['content']['absolute'])) {
                $css .= $parent . ' .menu-element-id-' . $element['elementId'] . '{
																					' . (isset($element['content']['i_a_t']) && $element['content']['i_a_t'] != '' ? 'top: ' . $element['content']['i_a_t'] . 'px;' : '') . '
																					' . (isset($element['content']['i_a_r']) && $element['content']['i_a_r'] != '' ? 'right: ' . $element['content']['i_a_r'] . 'px;' : '') . '
																					' . (isset($element['content']['i_a_b']) && $element['content']['i_a_b'] != '' ? 'bottom: ' . $element['content']['i_a_b'] . 'px;' : '') . '
																					' . (isset($element['content']['i_a_l']) && $element['content']['i_a_l'] != '' ? 'left: ' . $element['content']['i_a_l'] . 'px;' : '') . '
																				}' . PHP_EOL;
            }

            if (isset($element['children'])) {
                $css .= $this->generateSubmenuCss($element['children'], $parent);
            }
        }

        return $css;
    }

    public static function clearAssetsCache()
    {
        $files = glob(_PS_THEME_DIR_.'assets/cache/*');

        foreach ($files as $file) {
            if ('index.php' !== basename($file)) {
                Tools::deleteFile($file);
            }
        }

        $version = (int) Configuration::get('PS_CCCJS_VERSION');
        Configuration::updateValue('PS_CCCJS_VERSION', ++$version);
        $version = (int) Configuration::get('PS_CCCCSS_VERSION');
        Configuration::updateValue('PS_CCCCSS_VERSION', ++$version);
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $jsVars = array();

        $this->user_groups = ($this->context->customer->isLogged() ? $this->context->customer->getGroups() : array(Configuration::get('PS_UNIDENTIFIED_GROUP')));
        $this->hor_sm_order = (Configuration::get($this->config_name . '_hor_sm_order') == 1 ? ' ORDER BY c.`level_depth` ASC, cl.`name` ASC' : '');

        $this->context->controller->registerJavascript('modules' . $this->name . '-script',
            'modules/' . $this->name . '/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);

        $jsVars['sticky'] = 'false';

        $jsVars['containerSelector'] = '#wrapper > .container';

        Media::addJsDef(array(
            'iqitmegamenu' => $jsVars
        ));

        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style',
            'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);

        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->context->controller->registerStylesheet('modules-' . $this->name . '-style-custom',
                'modules/' . $this->name . '/views/css/iqitmegamenu_s_' . (int)$this->context->shop->getContextShopID() . '.css',
                ['media' => 'all', 'priority' => 151]);
        }

        if ($this->context->language->is_rtl) {
            $this->context->controller->registerStylesheet('modules-' . $this->name . '-style-rtl',
                'modules/' . $this->name . '/views/css/rtl.css', ['media' => 'all', 'priority' => 152]);
        }
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayVerticalMenu\d*$/', $hookName)) {

            if ($this->verticalPosition == 'leftColumn' || ($this->context->controller->php_self != 'index' && $this->verticalPosition == 'hiddenLeft')) {
                $templateFile = 'vertical.tpl';
            } else {
                return;
            }

        } elseif (preg_match('/^displayVerticalMenuElementor\d*$/', $hookName)) {
            $templateFile = 'vertical.tpl';
        } elseif ((preg_match('/^displayMainMenu\d*$/', $hookName))) {
            $templateFile = 'horizontal.tpl';
        }

        if (!$this->isCached('module:' . $this->name . '/views/templates/hook/' .$templateFile, $this->getCacheId())) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile, $this->getCacheId());
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayVerticalMenu\d*$/', $hookName)) {
            return $this->_prepareHookVertical();
        } elseif (preg_match('/^displayVerticalMenuElementor\d*$/', $hookName)) {
            return $this->_prepareHookVertical();
        }elseif ((preg_match('/^displayMainMenu\d*$/', $hookName))) {
            $varsHorizontal = $this->_prepareHook();
            $varsVertical = array();


            if ($this->verticalPosition == 'horizontal' || ($this->context->controller->php_self != 'index' && $this->verticalPosition == 'hiddenHorizontal')) {
                $varsVertical = $this->_prepareHookVertical(2);
            }
            return array_merge($varsHorizontal, $varsVertical);
        }
    }

    public function _prepareHookVertical($pos = 0)
    {
        $menu_settings_v = array(
            'ver_position' => $pos,
        );

        $options = [
            'menu_settings_v' => $menu_settings_v,
            'vertical_menu' => $this->makeMegaMenu(2),
        ];

        if ($this->sidebarHeader){
            $options['mobile_menu_v'] = $this->makeMenuMobile();
        }

        return $options;
    }

    public function _prepareHook()
    {
        $menu_settings = array();

        $small = Image::getSize(ImageType::getFormattedName('small'));

        return [
            'mobile_menu' => $this->makeMenuMobile(),
            'menu_settings' => $menu_settings,
            'horizontal_menu' => $this->makeMegaMenu(1),
            'this_path' => $this->_path,
            'homeSize' => Image::getSize(ImageType::getFormattedName('home')),
            'mediumSize' => $small,
            'manufacturerSize' => $small,

        ];
    }

    public function renderSelectedTabsSelect($tabs)
    {
        $id_shop = (int)Context::getContext()->shop->id;
        $id_lang = (int)Context::getContext()->language->id;
        $html = '<select name="items[]" id="items" multiple="multiple" style="width: 300px; height: 160px;" >';
        if (Tools::strlen($tabs)) {
            $tabs = explode(',', $tabs);
            foreach ($tabs as $tab_id) {
                $tab = new IqitMenuTab($tab_id, $id_lang, $id_shop);
                $html .= '<option selected="selected" value="' . $tab->id . '">' . $tab->title . '(id: ' . $tab->id . ')</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public function renderChoicesTabsSelect()
    {
        $tabs = array();
        $tabs = IqitMenuTab::getTabs(3);
        $html = '<select name="availableItems" id="availableItems" multiple="multiple" style="width: 300px; height: 160px;" >';
        foreach ($tabs as $tab) {
            $html .= '<option value="' . $tab['id_tab'] . '">' . $tab['title'] . '(id: ' . $tab['id_tab'] . ')</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function renderManufacturersSelect()
    {
        $return_manufacturers = array();
        $manufacturers = Manufacturer::getManufacturers(false, $this->context->language->id);
        foreach ($manufacturers as $key => $manufacturer) {
            $return_manufacturers[$key]['name'] = $manufacturer['name'];
            $return_manufacturers[$key]['id'] = $manufacturer['id_manufacturer'];
        }
        return $return_manufacturers;
    }

    public function renderSuppliersSelect()
    {
        $return_suppliers = array();
        $suppliers = Supplier::getSuppliers(false, $this->context->language->id);
        foreach ($suppliers as $key => $supplier) {
            $return_suppliers[$key]['name'] = $supplier['name'];
            $return_suppliers[$key]['id'] = $supplier['id_supplier'];
        }
        return $return_suppliers;
    }

    public function renderCategoriesSelect($frontend)
    {
        $return_categories = array();
        $return_categories = $this->generateCategoriesOption2(Category::GetNestedCategories(null,
            (int)$this->context->language->id, true), $frontend);
        return $return_categories;
    }

    public function renderCustomHtmlSelect()
    {
        $custom_html = array();
        $custom_html = IqitMenuHtml::getHtmls();
        return $custom_html;
    }

    public function renderChoicesSelect($single = false, $name = null, $class = null, $mobile = false)
    {
        $spacer = str_repeat('-', $this->spacer_size);
        $items = array();

        $html = '<select ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($mobile ? 'id="availableItems"' : '') . ' ' . ($name ? 'name="' . $name . '" id="' . $name . '"' : '') . ' ' . ($single ? '' : 'multiple="multiple" style="width: 300px; height: 160px;"') . '>';
        $html .= '<option value="HOME0">' . $this->l('Homepage') . '</option>';
        $html .= '<optgroup label="' . $this->l('CMS') . '">';
        $html .= $this->getCMSOptions(0, 1, $this->context->language->id, $items, $single);
        $html .= '</optgroup>';

        // BEGIN SUPPLIER
        $html .= '<optgroup label="' . $this->l('Supplier') . '">';
        // Option to show all Suppliers
        $html .= '<option value="ALLSUP0">' . $this->l('All suppliers') . '</option>';
        $suppliers = Supplier::getSuppliers(false, $this->context->language->id);
        foreach ($suppliers as $supplier) {
            if (!in_array('SUP' . $supplier['id_supplier'], $items)) {
                $html .= '<option value="SUP' . $supplier['id_supplier'] . '">' . $spacer . $supplier['name'] . '</option>';
            }
        }

        $html .= '</optgroup>';

        // BEGIN Manufacturer
        $html .= '<optgroup label="' . $this->l('Manufacturer') . '">';
        $html .= '<option value="ALLMAN0">' . $this->l('All manufacturers') . '</option>';
        $manufacturers = Manufacturer::getManufacturers(false, $this->context->language->id);
        foreach ($manufacturers as $manufacturer) {
            if (!in_array('MAN' . $manufacturer['id_manufacturer'], $items)) {
                $html .= '<option value="MAN' . $manufacturer['id_manufacturer'] . '">' . $spacer . $manufacturer['name'] . '</option>';
            }
        }

        $html .= '</optgroup>';

        $shop = new Shop((int)Shop::getContextShopID());
        $html .= '<optgroup label="' . $this->l('Categories') . '">';
        $html .= $this->generateCategoriesOption(Category::GetNestedCategories(null, (int)$this->context->language->id,
            true), $single);
        $html .= '</optgroup>';

        // BEGIN Shops
        if (Shop::isFeatureActive()) {
            $html .= '<optgroup label="' . $this->l('Shops') . '">';
            $shops = Shop::getShopsCollection();
            foreach ($shops as $shop) {
                if (!$shop->setUrl() && !$shop->getBaseURL()) {
                    continue;
                }

                if (!in_array('SHOP' . (int)$shop->id, $items)) {
                    $html .= '<option value="SHOP' . (int)$shop->id . '">' . $spacer . $shop->name . '</option>';
                }
            }
            $html .= '</optgroup>';
        }

        // BEGIN Products
        if ($mobile) {
            $html .= '<optgroup label="' . $this->l('Products') . '">';
            $html .= '<option value="PRODUCT" style="font-style:italic">' . $spacer . $this->l('Choose product ID') . '</option>';
            $html .= '</optgroup>';
        }
        // BEGIN Menu Top Links
        $html .= '<optgroup label="' . $this->l('Custom links') . '">';
        $links = IqitMenuLinks::gets($this->context->language->id, (int)Shop::getContextShopID(), null);
        foreach ($links as $link) {
            if ($link['label'] == '') {
                $default_language = Configuration::get('PS_LANG_DEFAULT');
                $link = IqitMenuLinks::get($link['id_iqitmenulinks'], $default_language, (int)Shop::getContextShopID());
                if (!in_array('LNK' . (int)$link[0]['id_iqitmenulinks'], $items)) {
                    $html .= '<option value="LNK' . (int)$link[0]['id_iqitmenulinks'] . '">' . $spacer . Tools::safeOutput($link[0]['label']) . '</option>';
                }
            } elseif (!in_array('LNK' . (int)$link['id_iqitmenulinks'], $items)) {
                $html .= '<option value="LNK' . (int)$link['id_iqitmenulinks'] . '">' . $spacer . Tools::safeOutput($link['label']) . '</option>';
            }
        }
        $html .= '</optgroup>';
        $html .= '</select>';
        return $html;
    }

    private function getMenuItems()
    {
        $items = Tools::getValue('items');
        if (is_array($items) && count($items)) {
            return $items;
        } else {
            $shops = Shop::getContextListShopID();
            $conf = null;

            if (count($shops) > 1) {
                foreach ($shops as $key => $shop_id) {
                    $shop_group_id = Shop::getGroupFromShop($shop_id);
                    $conf .= (string)($key > 1 ? ',' : '') . Configuration::get($this->config_name . '_mobile_menu',
                            null, $shop_group_id, $shop_id);
                }
            } else {
                $shop_id = (int)$shops[0];
                $shop_group_id = Shop::getGroupFromShop($shop_id);
                $conf = Configuration::get($this->config_name . '_mobile_menu', null, $shop_group_id, $shop_id);
            }

            if (Tools::strlen($conf)) {
                return explode(',', $conf);
            } else {
                return array();
            }
        }
    }

    private function makeMenuOptionMobile()
    {
        $id_shop = (int)Shop::getContextShopID();

        $menu_item = $this->getMenuItems();
        $id_lang = (int)$this->context->language->id;

        $html = '<select multiple="multiple" name="items[]" id="items" style="width: 300px; height: 160px;">';
        foreach ($menu_item as $item) {
            if (!$item) {
                continue;
            }
            preg_match($this->pattern, $item, $values);
            $id = (int)Tools::substr($item, Tools::strlen($values[1]), Tools::strlen($item));

            switch (Tools::substr($item, 0, Tools::strlen($values[1]))) {
                case 'CAT':
                    $category = new Category((int)$id, (int)$id_lang);
                    if (Validate::isLoadedObject($category)) {
                        $html .= '<option selected="selected" value="CAT' . $id . '">' . $category->name . '</option>' . PHP_EOL;
                    }

                    break;

                case 'CMS_CAT':
                    $category = new CMSCategory((int)$id, (int)$id_lang);
                    if (Validate::isLoadedObject($category)) {
                        $html .= '<option selected="selected" value="CMS_CAT' . $id . '">' . $category->name . '</option>' . PHP_EOL;
                    }

                    break;

                case 'PRD':
                    $product = new Product((int)$id, true, (int)$id_lang);
                    if (Validate::isLoadedObject($product)) {
                        $html .= '<option selected="selected" value="PRD' . $id . '">' . $product->name . '</option>' . PHP_EOL;
                    }

                    break;

                case 'CMS':
                    $cms = new CMS((int)$id, (int)$id_lang);
                    if (Validate::isLoadedObject($cms)) {
                        $html .= '<option selected="selected" value="CMS' . $id . '">' . $cms->meta_title . '</option>' . PHP_EOL;
                    }

                    break;

                // Case to handle the option to show all Manufacturers
                case 'ALLMAN':
                    $html .= '<option selected="selected" value="ALLMAN0">' . $this->l('All manufacturers') . '</option>' . PHP_EOL;
                    break;

                case 'MAN':
                    $manufacturer = new Manufacturer((int)$id, (int)$id_lang);
                    if (Validate::isLoadedObject($manufacturer)) {
                        $html .= '<option selected="selected" value="MAN' . $id . '">' . $manufacturer->name . '</option>' . PHP_EOL;
                    }

                    break;

                // Case to handle the option to show all Suppliers
                case 'ALLSUP':
                    $html .= '<option selected="selected" value="ALLSUP0">' . $this->l('All suppliers') . '</option>' . PHP_EOL;
                    break;

                case 'HOME':
                    $html .= '<option selected="selected" value="HOME0">' . $this->l('Homepage') . '</option>' . PHP_EOL;
                    break;

                case 'SUP':
                    $supplier = new Supplier((int)$id, (int)$id_lang);
                    if (Validate::isLoadedObject($supplier)) {
                        $html .= '<option selected="selected" value="SUP' . $id . '">' . $supplier->name . '</option>' . PHP_EOL;
                    }

                    break;

                case 'LNK':
                    $link = IqitMenuLinks::get((int)$id, (int)$id_lang, (int)$id_shop);
                    if (count($link)) {
                        if (!isset($link[0]['label']) || ($link[0]['label'] == '')) {
                            $default_language = Configuration::get('PS_LANG_DEFAULT');
                            $link = IqitMenuLinks::get($link[0]['id_iqitmenulinks'], (int)$default_language,
                                (int)Shop::getContextShopID());
                        }
                        $html .= '<option selected="selected" value="LNK' . (int)$link[0]['id_iqitmenulinks'] . '">' . Tools::safeOutput($link[0]['label']) . '</option>';
                    }
                    break;

                case 'SHOP':
                    $shop = new Shop((int)$id);
                    if (Validate::isLoadedObject($shop)) {
                        $html .= '<option selected="selected" value="SHOP' . (int)$id . '">' . $shop->name . '</option>' . PHP_EOL;
                    }

                    break;
            }
        }
        return $html . '</select>';
    }

    private function getCMSOptions(
        $parent = 0,
        $depth = 1,
        $id_lang = false,
        $items_to_skip = null,
        $single = false,
        $id_shop = false
    ) {
        $html = '';
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang, (int)$id_shop);
        $pages = $this->getCMSPages((int)$parent, (int)$id_lang, (int)$id_shop);

        $spacer = str_repeat('-', $this->spacer_size * (int)$depth);

        foreach ($categories as $category) {
            if (isset($items_to_skip) && !in_array('CMS_CAT' . $category['id_cms_category'], $items_to_skip)) {
                $html .= '<option value="CMS_CAT' . $category['id_cms_category'] . '" style="font-weight: bold;" >' . $spacer . $category['name'] . '</option>';
            }

            $html .= $this->getCMSOptions($category['id_cms_category'], (int)$depth + 1, (int)$id_lang, $items_to_skip,
                $single);
        }

        foreach ($pages as $page) {
            if (isset($items_to_skip) && !in_array('CMS' . $page['id_cms'], $items_to_skip)) {
                $html .= '<option value="CMS' . $page['id_cms'] . '">' . $spacer . $page['meta_title'] . '</option>';
            }
        }

        return $html;
    }

    private function getCMSCategories($recursive = false, $parent = 1, $id_lang = false, $id_shop = false)
    {
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $join_shop = '';
        $where_shop = '';

        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $join_shop = ' INNER JOIN `' . _DB_PREFIX_ . 'cms_category_shop` cs
			ON (bcp.`id_cms_category` = cs.`id_cms_category`)';
            $where_shop = ' AND cs.`id_shop` = ' . (int)$id_shop . ' AND cl.`id_shop` = ' . (int)$id_shop;
        }

        if ($recursive === false) {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `' . _DB_PREFIX_ . 'cms_category` bcp' .
                $join_shop . '
				INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = ' . (int)$id_lang . '
				AND bcp.`id_parent` = ' . (int)$parent .
                $where_shop;

            return Db::getInstance()->executeS($sql);
        } else {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `' . _DB_PREFIX_ . 'cms_category` bcp' .
                $join_shop . '
				INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = ' . (int)$id_lang . '
				AND bcp.`id_parent` = ' . (int)$parent .
                $where_shop;

            $results = Db::getInstance()->executeS($sql);
            $categories = array();
            foreach ($results as $result) {
                $sub_categories = $this->getCMSCategories(true, $result['id_cms_category'], (int)$id_lang);
                if ($sub_categories && count($sub_categories) > 0) {
                    $result['sub_categories'] = $sub_categories;
                }

                $categories[] = $result;
            }

            return isset($categories) ? $categories : false;
        }
    }

    private function getCMSPages($id_cms_category, $id_lang = false, $id_shop = false)
    {
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

        $where_shop = '';
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $where_shop = ' AND cl.`id_shop` = ' . (int)$id_shop;
        }

        $sql = 'SELECT c.`id_cms`, cl.`meta_title`, cl.`link_rewrite`
			FROM `' . _DB_PREFIX_ . 'cms` c
			INNER JOIN `' . _DB_PREFIX_ . 'cms_shop` cs
			ON (c.`id_cms` = cs.`id_cms`)
			INNER JOIN `' . _DB_PREFIX_ . 'cms_lang` cl
			ON (c.`id_cms` = cl.`id_cms`)
			WHERE c.`id_cms_category` = ' . (int)$id_cms_category . '
			AND cs.`id_shop` = ' . (int)$id_shop . '
			AND cl.`id_lang` = ' . (int)$id_lang .
            $where_shop . '
			AND c.`active` = 1
			ORDER BY `position`';

        return Db::getInstance()->executeS($sql);
    }

    private function generateCategoriesOption($categories, $single = false)
    {
        $html = '';

        foreach ($categories as $key => $category) {
            $shop = (object)Shop::getShop((int)$category['id_shop']);
            $html .= '<option value="CAT' . (int)$category['id_category'] . '" ' . ($single && ($category['level_depth'] == 0 || $category['level_depth'] == 1) ? 'disabled' : '') . '  >'
                . str_repeat('-',
                    $this->spacer_size * (int)$category['level_depth']) . $category['name'] . ' (' . $shop->name . ')</option>';

            if (isset($category['children']) && !empty($category['children'])) {
                $html .= $this->generateCategoriesOption($category['children'], $single);
            }
        }
        return $html;
    }

    private function generateCategoriesOption2($categories, $frontend)
    {
        $return_categories = array();

        foreach ($categories as $key => $category) {
            $shop = (object)Shop::getShop((int)$category['id_shop']);

            $return_categories[$key]['id'] = (int)$category['id_category'];
            $return_categories[$key]['name'] = (!$frontend ? str_repeat('-',
                    $this->spacer_size * (int)$category['level_depth']) : '') . $category['name'] . ' (' . $shop->name . ')';

            if (isset($category['children']) && !empty($category['children'])) {
                $return_categories[$key]['children'] = $this->generateCategoriesOption2($category['children'],
                    $frontend);
            }
        }

        return $return_categories;
    }

    public function getAddLinkFieldsValues()
    {
        $links_label_edit = '';
        $labels_edit = '';
        $fields_values = array();

        if (Tools::getValue('submitAddmodule')) {
            foreach (Language::getLanguages(false) as $lang) {
                $fields_values['label'][$lang['id_lang']] = '';
                $fields_values['link'][$lang['id_lang']] = '';
            }
        } else {
            foreach (Language::getLanguages(false) as $lang) {
                $fields_values['label'][$lang['id_lang']] = Tools::getValue('label_' . (int)$lang['id_lang'],
                    isset($labels_edit[$lang['id_lang']]) ? $labels_edit[$lang['id_lang']] : '');
                $fields_values['link'][$lang['id_lang']] = Tools::getValue('link_' . (int)$lang['id_lang'],
                    isset($links_label_edit[$lang['id_lang']]) ? $links_label_edit[$lang['id_lang']] : '');
            }
        }

        return $fields_values;
    }

    public function renderTabsLinks($menu_type)
    {
        $tabs = array();
        $tabs = IqitMenuTab::getTabs($menu_type);

        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'tabs' => $tabs,
                'iqitdevmode' => $this->iqitdevmode,
                'menu_type' => $menu_type,
            )
        );
        return $this->display(__FILE__, 'list.tpl');
    }

    public function renderHtmlContents()
    {
        $tabs = array();
        $tabs = IqitMenuHtml::getHtmls();

        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'tabs' => $tabs,
            )
        );
        return $this->display(__FILE__, 'list_html.tpl');
    }

    public function renderListCustomLinks()
    {
        $shops = Shop::getContextListShopID();
        $links = array();

        foreach ($shops as $shop_id) {
            $links = array_merge($links, IqitMenuLinks::gets((int)$this->context->language->id, (int)$shop_id, null));
        }

        $fields_list = array(
            'id_iqitmenulinks' => array(
                'title' => $this->l('Link ID'),
                'type' => 'text',
            ),
            'name' => array(
                'title' => $this->l('Shop name'),
                'type' => 'text',
            ),
            'label' => array(
                'title' => $this->l('Label'),
                'type' => 'text',
            ),
            'link' => array(
                'title' => $this->l('Link'),
                'type' => 'link',
            ),
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->identifier = 'id_iqitmenulinks';
        $helper->table = 'iqitmenulinks';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->title = $this->l('Link list');
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        return $helper->generateList($links, $fields_list);
    }

    private function makeMegaMenu($menu_type)
    {
        $id_lang = (int)$this->context->language->id;
        $id_shop = (int)Shop::getContextShopID();

        $tabs = array();

        $tabs = IqitMenuTab::getTabsFrontend($menu_type, false);

        foreach ($tabs as $key => $tab) {
            if (!$tab['url_type']) {
                $trans = $this->transformToLink($tab['id_url'], true, $id_lang, $id_shop);
                if( isset($trans['href'])){
                   $tabs[$key]['url'] = $trans['href'];
               } else{
                $tabs[$key]['url'] = '';
            }
                 
            }

            if ($tab['submenu_type'] == 1) {
                if (Tools::strlen(($tab['submenu_content']))) {
                    $tab['submenu_content'] = explode(',', $tab['submenu_content']);

                    foreach ($tab['submenu_content'] as $tab_id) {
                        $innertab = new IqitMenuTab($tab_id, $id_lang, $id_shop);

                        if (Validate::isLoadedObject($innertab)) {

                            if (!$innertab->verifyAccess()) {
                                unset($tab['submenu_content'][$tab_id]);
                                continue;
                            }

                            if (Tools::strlen(($innertab->submenu_content))) {
                                $arr = Tools::jsonDecode($innertab->submenu_content, true);
                                if(!is_array($arr)){
                                     $arr = array();
                                }
                                $innertab->submenu_content = $this->buildSubmenuTree($arr, true);
                            }

                            if (!$innertab->url_type) {
                                $trans = $this->transformToLink($innertab->id_url, true, $id_lang, $id_shop);
                                if( isset($trans['href'])){
                                    $innertab->url = $trans['href'];
                                } else{
                                    $innertab->url = '';
                                }
                                
                            }

                            $tabs[$key]['submenu_content_tabs'][$tab_id] = $innertab;

                        }

                    }
                }
            }
            if ($tab['submenu_type'] == 2) {
                if (Tools::strlen(($tab['submenu_content']))) {
                    $tabs[$key]['submenu_content'] = $this->buildSubmenuTree(Tools::jsonDecode($tab['submenu_content'],
                        true), true);
                }
            }
        }
        return $tabs;
    }

    private function transformToLink($item, $simple, $id_lang = false, $id_shop = false)
    {
        $id_shop = ($id_shop !== false) ? (int)$id_shop : (int)Context::getContext()->shop->id;
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

        $return_link = array();

        if (!$item) {
            return;
        }

        preg_match($this->pattern, $item, $value);
        $id = (int)Tools::substr($item, Tools::strlen($value[1]), Tools::strlen($item));

        switch (Tools::substr($item, 0, Tools::strlen($value[1]))) {
            case 'CAT':
                if ($simple) {
                    $cat = new Category($id, $id_lang);
                    $link = $cat->getLink();

                    $return_link['title'] = $cat->name;
                    $return_link['href'] = $link;
                }
                break;

            case 'PRD':
                $product = new Product((int)$id, true, (int)$id_lang);
                if (!is_null($product->id)) {
                    $return_link['title'] = $product->name;
                    $return_link['href'] = $product->getLink();
                }
                break;

            case 'CMS_CAT':
                $category = new CMSCategory((int)$id, (int)$id_lang);
                if (!is_null($category->id)) {
                    $return_link['title'] = $category->name;
                    $return_link['href'] = $category->getLink();
                }
                break;

            case 'CMS':
                $cms = CMS::getLinks((int)$id_lang, array($id));
                if (count($cms)) {
                    $return_link['title'] = $cms[0]['meta_title'];
                    $return_link['href'] = $cms[0]['link'];
                }
                break;

            // Case to handle the option to show all Manufacturers
            case 'ALLMAN':
                $link = new Link;
                $return_link['title'] = $this->l('All manufacturers');
                $return_link['href'] = $link->getPageLink('manufacturer');
                break;

            case 'MAN':
                $manufacturer = new Manufacturer((int)$id, (int)$id_lang);
                if (!is_null($manufacturer->id)) {
                    if (!$manufacturer->active) {
                        return;
                    }

                    if ((int)Configuration::get('PS_REWRITING_SETTINGS')) {
                        $manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
                    } else {
                        $manufacturer->link_rewrite = 0;
                    }

                    $link = new Link;
                    $return_link['title'] = $manufacturer->name;
                    $return_link['href'] = $link->getManufacturerLink((int)$id, $manufacturer->link_rewrite);
                }
                break;

            // Case to handle the option to show all Suppliers
            case 'ALLSUP':
                $link = new Link;
                $return_link['title'] = $this->l('All suppliers');
                $return_link['href'] = $link->getPageLink('supplier');
                break;

            case 'HOME':
                $link = new Link;
                $return_link['title'] = $this->l('Home');
                $return_link['href'] = $link->getPageLink('index');
                break;

            case 'SUP':

                $supplier = new Supplier((int)$id, (int)$id_lang);
                if (!is_null($supplier->id)) {
                    if (!$supplier->active) {
                        return;
                    }

                    $link = new Link;
                    $return_link['title'] = $supplier->name;
                    $return_link['href'] = $link->getSupplierLink((int)$id, $supplier->link_rewrite);
                }
                break;

            case 'SHOP':

                $shop = new Shop((int)$id);
                if (Validate::isLoadedObject($shop)) {
                    $link = new Link;
                    $return_link['title'] = $shop->name;
                    $return_link['href'] = Tools::HtmlEntitiesUTF8($shop->getBaseURL());
                }
                break;
            case 'LNK':
                $link = IqitMenuLinks::get((int)$id, (int)$id_lang, (int)$id_shop);
                if (count($link)) {
                    if (!isset($link[0]['label']) || ($link[0]['label'] == '')) {
                        $default_language = Configuration::get('PS_LANG_DEFAULT');
                        $link = IqitMenuLinks::get($id, $default_language, (int)Shop::getContextShopID());
                    }
                    $return_link['title'] = $link[0]['label'];
                    $return_link['href'] = $link[0]['link'];
                    $return_link['new_window'] = $link[0]['new_window'];
                }
                break;
        }
        return $return_link;
    }

    private function makeMenuMobile()
    {
        $menu_items = $this->getMenuItems();
        $id_lang = (int)$this->context->language->id;
        $id_shop = (int)Shop::getContextShopID();
        $mobile_menu = array();
        $depth_limit = Configuration::get($this->config_name . '_mobile_menu_depth');
        foreach ($menu_items as $item) {
            if (!$item) {
                continue;
            }

            preg_match($this->pattern, $item, $value);
            $id = (int)Tools::substr($item, Tools::strlen($value[1]), Tools::strlen($item));

            switch (Tools::substr($item, 0, Tools::strlen($value[1]))) {
                case 'CAT':
                    $mobile_menu[$item] = $this->generateCategoriesMenu(Category::getNestedCategories($id, $id_lang,
                        true, $this->user_groups, true, '', $this->hor_sm_order), $depth_limit);
                    break;

                case 'CMS_CAT':
                    $category = new CMSCategory((int)$id, (int)$id_lang);
                    if (is_object($category)) {
                        $mobile_menu[$item]['title'] = $category->name;
                        $mobile_menu[$item]['href'] = $category->getLink();
                        $mobile_menu[$item]['children'] = $this->getCMSMenuItems($category->id);
                    }
                    break;

                default:
                    $mobile_menu[$item] = $this->transformToLink($item, true, $id_lang, $id_shop);
            }
        }

        return $mobile_menu;
    }

    protected function getCMSMenuItems($parent, $depth = 1, $id_lang = false)
    {
        $cmspages = array();
        $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

        if ($depth > 3) {
            return;
        }

        $categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang);
        $pages = $this->getCMSPages((int)$parent);

        if (count($categories) || count($pages)) {
            foreach ($categories as $category) {
                $cat = new CMSCategory((int)$category['id_cms_category'], (int)$id_lang);

                $cmspages['cms_cat' . $category['id_cms_category']]['title'] = $category['name'];
                $cmspages['cms_cat' . $category['id_cms_category']]['href'] = $cat->getLink();
                $cmspages['cms_cat' . $category['id_cms_category']]['childrens'] = $this->getCMSMenuItems($category['id_cms_category'],
                    (int)$depth + 1);
            }

            foreach ($pages as $page) {
                $cms = new CMS($page['id_cms'], (int)$id_lang);
                $links = $cms->getLinks((int)$id_lang, array((int)$cms->id));

                $cmspages['cms' . $cms->id]['title'] = $cms->meta_title;
                $cmspages['cms' . $cms->id]['href'] = $links[0]['link'];
            }
        }
        return $cmspages;
    }

    private function generateCategoriesMenu(
        $categories,
        $detph_limit,
        $current_depth = 1,
        $subcat_limit = null,
        $subcat_count = null,
        $subcats = false,
        $node = null
    ) {
        $return_categories = array();

        foreach ($categories as $key => $category) {
            if ($current_depth > $detph_limit) {
                return;
            }

            if (isset($subcat_limit) && isset($subcat_count) && ($subcat_count >= $subcat_limit)) {
                return $return_categories;
            }

            if ($category['level_depth'] > 1) {
                $cat = new Category($category['id_category']);
                $link = $cat->getLink();
            } else {
                $link = $this->context->link->getPageLink('index');
            }

            if ($subcats) {
                $return_categories[$key]['title'] = $category['name'];
                $return_categories[$key]['href'] = $link;
            } else {
                $return_categories['title'] = $category['name'];
                $return_categories['href'] = $link;
            }

            if (isset($node['thumb']) && $node['thumb']) {
                $files = scandir(_PS_CAT_IMG_DIR_);

                if (count(preg_grep('/^' . $category['id_category'] . '-([0-9])?_thumb.jpg/i', $files)) > 0) {
                    foreach ($files as $file) {
                        if (preg_match('/^' . $category['id_category'] . '-([0-9])?_thumb.jpg/i', $file) === 1) {
                            $image_url = $this->context->link->getMediaLink(_THEME_CAT_DIR_ . $file);
                            $return_categories['thumb'] = $image_url;
                            break;
                        }
                    }
                }
            }

            if (isset($category['children']) && !empty($category['children'])) {
                if ($subcats) {
                    $return_categories[$key]['children'] = $this->generateCategoriesMenu($category['children'],
                        $detph_limit, $current_depth + 1, $subcat_limit, 0, true, $node);
                } else {
                    $return_categories['children'] = $this->generateCategoriesMenu($category['children'], $detph_limit,
                        $current_depth + 1, $subcat_limit, 0, true, $node);
                }
            }
            $subcat_count++;
        }

        return $return_categories;
    }

    public function convertBgRepeat($value)
    {
        switch ($value) {
            case 3:
                $repeat_option = 'repeat';
                break;
            case 2:
                $repeat_option = 'repeat-x';
                break;
            case 1:
                $repeat_option = 'repeat-y';
                break;
            default:
                $repeat_option = 'no-repeat';
        }
        return $repeat_option;
    }

    public function convertBorderType($type)
    {
        $border_type = 'none';

        switch ($type) {
            case 5:
                $border_type = 'groove';
                break;
            case 4:
                $border_type = 'double';
                break;
            case 3:
                $border_type = 'dotted';
                break;
            case 2:
                $border_type = 'dashed';
                break;
            case 1:
                $border_type = 'solid';
                break;
            default:
                $border_type = 'none';
        }

        return $border_type;
    }

    public function convertBorder($value, $position, $triangle = 0)
    {
        $tmpborder = explode(';', $value);

        $width = $tmpborder[0];
        $type = $tmpborder[1];
        $color = $tmpborder[2];

        switch ($type) {
            case 5:
                $border_type = 'groove';
                break;
            case 4:
                $border_type = 'double';
                break;
            case 3:
                $border_type = 'dotted';
                break;
            case 2:
                $border_type = 'dashed';
                break;
            case 1:
                $border_type = 'solid';
                break;
            default:
                $border_type = 'none';
        }

        $border_code = '';

        if (isset($color) && $color != '') {
            if ($triangle == 1) {
                $border_code = 'left: ' . (-$width) . 'px; border-bottom: ' . (12 + $width) . 'px ' . $border_type . ' ' . $color . '; border-left: ' . (12 + $width) . 'px ' . $border_type . ' transparent; border-right: ' . (12 + $width) . 'px ' . $border_type . ' transparent;';
            } elseif ($triangle == 2) {
                $border_code = 'left: ' . (-(12 + $width)) . 'px; border-right: ' . (12 + $width) . 'px ' . $border_type . ' ' . $color . '; border-bottom: ' . (12 + $width) . 'px ' . $border_type . ' transparent; border-left: ' . (12 + $width) . 'px ' . $border_type . ' transparent;';
            } else {
                if ($position == 'side') {
                    $border_code = 'border-left: ' . $width . 'px ' . $border_type . ' ' . $color . ';' . PHP_EOL;
                    $border_code .= 'border-right: ' . $width . 'px ' . $border_type . ' ' . $color . ';';
                } elseif ($position == 'all') {
                    $border_code = 'border: ' . $width . 'px ' . $border_type . ' ' . $color . ';';
                } else {
                    $border_code = 'border-' . $position . ': ' . $width . 'px ' . $border_type . ' ' . $color . ';';
                }
            }
        }
        return $border_code;
    }

    public function convertBgPosition($value)
    {
        switch ($value) {
            case 8:
                $position_option = 'left top';
                break;
            case 7:
                $position_option = 'left center';
                break;
            case 6:
                $position_option = 'left bottom';
                break;
            case 5:
                $position_option = 'right top';
                break;
            case 4:
                $position_option = 'right center';
                break;
            case 3:
                $position_option = 'right bottom';
                break;
            case 2:
                $position_option = 'center top';
                break;
            case 1:
                $position_option = 'center center';
                break;
            default:
                $position_option = 'center bottom';
        }
        return $position_option;
    }

    public function getProducts($ids, $frontend)
    {
        $products = $this->getProductsByIds($ids, $this->context->language->id);

        if ($frontend){
        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->getTranslator()
        );


        if (is_array($products)) {
            foreach ($products as &$product) {
                $product = $presenter->present(
                    $presentationSettings,
                    Product::getProductProperties($this->context->language->id, $product, $this->context),
                    $this->context->language
                );
            }
            unset($product);
        }
        }
        return $products;
    }

    public function getProductsByIds($ids, $id_lang, $active = true)
    {
        $product_ids = join(',', $ids);

        $id_shop = (int)Context::getContext()->shop->id;

        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`,
					pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
					image_shop.`id_image` id_image, il.`legend`, m.`name` as manufacturer_name, cl.`name` AS category_default, IFNULL(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
					DATEDIFF(
						p.`date_add`,
						DATE_SUB(
							"' . date('Y-m-d') . ' 00:00:00",
							INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY
						)
					) > 0 AS new
				FROM  `' . _DB_PREFIX_ . 'product` p 
				' . Shop::addSqlAssociation('product', 'p') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
					ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int)$id_shop . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
					p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . '
				)
				LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (
					product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('cl') . '
				)
				LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int)$id_shop . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$id_lang . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (p.`id_manufacturer`= m.`id_manufacturer`)
				' . Product::sqlStock('p', 0) . '
				WHERE p.id_product IN (' . $product_ids . ')' .
            ($active ? ' AND product_shop.`active` = 1 AND product_shop.`visibility` != \'none\'' : '') . '
				GROUP BY product_shop.id_product';
        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return false;
        }
        foreach ($result as &$row) {
            $row['id_product_attribute'] = Product::getDefaultAttribute((int)$row['id_product']);
        }
        return Product::getProductsProperties($id_lang, $result);
    }

    public function hookActionObjectCategoryAddAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCategoryUpdateAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCategoryDeleteAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsUpdateAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsDeleteAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsAddAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierUpdateAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierDeleteAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierAddAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerUpdateAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerDeleteAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerAddAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectProductDeleteAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectProductAddAfter($params)
    {
        $this->clearMenuCache();
    }

    public function hookCategoryUpdate($params)
    {
        $this->clearMenuCache();
    }

    public function clearMenuCache()
    {
        $this->_clearCache('*');
    }

    private function installSamples()
    {
        $languages = Language::getLanguages(false);
        $group_access = array();
        $groups = Group::getGroups(Context::getContext()->language->id);
        $id_shop_list = Shop::getCompleteListOfShopsID();

        foreach ($groups as $group) {
            $group_access[$group['id_group']] = true;
        }

        $group_access = serialize($group_access);

        $tab = new IqitMenuTab();
        $tab->menu_type = 1;
        $tab->position = IqitMenuTab::getNextPosition(1);

        $tab->active = 1;
        $tab->active_label = 1;
        $tab->url_type = 0;
        $tab->id_url = 'HOME0';
        $tab->icon_type = 1;
        $tab->icon_class = 'fa-home';
        $tab->bg_color = '#474747';
        $tab->new_window = 0;
        $tab->float = 0;
        $tab->submenu_type = 0;
        $tab->submenu_width = 12;
        $tab->group_access = $group_access;
        $tab->id_shop_list = $id_shop_list;

        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = 'Home';
        }

        $tab->add();
        $tab = new IqitMenuTab();
        $tab->menu_type = 1;
        $tab->position = IqitMenuTab::getNextPosition(1);
        $tab->active = 1;
        $tab->active_label = 0;
        $tab->url_type = 2;
        $tab->icon_type = 1;
        $tab->new_window = 0;
        $tab->float = 0;
        $tab->submenu_type = 0;
        $tab->submenu_width = 12;
        $tab->group_access = $group_access;
        $tab->id_shop_list = $id_shop_list;

        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = 'Sample tab';
        }
        $tab->add();
    }

    public function ajaxProcessSearchProducts()
    {
        header('Content-Type: application/json');

        $query = Tools::getValue('q', false);
        if (!$query or $query == '' or Tools::strlen($query) < 1) {
            die();
        }
        if ($pos = strpos($query, ' (ref:')) {
            $query = Tools::substr($query, 0, $pos);
        }
        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }
        $excludeVirtuals = false;
        $exclude_packs = false;
        $context = Context::getContext();
        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
        FROM `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)$context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image` image
        ON (image.`id_product` = p.`id_product` AND image.cover=1)
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$context->language->id . ')
        WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\') AND p.`active` = 1' .
            (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
            ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
            ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
            ' GROUP BY p.id_product';

        $items = Db::getInstance()->executeS($sql);

        if ($items && ($excludeIds || strpos($_SERVER['HTTP_REFERER'], 'AdminScenes') !== false)) {
            foreach ($items as $item) {
                echo trim($item['name']) . (!empty($item['reference']) ? ' (ref: ' . $item['reference'] . ')' : '') . '|' . (int)($item['id_product']) . "\n";
            }
        } elseif ($items) {
            $results = array();
            foreach ($items as $item) {
                $product = array(
                    'id' => (int)($item['id_product']),
                    'name' => $item['name'],
                    'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                    'image' => str_replace('http://', Tools::getShopProtocol(),
                        $context->link->getImageLink($item['link_rewrite'], $item['id_image'],
                            ImageType::getFormattedName('medium'))),
                );
                array_push($results, $product);
            }
            $results = array_values($results);
            die(json_encode($results));
        } else {
            die(json_encode(new stdClass));
        }
    }

    public function ajaxProcessUpdateHorizontalTabsPosition()
    {
        $tabs = Tools::getValue('tabs');
        foreach ($tabs as $position => $id_tab) {
            $res = Db::getInstance()->execute('
            UPDATE `' . _DB_PREFIX_ . 'iqitmegamenu_tabs` SET `position` = ' . (int)$position . '
            WHERE `id_tab` = ' . (int)$id_tab . ' AND menu_type = 1');
        }
        $this->clearMenuCache();
    }

    public function ajaxProcessupdateVerticalTabsPosition()
    {
        $tabs = Tools::getValue('tabs');
        foreach ($tabs as $position => $id_tab) {
            $res = Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'iqitmegamenu_tabs` SET `position` = ' . (int)$position . '
            WHERE `id_tab` = ' . (int)$id_tab . ' AND menu_type = 2');
        }
        $this->clearMenuCache();
    }

    private function duplicateTab($id_tab)
    {
        $tab = new IqitMenuTab($id_tab);
        $tab->duplicateObject();
    }

    protected function getWarningMultishopHtml()
    {
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return '<p class="alert alert-warning">' .
            $this->l('You cannot manage module from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit') .
            '</p>';
        } else {
            return '';
        }
    }
}
