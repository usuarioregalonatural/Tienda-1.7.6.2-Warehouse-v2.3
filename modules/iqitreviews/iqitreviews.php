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

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/src/IqitProductReview.php';

class IqitReviews extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';

    protected $config_form = false;
    public $defaults;
    public $cfgName;

    protected $templatePath;

    public function __construct()
    {
        $this->name = 'iqitreviews';
        $this->version = '1.0.0';
        $this->author = 'iqit-commerce.com';
        $this->tab = 'front_office_features';
        $this->bootstrap = true;

        parent::__construct();
        $this->displayName = $this->l('IQITREVIEWS');
        $this->description = $this->l('Customer reviews and rich snippets');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->cfgName = 'iqitrev_';
        $this->defaults = array(
            //'reminder' => 0,
            'guest' => 0,
            'autopublish' => 0,
        );

        $this->templatePath = 'module:' . $this->name . '/views/templates/hook/';

    }

    public function install()
    {
        return (parent::install()
            && $this->setDefaults()
            && $this->registerHook('header')
            && $this->registerHook('actionObjectProductDeleteAfter')
            && $this->registerHook('displayProductExtraContent')
            && $this->registerHook('displayProductRating')
            && $this->registerHook('displayProductListReviews')
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
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminIqitReviews')
        );
    }

    public function hookHeader()
    {
        $this->context->controller->registerStylesheet('modules-' . $this->name . '-style', 'modules/' . $this->name . '/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules' . $this->name . '-script', 'modules/' . $this->name . '/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);

        Media::addJsDef(array($this->name => [

        ]));
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {
            $array = array();
            $assign = $this->getWidgetVariables($hookName, $configuration);
            $this->smarty->assign($assign);
            $templateFile = 'product-reviews.tpl';

            $array[] = (new ProductExtraContent())
                ->setTitle($this->l('Reviews'))
                ->setContent($this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile));

            return $array;
        }  elseif (preg_match('/^displayFooterProduct\d*$/', $hookName)){
            $assign = $this->getWidgetVariables($hookName, $configuration);
            $this->smarty->assign($assign);
            $templateFile = 'product-reviews-footer.tpl';

            return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile);
        }
        else {
            if (preg_match('/^displayProductRating\d*$/', $hookName) || preg_match('/^displayProductListReviews\d*$/', $hookName)) {
                $templateFile = 'simple-product-rating.tpl';

                $cacheId = 'iqitreviews|simple|'.(int)$configuration['product']['id_product'];

                $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

                return $this->fetch($this->templatePath . $templateFile);
            } else {
                $templateFile = 'product-reviews.tpl';

                $assign = $this->getWidgetVariables($hookName, $configuration);
                $this->smarty->assign($assign);
                return $this->fetch($this->templatePath . '/views/templates/hook/' . $templateFile);
            }
        }
    }


    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayFooterProduct\d*$/', $hookName)) {
            $reviews = IqitProductReview::getByProduct((int)$configuration['product']['id_product']);
            $snippetData = IqitProductReview::getSnippetData((int)$configuration['product']['id_product']);

            return array(
                'reviews' => $reviews,
                'snippetData' => $snippetData,
                'isLogged' => $this->context->customer->isLogged(),
                'allowGuests' => Configuration::get($this->cfgName . 'guest'),
                'idProduct' => (int)$configuration['product']['id_product'],
            );
        } elseif (preg_match('/^displayProductExtraContent\d*$/', $hookName) || preg_match('/^displayFooterProductd*$/', $hookName)) {
            $reviews = IqitProductReview::getByProduct((int)$configuration['product']->id);
            $snippetData = IqitProductReview::getSnippetData((int)$configuration['product']->id);

            return array(
                'reviews' => $reviews,
                'snippetData' => $snippetData,
                'isLogged' => $this->context->customer->isLogged(),
                'allowGuests' => Configuration::get($this->cfgName . 'guest'),
                'idProduct' => (int)$configuration['product']->id,
            );
        } elseif (preg_match('/^displayProductRating\d*$/', $hookName) || preg_match('/^displayProductListReviews\d*$/', $hookName)) {
            $snippetData = IqitProductReview::getSnippetData((int)$configuration['product']['id_product']);

            return array(
                'snippetData' => $snippetData,
            );
        }
    }

    public function hookActionObjectProductDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }

        $idProduct = (int)$params['object']->id;
        IqitProductReview::clearProductReviews($idProduct);
    }

    public function clearCache($idProduct = 0)
    {
        if ($idProduct) {
            $this->_clearCache($this->templatePath . 'simple-product-rating.tpl', $this->name.'|simple|' . $idProduct);
        } else {
            $this->_clearCache($this->templatePath . 'simple-product-rating.tpl');
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
        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }
}
