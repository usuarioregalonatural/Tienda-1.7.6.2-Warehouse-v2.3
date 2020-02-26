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

class IqitProductsNav extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'iqitproductsnav';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('IQITPRODUCTSNAV - Next and previouse product link');
        $this->description = $this->l('Show butttons to previouse or next product on product page');
    }

    public function install()
    {
        return (parent::install() && $this->registerHook('displayAfterBreadcrumb'));
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
        $templateFile = 'iqitproductsnav.tpl';

        if ($this->context->controller->php_self != 'product'){
            return;
        }
        if (!isset($configuration['smarty']->tpl_vars['product']->value['id_product'])) {
            return;
        }

        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:'.$this->name.'/views/templates/hook/'.$templateFile);

    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $id_product = (int) $configuration['smarty']->tpl_vars['product']->value['id_product'];
        $id_category_default = (int) $configuration['smarty']->tpl_vars['product']->value['id_category_default'];
        $position = $this->getPositionInCategory($id_product, $id_category_default);

        $previous = $this->getPreviousInCategory($position, $id_category_default);
        $next = $this->getNextInCategory($position, $id_category_default);

        $links = array();

        if (isset($next) && $next > 0) {
            $idProductAttribute = Product::getDefaultAttribute($next);
            $next = $this->context->link->getProductLink($next,
                null,
                null,
                null,
                null,
                null,
                $idProductAttribute);
            $links['next'] = $next;
        } else{
            $first = $this->getFirstInCategory($position, $id_category_default);
            $idProductAttribute = Product::getDefaultAttribute($first);
            if (isset($first) && $first > 0) {
                $first = $this->context->link->getProductLink($first,
                    null,
                    null,
                    null,
                    null,
                    null,
                    $idProductAttribute);
                $links['next'] = $first;
            }
        }

        if (isset($previous) && $previous > 0) {
            $idProductAttribute = Product::getDefaultAttribute($previous);
            $previous = $this->context->link->getProductLink($previous,
                null,
                null,
                null,
                null,
                null,
                $idProductAttribute);
            $links['previous'] = $previous;
        } else{
            $last = $this->getLastInCategory($position, $id_category_default);
            $idProductAttribute = Product::getDefaultAttribute($last);
            if (isset($last) && $last > 0) {
                $last = $this->context->link->getProductLink($last,
                    null,
                    null,
                    null,
                    null,
                    null,
                    $idProductAttribute);
                $links['previous'] = $last;
            }
        }
        return $links;
    }

    public function getPositionInCategory($id_product, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT position
            FROM `'._DB_PREFIX_.'category_product`
            WHERE id_category = '.(int)$id_category.'
            AND id_product = '.(int)$id_product);
        return (int) $result['position'];
    }

    public function getFirstInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position != '.(int)$position.' ORDER BY cp.position ASC');


        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }


    public function getLastInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position != '.(int)$position.' ORDER BY cp.position DESC');


        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }

    public function getNextInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position > '.(int)$position.' ORDER BY cp.position ASC');


        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }

    public function getPreviousInCategory($position, $id_category)
    {
        $result = Db::getInstance()->getRow('SELECT cp.id_product  as id_product
            FROM `'._DB_PREFIX_.'category_product` as cp
            RIGHT JOIN `'._DB_PREFIX_.'product` as p
            ON p.id_product=cp.id_product
            WHERE cp.id_category = '.(int)$id_category.'
            AND p.active = 1
            AND cp.position < '.(int)$position.' ORDER BY cp.position DESC');
        if (isset($result['id_product']))
            return (int) $result['id_product'];
    }

    public function hookHome($params)
    {
        $this->context->cookie->last_visited_category = 2;
    }
}
