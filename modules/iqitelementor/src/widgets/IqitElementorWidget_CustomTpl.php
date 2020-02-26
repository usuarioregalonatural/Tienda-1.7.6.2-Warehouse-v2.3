<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Adapter\BestSales\BestSalesProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\NewProducts\NewProductsProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\PricesDrop\PricesDropProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

/**
 * Class ElementorWidget_CustomTpl
 */
class IqitElementorWidget_CustomTpl
{
    /**
     * @var int
     */
    public $id_base;

    /**
     * @var string widget name
     */
    public $name;
    /**
     * @var string widget icon
     */
    public $icon;
    public $context;

    protected $spacer_size = '2';

    public $status = 1;
    public $editMode = false;

    public function __construct()
    {

        $this->name = IqitElementorWpHelper::__('Custom Tpl file', 'elementor');
        $this->id_base = 'CustomTpl';
        $this->icon = 'coding';
        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'IqitElementorEditor'){
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $availableTpls = [];

        if ($this->editMode) {
            $dir = $this->context->controller->module->getLocalPath().'views/templates/widgets/customtpls/';

            foreach (glob($dir . '*.tpl') as $file) {
                $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));
                $availableTpls[$fileName] = $fileName;
            }
        }

        return [
            'section_pswidget_options' => [
                'label' => IqitElementorWpHelper::__('Widget settings', 'elementor'),
                'type' => 'section',
            ],
            'file' => [
                'label' => IqitElementorWpHelper::__('File', 'elementor'),
                'type' => 'select',
                'label_block' => true,
                'default' => 'customtpl',
                'description' => IqitElementorWpHelper::__( '
                Sometimes you may need to put some custom smarty content as widget. For example some unique hook etc. You can use this widget for that purpose.
                In configuration box you should put filename, which  exist in directory modules/iqitelementor/views/templates/widgets/customtpls/ you can create own files in this directory', 'elementor' ),
                'section' => 'section_pswidget_options',
                'options' => $availableTpls,
            ],
        ];


    }


    public function parseOptions($optionsSource, $preview = false)
    {
       if (isset($optionsSource['file'])){
            return [
                'file' => $optionsSource['file'],
            ];
        }
        return;
    }

}
