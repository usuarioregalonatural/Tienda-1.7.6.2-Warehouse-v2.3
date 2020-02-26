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

class AdminIqitReviewsController extends ModuleAdminController
{
    public $name;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'IqitProductReview';
        $this->table = 'iqitreviews_products';
        $this->identifier = 'id_review';

        $this->_defaultOrderBy = 'date_add';
        $this->_defaultOrderWay = 'DESC';
        $this->list_no_link = true;
        $this->_pagination = array(10, 15, 100, 300, 1000);



        $this->addRowAction('delete');

        parent::__construct();

        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->bulk_actions = array(
            'approve' => array(
                'text' => $this->l('Approve'),
                'confirm' => $this->l('Approve selected items?'),
                'icon' => 'icon-power-off text-success'
            ),
            'disapprove' => array(
                'text' => $this->l('Dispprove'),
                'confirm' => $this->l('Disapprove selected items?'),
                'icon' => 'icon-power-off text-danger'
            ),
            'divider' => array(
                'text' => 'divider'
            ),
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            ),
        );

        $this->name = 'IqitReviews';

        $this->fields_list = array(
            'id_review' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'id_product' => array(
                'title' => $this->l('Product'),
                'align' => 'center',
                'callback' => 'formatProduct',
                'class' => 'fixed-width-xs'
            ),
            'title' => array(
                'title' => $this->l('Title'),
            ),
            'rating' => array(
                'title' => $this->l('Rating'),
                'class' => 'fixed-width-xs',
                'callback' => 'formatRating',
                'align' => 'center',
            ),
            'comment' => array(
                'title' => $this->l('Comment'),
                'callback' => 'getCommentClean',
                'orderby' => false
            ),
            'customer_name' => array(
                'title' => $this->l('Author'),
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'type' => 'date'
            ),
            'status' => array(
                'title' => $this->l('Published'),
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!status',
                'class' => 'fixed-width-sm'
            )
        );

        $this->fields_options = array(
            'general' => array(
                'title' => $this->l('General'),
                'icon' => 'icon-cogs',
                'fields' => array(
                    $this->module->cfgName . 'guest' => array(
                        'title' => $this->l('Allow guest reviews'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    $this->module->cfgName . 'autopublish' => array(
                        'title' => $this->l('Autopublish comments'),
                        'hint' => $this->l('If disabled you will have to approve comments manually '),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                ),
                'submit' => array('title' => $this->l('Save'))
            ),
        );
    }

    public function initToolBarTitle()
    {
        $this->toolbar_title[] = $this->l('Themes');
        $this->toolbar_title[] = $this->l('Product reviews');
    }


    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }

    public static function getCommentClean($comment)
    {
        return Tools::getDescriptionClean($comment);
    }

    public static function formatRating($rating)
    {
        return $rating . '/5';
    }

    public static function formatProduct($idProduct)
    {
        $product = new Product((int)$idProduct, false, (int)Context::getContext()->language->id);
        return '<a href="' . Context::getContext()->link->getAdminLink('AdminProducts') . '&id_product=' . (int)$idProduct . '">' . $product->name . ' (id: ' . $idProduct . ')</a>';
    }


    public function postProcess()
    {
        if (Tools::isSubmit('submitBulkapprove'.$this->table)) {
            $this->processBulkApprove();
        } elseif (Tools::isSubmit('submitBulkdisapprove'.$this->table)) {
            $this->processBulkDisapprove();
        }

        parent::postProcess();
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        $this->addJS(_MODULE_DIR_ . $this->module->name . '/views/js/admin.js');
        $this->addCSS(_MODULE_DIR_ . $this->module->name . '/views/css/backoffice.css');
    }

    public function ajaxProcessStatusProductReview()
    {
        header('Content-type: application/json');
        if (!$idReview = (int)Tools::getValue('id_review')) {
            die(json_encode(array('success' => false, 'error' => true, 'text' => $this->l('Failed to update the status'))));
        } else {
            $review = new IqitProductReview((int)$idReview);
            if (Validate::isLoadedObject($review)) {
                $this->module->clearCache($review->id_product);
                $review->status = $review->status == 1 ? 0 : 1;
                $review->save() ?
                    die(json_encode(array('success' => true, 'text' => $this->l('The status has been updated successfully')))) :
                    die(json_encode(array('success' => false, 'error' => true, 'text' => $this->l('Failed to update the status'))));
            }
        }
    }

    protected function processBulkApprove()
    {
        return $this->processBulkApproveSelection(1);
    }

    protected function processBulkDisapprove()
    {
        return $this->processBulkApproveSelection(0);
    }

    protected function processBulkApproveSelection($status)
    {
        $result = true;
        if (is_array($this->boxes) && !empty($this->boxes)) {
            foreach ($this->boxes as $id) {
                /** @var ObjectModel $object */
                $object = new $this->className((int)$id);
                $this->module->clearCache($object->id_product);
                $object->status = (int)$status;
                $result &= $object->update();
            }
        }
        return $result;
    }
}
