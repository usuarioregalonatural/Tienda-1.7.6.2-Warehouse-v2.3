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

/**
 * @since 1.5.0
 */
class IqitCompareActionsModuleFrontController extends ModuleFrontController
{
    /**
     * @var int
     */
    public $id_product;

    public function init()
    {
        parent::init();

        $this->id_product = (int)Tools::getValue('id_product');
    }

    public function postProcess()
    {
        if (Tools::getValue('process') == 'remove') {
            $this->processRemove();
        } elseif (Tools::getValue('process') == 'add') {
            $this->processAdd();
        } elseif (Tools::getValue('process') == 'removeAll') {
            $this->processRemoveAll();
        }
    }

    /**
     * Remove a compare product.
     */
    public function processRemove()
    {
        header('Content-Type: application/json');
        $idProduct = (int)Tools::getValue('idProduct');
        $productsIds = $this->context->cookie->iqitCompare;
        $productsIds = json_decode($productsIds, true);
        unset($productsIds[$idProduct]);
        $productsIds = json_encode($productsIds, true);
        $this->context->cookie->__set('iqitCompare', $productsIds);
        $this->context->cookie->__set('iqitCompareNb', (int) $this->context->cookie->iqitCompareNb - 1);

        $this->ajaxDie(json_encode(array(
            'success' => true,
            'data' => [
                'message' => $this->l('Product removed'),
                'type' => 'removed'
            ]
        )));
    }

    /**
     * Remove all compare products.
     */
    public function processRemoveAll()
    {
        header('Content-Type: application/json');

        $productsIds = array();
        $productsIds = json_encode($productsIds, true);
        $this->context->cookie->__set('iqitCompare', $productsIds);
        $this->context->cookie->__set('iqitCompareNb', 0);

        $this->ajaxDie(json_encode(array(
            'success' => true,
            'data' => [
                'message' => $this->l('All products removed'),
                'type' => 'removedAll'
            ]
        )));
    }

    /**
     * Add a compare product.
     */
    public function processAdd()
    {
        header('Content-Type: application/json');

        $idProduct = (int)Tools::getValue('idProduct');

        $productsIds = $this->context->cookie->iqitCompare;
        $productsIds = json_decode($productsIds, true);

        if (!isset($productsIds[$idProduct])) {
            $productsIds[$idProduct] = $idProduct;
            $productsIds = json_encode($productsIds, true);

            $this->context->cookie->__set('iqitCompare', $productsIds);
            $this->context->cookie->__set('iqitCompareNb', (int) $this->context->cookie->iqitCompareNb + 1);

            $this->ajaxDie(json_encode(array(
                'success' => true,
                'data' => [
                    'message' => $this->l('Product added to comparator'),
                    'type' => 'added'
                ]
            )));
        }
    }
}
