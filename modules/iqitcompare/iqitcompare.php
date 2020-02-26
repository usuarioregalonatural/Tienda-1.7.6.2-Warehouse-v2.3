<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
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

class IqitCompare extends Module implements WidgetInterface
{
    protected $config_form = false;
    public $cfgName;

    public function __construct()
    {
        $this->name = 'iqitcompare';
        $this->version = '1.0.0';
        $this->author = 'iqit-commerce.com';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->tab = 'front_office_features';
        $this->controllers = array('comparator');

        parent::__construct();
        $this->displayName = $this->l('IQITCOMPARE');
        $this->description = $this->l('Allow customers to compare products');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->defaults = array(
            'productsNb' => 0,
        );
    }

    public function install()
    {
        return (parent::install()
            && $this->setDefaults()
            && $this->registerHook('header')
            && $this->registerHook('displayNav2')
            && $this->registerHook('displayAfterProductAddCartBtn')
            && $this->registerHook('displayProductListFunctionalButtons')
            && $this->registerHook('displayBeforeBodyClosingTag')
        );
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }
        return parent::uninstall();
    }

    public function setDefaults()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::updateValue($this->cfgName . $default, $value);
        }
        return true;
    }


    public function hookHeader()
    {
        $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-script', 'modules/'.$this->name.'/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);

        Media::addJsDef(array('iqitcompare' => [
            'nbProducts' =>  (int) $this->context->cookie->iqitCompareNb
        ]));
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }
        $templateFile = 'display-nav.tpl';
        if (preg_match('/^displayNav2\d*$/', $hookName) || preg_match('/^displayNav\d*$/', $hookName)) {
            $templateFile = 'display-nav.tpl';
        } elseif (preg_match('/^displayProductAdditionalInfo\d*$/', $hookName) || preg_match('/^displayAfterProductAddCartBtn\d*$/', $hookName)) {
            $templateFile = 'product-page.tpl';
        } elseif (preg_match('/^displayHeaderButtons\d*$/', $hookName)) {
            $templateFile = 'display-header-buttons.tpl';    
        } elseif (preg_match('/^displayBeforeBodyClosingTag\d*$/', $hookName)) {
            $templateFile = 'display-modal.tpl';
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

        if (preg_match('/^displayProductListFunctionalButtons\d*$/', $hookName)) {
            return array(
                'id_product_attribute' => $configuration['smarty']->tpl_vars['product']->value['id_product_attribute'],
                'id_product' => $configuration['smarty']->tpl_vars['product']->value['id_product'],
            );
        }
    }

    public function getFeaturesForComparison($idsArray, $idLang)
    {
        if (!Feature::isFeatureActive()) {
            return false;
        }

        $ids = implode(",", $idsArray);

        if (empty($ids)) {
            return false;
        }

        return Db::getInstance()->executeS('
			SELECT f.*, fl.*
			FROM `'._DB_PREFIX_.'feature` f
			LEFT JOIN `'._DB_PREFIX_.'feature_product` fp
				ON f.`id_feature` = fp.`id_feature`
			LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl
				ON f.`id_feature` = fl.`id_feature`
			WHERE fp.`id_product` IN ('.$ids.')
			AND `id_lang` = '.(int)$idLang.'
			GROUP BY f.`id_feature`
			ORDER BY f.`position` ASC
		');
    }
}
