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

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class IqitProductTags extends Module implements WidgetInterface
{
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitproducttags';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('IQITPRODUCTTAGS - Product tags');
        $this->description = $this->l('Show tags on product page');

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        return (parent::install() && $this->registerHook('displayProductAdditionalInfo'));
    }

    public function uninstall()
    {
        return (parent::uninstall());
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $idProduct = (int) $configuration['product']['id_product'];

        if (!isset($idProduct) || !$idProduct) {
            return;
        }

        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch($this->templateFile);
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $tags = Tag::getProductTags((int) $configuration['product']['id_product']);
        if (is_array($tags)) {
            if (isset($tags[(int) Context::getContext()->language->id])){
                return array(
                    'tags' => $tags[(int) Context::getContext()->language->id],
                );
            }
        }
        return;
    }
}
